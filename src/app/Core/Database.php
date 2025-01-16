<?php
namespace App\Core;

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

        return new Database($connection);
    }
}
