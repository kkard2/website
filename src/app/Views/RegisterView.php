<?php
namespace App\Views;

class RegisterView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
    ) {}

    public function show(): void {
        // TODO: this should probably not be in the show method, just a thought
        $username = '';
        $password = '';
        $confirmPassword = '';
        $parentKey = '';
        $errors = [];

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = isset($_POST['username']) && is_string($_POST['username'])
                ? $_POST['username']
                : '';
            if ($username === '') {
                $errors[] = 'username is required';
            } elseif (strlen($username) < 1 || strlen($username) > 20) {
                $errors[] = 'username is not between 2 and 20 characters long';
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $errors[] = 'username can only contain letters, numbers, and underscores';
            }

            $password = isset($_POST['password']) && is_string($_POST['password'])
                ? $_POST['password']
                : '';
            $confirmPassword = isset($_POST['confirmPassword']) && is_string($_POST['confirmPassword'])
                ? $_POST['confirmPassword']
                : '';

            if (strlen($password) < 8) {
                $errors[] = 'password must be at least 8 characters long (which is too short btw, use a longer one)';
            } elseif ($password !== $confirmPassword) {
                $errors[] = 'passwords are not the same';
            }

            $parentKey = isset($_POST['parentKey']) && is_string($_POST['parentKey'])
                ? $_POST['parentKey']
                : '';

            $parentId = $this->db->validateParentKey($parentKey);

            if ($parentId === null) {
                $errors[] = 'invalid parent key';
                // TODO: some form of spam detection
            }

            if ($this->db->getUser($username) !== null) {
                $errors[] = 'user with this username already exists';
            }

            if (count($errors) !== 0) {
                echo '<br><div class="error">';
                foreach ($errors as $error) {
                    echo "$error<br>";
                }
                echo '</div>';
            } else {
                assert($parentId !== null);
                if ($this->db->registerUser(
                    $username,
                    $password,
                    $parentId,
                )) {
                    echo "<br>registered /u/$username successfully<br><br>";
                    echo '<a href="/login">/login</a>';
                } else {
                    throw new \Exception('could not register user for unknown reason');
                }
                return; // don't show form
            }
        }

        $labelStyle = '
            display: inline-block;
            width: 17ch;
            margin-right: 0ch;
        ';
?>
<h1>register</h1>
<form method='post' action='/register'>
    <label style='<?= $labelStyle; ?>' for='username'>username:</label>
    <div class='input-wrapper'><input
        type='text'
        id='username'
        name='username'
        value='<?= htmlspecialchars($username); ?>'
        required
        pattern='[a-zA-Z0-9_]{2,20}'
        title='username must be 2-20 characters long and can only contain letters, numbers, and underscores'></div>
    <br>

    <label style='<?= $labelStyle; ?>' for='password'>password:</label>
    <div class='input-wrapper'><input
        type='password'
        id='password'
        name='password'
        value='<?= htmlspecialchars($password); ?>'
        required
        minlength='8'
        title='password must be at least 8 characters long'></div>
    <br>

    <label style='<?= $labelStyle; ?>' for='confirmPassword'>confirm password:</label>
    <div class='input-wrapper'><input
        type='password'
        id='confirmPassword'
        name='confirmPassword'
        value='<?= htmlspecialchars($confirmPassword); ?>'
        required
        minlength='8'
        title='confirm password'></div>
    <br>

    <label style='display: inline-block; width: 13ch; margin-right: 0ch;' for='parentKey'>parent key:</label>
    <a href='/family'>[?]</a>
    <div class='input-wrapper'><input
        type='password'
        id='parentKey'
        name='parentKey'
        required
        minlength='64'
        maxlength='64'
        value='<?= htmlspecialchars($parentKey); ?>'
        title='ask some existing user to give you their parent key; they are (partially) responsible for your actions'></div>
    <br><br>
    <button type='submit' value='register'>register</button>
</form>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
