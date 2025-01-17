<?php
namespace App\Core;

use \App\Models\PageCommentModel;

class Database {
    private function __construct(
        private readonly \mysqli $connection,
        private readonly \mysqli_stmt $getPageCommentsStmt,
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

        $getPageCommentsStmt = $connection->prepare(
            'SELECT ( ' .
            'comments.id as id, ' .
            'comments.replyToId as replyToId, ' .
            'comments.content as content, ' .
            'users.username as posterUsername, ' .
            'FROM comments ' .
            'INNER JOIN users ON users.id = comments.posterId ' .
            'WHERE comments.slug = ? '
        );

        if ($getPageCommentsStmt === false) {
            throw new \Exception("Could not create a prepared statement.");
        }

        return new Database($connection, $getPageCommentsStmt);
    }

    public function close(): void {
        $this->getPageCommentsStmt->close();
        $this->connection->close();
    }

    /** @return list<PageCommentModel> */
    public function getPageComments(string $slug): array {
        $this->getPageCommentsStmt->bind_param('s', $slug);
        $this->getPageCommentsStmt->execute();
        $result = $this->getPageCommentsStmt->get_result();

        $comments = [];

        while ($row = $result->fetch_assoc()) {
            $comments[] = new PageCommentModel(
                (string)$row['id'],
                (string)$row['replyToId'],
                (string)$row['content'],
                (string)$row['posterUsername'],
            );
        }

        return $comments;
    }

/*    /1** @return ?list<UserModel> *1/ */
/*    public function queryUsers(string $query): ?array { */
/*        $result = $this->connection->query($query); */

/*        if (!($result instanceof \mysqli_result)) { */
/*            return null; */
/*        } */

/*        $users = []; */

/*        foreach ($result as $index => $row) { */
/*            if (!is_array($row)) { */
/*                throw new \Exception('Failed to query users'); */
/*            } */
/*            $parentId = array_key_exists('parentId', $row) */
/*                ? ($row['parentId'] === null ? false : (int)$row['parentId']) */
/*                : null; */
/*            $users[] = new UserModel( */
/*                array_key_exists('id', $row)           ? (int)$row['id']              : null, */
/*                array_key_exists('username', $row)     ? (string)$row['username']     : null, */
/*                array_key_exists('passwordHash', $row) ? (string)$row['passwordHash'] : null, */
/*                $parentId, */
/*                array_key_exists('bio', $row)          ? (string)$row['bio']          : null, */
/*            ); */
/*        } */

/*        return $users; */
/*    } */

/*    public function queryUser(string $query): ?UserModel { */
/*        $result = $this->queryUsers($query); */
/*        if ($result === null) { */
/*            return null; */
/*        } */

/*        if (count($result) !== 1) { */
/*            return null; */
/*        } */

/*        return $result[0]; */
/*    } */
}
