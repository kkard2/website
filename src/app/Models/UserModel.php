<?php
namespace App\Models;

class UserModel {
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $username,
        public readonly ?string $passwordHash,
        public readonly null|int|false $parentId, // false if does not exist
        public readonly ?string $bio,
    ) {}
}
