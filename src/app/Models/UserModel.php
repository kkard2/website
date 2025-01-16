<?php
namespace App\Models;

class UserModel {
    public function __construct(
        private readonly int $id,
        private readonly ?string $username,
        private readonly ?string $passwordHash,
        private readonly ?string $parent,
        private readonly ?string $bio,
    ) {}

    public static function get(
        int $id,
        \App\Core\Database $db,
        bool $username = false,
        bool $passwordHash = false,
        bool $parent = false,
        bool $bio = false,
    ): UserModel {
    }
}
