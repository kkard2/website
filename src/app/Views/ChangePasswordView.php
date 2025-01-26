<?php
namespace App\Views;

class ChangePasswordView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        if ($this->currentUser === null) {
            throw new \App\Exceptions\ForbiddenException('you need to be logged in');
        }

        $errors = [];

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentpassword = isset($_POST['currentpassword']) && is_string($_POST['currentpassword'])
                ? $_POST['currentpassword']
                : '';
            $newpassword = isset($_POST['newpassword']) && is_string($_POST['newpassword'])
                ? $_POST['newpassword']
                : '';
            $confirmpassword = isset($_POST['confirmpassword']) && is_string($_POST['confirmpassword'])
                ? $_POST['confirmpassword']
                : '';

            if (!$this->db->checkPassword($this->currentUser->id, $currentpassword)) {
                $errors[] = 'invalid old password';
            }

            if (strlen($newpassword) < 8) {
                $errors[] = 'password must be at least 8 characters long (which is too short btw, use a longer one)';
            } elseif ($newpassword !== $confirmpassword) {
                $errors[] = 'passwords are not the same';
            }

            if (count($errors) !== 0) {
                echo '<br><div class="error">';
                foreach ($errors as $error) {
                    echo "$error<br>";
                }
                echo '</div>';
            } else {
                if ($this->db->changePassword(
                    $this->currentUser->id,
                    $newpassword,
                )) {
                    $this->db->deleteAllSessions($this->currentUser->id);
                    header('Location: /login');
                } else {
                    throw new \Exception('could not change password for unknown reason');
                }
                return;
            }
        }
?>
<h1>change password</h1>
<form method='post' action='/changepassword'>
    <label for='currentpassword'>current password:</label>
    <div class='input-wrapper'><input
        type='password'
        id='currentpassword'
        name='currentpassword'
        required></div>
    <br>

    <label for='newpassword'>new password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <div class='input-wrapper'><input
        type='password'
        id='newpassword'
        name='newpassword'
        minlength='8'
        required></div>
    <br>

    <label for='confirmpassword'>confirm password:</label>
    <div class='input-wrapper'><input
        type='password'
        id='confirmpassword'
        name='confirmpassword'
        minlength='8'
        required></div>
    <br><br>
    <button type='submit' value='change'>change</button>
</form>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
