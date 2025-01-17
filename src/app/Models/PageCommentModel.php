<?php
namespace App\Models;

class PageCommentModel {
    public function __construct(
        public readonly string $id,
        public readonly string $replyToId,
        public readonly string $content,
        public readonly string $posterUsername,
    ) {}
}
