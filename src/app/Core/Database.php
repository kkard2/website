<?php
namespace App\Core;

use \App\Models\PageCommentModel;
use \App\Models\UserUsernameModel;

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
            'users.username AS posterUsername ' .
            'FROM comments ' .
            'INNER JOIN users ON users.id = comments.posterId ' .
            'WHERE comments.hide = FALSE ' .
            '  AND comments.slug = ? '
        );
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];

        while ($row = $result->fetch_assoc()) {
            $comments[] = new PageCommentModel(
                (string)$row['id'],
                is_null($row['replyToId']) ? null : (string)$row['replyToId'],
                (string)$row['content'],
                (string)$row['posterUsername'],
            );
        }

        return $comments;
    }

    public function registerUser(
        string $username,
        string $password,
        string $parentId,
    ): bool {
        $stmt = $this->connection->prepare(
            'INSERT INTO users ' .
            '(username, passwordHash, parentId, admin, hide) ' .
            'VALUES ' .
            '(?, ?, ?, FALSE, FALSE) '
        );
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param(
            'sss',
            $username,
            $password,
            $parentId,
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function validateParentKey(string $parentKey): ?string {
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

        return (string)$row['id'];
    }

    public function getUserBySession(string $sessionId): ?UserUsernameModel {
        $this->dropInvalidSessions(); // TODO: this is probably fine; maybe schedule in the future?
        $stmt = $this->connection->prepare(
            'SELECT ' .
            'users.id AS id, ' .
            'users.username AS username ' .
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
            (string)$row['id'],
            (string)$row['username']
        );

        // TODO: change to INTERVAL 14 DAY
        $stmt = $this->connection->prepare('
            UPDATE sessions
            SET validUntil = DATE_ADD(NOW(), INTERVAL 1 HOUR)
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

        // TODO: change to INTERVAL 14 DAY
        $stmt = $this->connection->prepare('
            INSERT INTO sessions
            (id, userId, validUntil)
            VALUES
            (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))
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

    private function dropInvalidSessions(): void {
        $stmt = $this->connection->prepare('DELETE FROM sessions WHERE validUntil < NOW()');
        $stmt->execute();
    }
}
