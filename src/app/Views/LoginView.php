<?php
namespace App\Views;

class LoginView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
    ) {}

    public function show(): void {
        $username = '';
        $password = '';

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            // we do that even if log in failed, intentional
            $this->db->deleteSession(session_id());
            \App\Core\Utils::resetSession();

            $username = is_string($_POST['username'])
                ? $_POST['username']
                : '';
            $password = is_string($_POST['password'])
                ? $_POST['password']
                : '';

            $result = $this->db->tryLogIn($username, $password, session_id());

            if ($result === true) {
                echo 'logged in successfuly';
                header('Location: /');
                return;
            } else {
                echo "<p><span class='error'>$result</span></p>";
            }
        }

        $labelStyle = '
            display: inline-block;
            width: 9ch;
            margin-right: 0ch;
        ';
?>
<h1>log in</h1>
<form method='post' action='/login'>
    <label style='<?= $labelStyle; ?>' for='username'>username:</label>
    <div class='input-wrapper'><input
        type='text'
        id='username'
        name='username'
        value='<?= htmlspecialchars($username); ?>'
        required></div>
    <br>

    <label style='<?= $labelStyle; ?>' for='password'>password:</label>
    <div class='input-wrapper'><input
        type='password'
        id='password'
        name='password'
        value='<?= htmlspecialchars($password); ?>'
        required></div>
    <br><br>

    <button type='submit' value='login'>log in</button>
</form>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
