<?php
namespace App\Models;

class UserModel {
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly bool $admin,
        public readonly ?string $bio,
        public readonly ?string $parentUsername,
        public readonly ?string $parentKey,
    ) {}
}
