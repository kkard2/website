<?php
namespace App\Models;

class CommentModel {
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $parentSlug,
        public readonly null|int|false $replyToId, // false if does not exist
        public readonly ?string $content,
    ) {}
}
