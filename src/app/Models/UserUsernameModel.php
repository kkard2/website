<?php
namespace App\Models;

class UserUsernameModel {
    public function __construct(
        public readonly string $id,
        public readonly string $username,
    ) {}
}
