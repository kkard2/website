<?php
namespace App\Models;

class UserUsernameModel {
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly bool $admin,
    ) {}
}
