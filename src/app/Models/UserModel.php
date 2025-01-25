<?php
namespace App\Models;

class UserModel {
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly bool $admin,
        public readonly bool $hide,
        private readonly ?string $bio,
        public readonly ?string $parentUsername,
        public readonly ?string $parentKey,
    ) {}

    public function escapedBio(): ?string {
        if ($this->bio === null) {
            return null;
        }

        return \App\Core\Utils::escapeDatabaseHtml($this->bio);
    }

    public function unescapedBio(): ?string {
        return $this->bio;
    }
}
