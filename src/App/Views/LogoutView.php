<?php
namespace App\Views;

class LogoutView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
    ) {}

    public function show(): void {
        $this->db->deleteSession(session_id());
        \App\Core\Utils::resetSession();
        echo 'logged out';
        header('Location: /');
    }

    public function shouldDisplayComments(): bool { return false; }
}
