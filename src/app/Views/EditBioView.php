<?php
namespace App\Views;

class EditBioView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}
    public function show(): void {
        if ($this->currentUser === null) {
            throw new \App\Exceptions\ForbiddenException('you need to be logged in');
        }

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $bio = isset($_POST['bio']) && is_string($_POST['bio'])
                ? $_POST['bio']
                : null;
            $this->db->setBio($this->currentUser->id, $bio);
            $username = $this->currentUser->username;
            header("Location: /u/$username");
        } else {
            $user = $this->db->getUser($this->currentUser->username);
            if ($user === null) {
                throw new \Exception('could not get user from db');
            }
            $bio = $user->unescapedBio();
        }

        if ($bio === null) {
            $bio = '';
        }
?>
<form method='post'>
    <div class='textarea-wrapper'>
        <textarea maxlength='255' rows='6' name='bio'><?= htmlspecialchars($bio); ?></textarea><br>
    </div>
    <button type='submit' value='submit'>submit</button>
</form>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
