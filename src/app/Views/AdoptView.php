<?php
namespace App\Views;

class AdoptView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        if ($this->currentUser === null) {
            throw new \App\Exceptions\ForbiddenException('you need to be logged in');
        }

        $username = isset($_GET['username']) && is_string($_GET['username'])
            ? $_GET['username']
            : '';

        if ($username === '') {
            throw new \App\Exceptions\BadRequestException('username must be set');
        }

        $user = $this->db->getUser($username);

        if ($user === null) {
            throw new \App\Exceptions\BadRequestException("user /u/$username does not exist");
        }

        if ($this->currentUser->username !== $user->parentUsername && !$this->currentUser->admin) {
            // note to self, don't adopt yourself
            throw new \App\Exceptions\ForbiddenException('you are not the parent of this user');
        }

        $this->db->adopt($this->currentUser->id, $user->id);
        echo '<br>user adopted';
        header("Location: /u/$user->parentUsername");
    }

    public function shouldDisplayComments(): bool { return false; }
}
