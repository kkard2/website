<?php
namespace App\Views;

class RemoveCommentView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        if ($this->currentUser === null || !$this->currentUser->admin) {
            throw new \App\Exceptions\ForbiddenException('only admin can remove comments');
        }

        $id = isset($_GET['id']) && is_string($_GET['id'])
            ? $_GET['id']
            : '';
        if (!is_numeric($id)) {
            throw new \App\Exceptions\BadRequestException('comment not found');
        }
        if ($this->db->removeComment((int)$id)) {
            echo '<br>comment removed';
        } else {
            throw new \App\Exceptions\BadRequestException('comment not found');
        }
    }

    public function shouldDisplayComments(): bool { return false; }
}
