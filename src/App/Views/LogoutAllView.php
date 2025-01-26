<?php
namespace App\Views;

class LogoutAllView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        if ($this->currentUser === null) {
            throw new \App\Exceptions\ForbiddenException('you need to be logged in');
        }

        $this->db->deleteAllSessions($this->currentUser->id);
        header('Location: /');
    }

    public function shouldDisplayComments(): bool { return false; }
}
