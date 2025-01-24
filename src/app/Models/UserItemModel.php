<?php
namespace App\Models;

class UserItemModel {
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly bool $hide,
    ) {}
}
