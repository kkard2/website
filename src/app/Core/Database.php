<?php
namespace App\Core;

use \App\Models\PageCommentModel;
use \App\Models\UserUsernameModel;
use \App\Models\UserItemModel;

class Database {
    private function __construct(
        private readonly \mysqli $connection,
    ) {}

    public static function connect(
        string $hostname,
        string $username,
        string $password,
        string $database,
    ): ?Database {
        $connection = mysqli_connect($hostname, $username, $password, $database);

        if ($connection === false) {
            return null;
        }

        return new Database(
            $connection,
        );
    }

    public function close(): void {
        $this->connection->close();
    }

    /** @return list<PageCommentModel> */
    public function getPageComments(string $slug): array {
        $stmt = $this->connection->prepare(
            'SELECT ' .
            'comments.id AS id, ' .
            'comments.replyToId AS replyToId, ' .
            'comments.content AS content, ' .
            'comments.postedAt AS postedAt, ' .
            'users.username AS posterUsername, ' .
            'comments.slug AS slug ' .
            'FROM comments ' .
            'INNER JOIN users ON users.id = comments.posterId ' .
            'WHERE comments.hide = FALSE ' .
            '  AND comments.slug = ? ' .
            'ORDER BY postedAt DESC '
        );
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];

        while ($row = $result->fetch_assoc()) {
            $comments[] = new PageCommentModel(
                (string)$row['id'],
                is_null($row['replyToId']) ? null : (string)$row['replyToId'],
                // NOTE: i am escaping comments that are stored in the database as is.
                //       this might be bad, because if i forget about it i get xss
                //       for free, but it simplifies adding it to the database logic
                //       (i don't need to count encoding overhead for comment length)
                // TODO: think about this for more than 5 seconds and
                //       potentialy switch to encoding it beforehand
                Utils::escapeDatabaseHtml((string)$row['content']),
                (string)$row['postedAt'],
                (string)$row['posterUsername'],
                (string)$row['slug'],
            );
        }

        return $comments;
    }

    public function registerUser(
        string $username,
        string $password,
        int $parentId,
    ): bool {
        $stmt = $this->connection->prepare(
            'INSERT INTO users ' .
            '(username, passwordHash, parentId, admin, hide) ' .
            'VALUES ' .
            '(?, ?, ?, FALSE, FALSE) '
        );
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param(
            'ssi',
            $username,
            $password,
            $parentId,
        );
        $stmt->execute();
        $result = $stmt->affected_rows > 0;

        $stmt = $this->connection->prepare('
            UPDATE
                users
            SET
                parentKey = NULL
            WHERE
                id = ?
        ');
        $stmt->bind_param('i', $parentId);
        $stmt->execute();

        return $result;
    }

    public function validateParentKey(string $parentKey): ?int {
        $stmt = $this->connection->prepare(
            'SELECT ' .
            'id ' .
            'FROM users ' .
            'WHERE users.parentKey = ? '
        );
        $stmt->bind_param('s', $parentKey);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return null;
        }

        return (int)$row['id'];
    }

    public function getUserBySession(string $sessionId): ?UserUsernameModel {
        $this->dropInvalidSessions(); // TODO: this is probably fine; maybe schedule in the future?
        $stmt = $this->connection->prepare(
            'SELECT ' .
            'users.id AS id, ' .
            'users.username AS username, ' .
            'users.admin AS admin ' .
            'FROM sessions ' .
            'INNER JOIN users ON users.id = sessions.userId ' .
            'WHERE sessions.id = ? '
        );
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return null;
        }

        $result = new UserUsernameModel(
            (int)$row['id'],
            (string)$row['username'],
            (bool)$row['admin'],
        );

        $stmt = $this->connection->prepare('
            UPDATE sessions
            SET validUntil = DATE_ADD(NOW(), INTERVAL 14 DAY)
            WHERE sessions.id = ?
        ');
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();

        return $result;
    }

    // returns true on success, otherwise reason
    public function tryLogIn(
        string $username,
        string $password,
        string $currentSession,
    ): string|true {
        $stmt = $this->connection->prepare(
            'SELECT ' .
            'id, ' .
            'passwordHash, ' .
            'hide ' .
            'FROM users ' .
            'WHERE users.username = ? '
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return 'invalid username or password';
        }

        $id = (string)$row['id'];
        $passwordHash = (string)$row['passwordHash'];
        $hide = (bool)$row['hide'];

        if (!password_verify($password, $passwordHash)) {
            return 'invalid username or password';
        }

        if ($hide) {
            return 'you have been disowned';
        }

        $stmt = $this->connection->prepare('
            INSERT INTO sessions
            (id, userId, validUntil)
            VALUES
            (?, ?, DATE_ADD(NOW(), INTERVAL 14 DAY))
        ');
        $stmt->bind_param('ss', $currentSession, $id);
        $stmt->execute();

        return true;
    }

    public function deleteSession(string $sessionId): void {
        $stmt = $this->connection->prepare('
            DELETE FROM sessions
            WHERE sessions.id = ?
        ');
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
    }

    public function getUser(string $username): ?\App\Models\UserModel {
        $stmt = $this->connection->prepare('
            SELECT
                child.id AS id,
                child.username AS username,
                child.admin AS admin,
                child.hide AS hide,
                child.bio AS bio,
                parent.username AS parentUsername,
                child.parentKey AS parentKey
            FROM
                users AS child
            LEFT JOIN
                users AS parent
            ON
                child.parentId = parent.id
            WHERE
                child.username = ?
        ');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return null;
        }

        return new \App\Models\UserModel(
            (int)$row['id'],
            (string)$row['username'],
            (bool)$row['admin'],
            (bool)$row['hide'],
            $row['bio'] !== null ? (string)$row['bio'] : null,
            $row['parentUsername'] !== null ? (string)$row['parentUsername'] : null,
            $row['parentKey'] !== null ? (string)$row['parentKey'] : null,
        );
    }

    /** @return list<UserItemModel> */
    public function getChildren(int $userId): array {
        $stmt = $this->connection->prepare('
            SELECT
                child.id AS id,
                child.username AS username,
                child.hide AS hide
            FROM
                users AS child
            INNER JOIN
                users AS parent
            ON
                child.parentId = parent.id
            WHERE
                parent.id = ?
        ');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $children = [];

        while ($row = $result->fetch_assoc()) {
            $children[] = new UserItemModel(
                (int)$row['id'],
                (string)$row['username'],
                (bool)$row['hide'],
            );
        }

        return $children;
    }

    public function getParentKey(int $userId): ?string {
        $stmt = $this->connection->prepare('
            SELECT
                parentKey
            FROM
                users
            WHERE
                id = ?
        ');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null || $row['parentKey'] === null) {
            return null;
        }

        return (string)$row['parentKey'];
    }

    public function createParentKey(int $userId): string {
        $result = bin2hex(random_bytes(32));
        $stmt = $this->connection->prepare('
            UPDATE
                users
            SET
                parentKey = ?
            WHERE
                id = ?
        ');
        $stmt->bind_param('ss', $result, $userId);
        $stmt->execute();

        if ($stmt->affected_rows !== 1) {
            throw new \Exception("failed to create parent key");
        }

        return (string)$result;
    }

    /** @return list<string> */
    public function getAllUserUsernames(): array {
        $stmt = $this->connection->prepare('
            SELECT
                username
            FROM
                users
            WHERE
                hide = FALSE
        ');
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = (string)$row['username'];
        }

        return $users;
    }

    public function postComment(
        int $userId,
        string $comment,
        string $slug,
    ): int {
        // TODO: support replies
        $stmt = $this->connection->prepare('
            INSERT INTO comments
                (posterId, content, slug, hide, replyToId, postedAt)
            VALUES
                (?, ?, ?, FALSE, NULL, NOW())
        ');
        $stmt->bind_param('iss', $userId, $comment, $slug);
        $stmt->execute();
        return (int)$stmt->insert_id;
    }

    public function getCommentSlug(
        int $commentId,
    ): ?string {
        $stmt = $this->connection->prepare('
            SELECT
                slug
            FROM
                comments
            WHERE
                id = ?
        ');
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if ($row === null || $row['slug'] === null) {
            return null;
        }

        return (string)$row['slug'];
    }

    public function removeComment(int $commentId): bool {
        $stmt = $this->connection->prepare('
            UPDATE
                comments
            SET
                hide = TRUE
            WHERE
                id = ?
        ');
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function disown(int $userId): void {
        $stmt = $this->connection->prepare('
            UPDATE
                users
            SET
                hide = TRUE
            WHERE
                id = ?
        ');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        // get rid of orphans
        $stmt = $this->connection->prepare('
            UPDATE
                users AS child
            INNER JOIN
                users AS parent
            ON
                parent.id = child.parentId
            SET
                child.hide = TRUE
            WHERE
                parent.hide = TRUE
        ');

        do {
            $stmt->execute();
        } while ($stmt->affected_rows > 0);
    }

    public function adopt(int $parentId, int $orphanId): void {
        $stmt = $this->connection->prepare('
            UPDATE
                users
            SET
                parentId = ?,
                hide = FALSE
            WHERE
                id = ?
        ');
        $stmt->bind_param('ii', $parentId, $orphanId);
        $stmt->execute();
    }

    public function setBio(int $userId, ?string $bio): void {
        $stmt = $this->connection->prepare('
            UPDATE
                users
            SET
                bio = ?
            WHERE
                id = ?
        ');
        // yea, xss situation the same as in comments
        $stmt->bind_param('si', $bio, $userId);
        $stmt->execute();
    }

    /** @return list<PageCommentModel> */
    public function getAllComments(): array {
        $stmt = $this->connection->prepare(
            'SELECT ' .
            'comments.id AS id, ' .
            'comments.replyToId AS replyToId, ' .
            'comments.content AS content, ' .
            'comments.postedAt AS postedAt, ' .
            'users.username AS posterUsername, ' .
            'comments.slug AS slug ' .
            'FROM comments ' .
            'INNER JOIN users ON users.id = comments.posterId ' .
            'WHERE comments.hide = FALSE ' .
            'ORDER BY postedAt DESC '
        );
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];

        while ($row = $result->fetch_assoc()) {
            $comments[] = new PageCommentModel(
                (string)$row['id'],
                is_null($row['replyToId']) ? null : (string)$row['replyToId'],
                // NOTE: same as getPageComments
                Utils::escapeDatabaseHtml((string)$row['content']),
                (string)$row['postedAt'],
                (string)$row['posterUsername'],
                (string)$row['slug'],
            );
        }

        return $comments;
    }

    private function dropInvalidSessions(): void {
        $stmt = $this->connection->prepare('DELETE FROM sessions WHERE validUntil < NOW()');
        $stmt->execute();
    }
}
