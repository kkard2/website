<?php
namespace App\Views\Cms;

class SoftwareCmsView implements \App\Views\View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        if ($this->currentUser === null || !$this->currentUser->admin) {
            throw new \App\Exceptions\ForbiddenException('only admin can access cms');
        }

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $submitType = isset($_POST['submittype']) ? $_POST['submittype'] : '';

            if ($submitType === 'submitpost') {
                $datetime = isset($_POST['datetime']) && is_string($_POST['datetime'])
                    ? $_POST['datetime']
                    : '';
                $title = isset($_POST['title']) && is_string($_POST['title'])
                    ? $_POST['title']
                    : '';
                $filename = isset($_POST['filename']) && is_string($_POST['filename'])
                    ? $_POST['filename']
                    : '';
                $content = isset($_POST['content']) && is_string($_POST['content'])
                    ? $_POST['content']
                    : '';

                if ($datetime === '' || $title === '' || $filename === '' || $content === '') {
                    throw new \App\Exceptions\BadRequestException('you should know how to use the site as the owner');
                }

                $datetime = new \DateTimeImmutable($datetime);
                $y = $datetime->format('Y');
                $m = $datetime->format('m');
                $d = $datetime->format('d');

                $basePath = realpath('content/software');

                if (!is_dir("$basePath/$y/$m/$d")) {
                    if (!mkdir("$basePath/$y/$m/$d", 0777, true)) {
                        throw new \Exception("could not create '$basePath/$y/$m/$d' directory");
                    }
                }

                $content = "<h3>$title</h3>\n<div>" . $content . '</div>';

                if (file_put_contents("$basePath/$y/$m/$d/$filename.html", $content) === false) {
                    throw new \Exception("could not create file '$basePath/$y/$m/$d/$filename.html'");
                }

                $this->performGitCommitPush();
            } elseif ($submitType === 'submitfile') {
                if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
                    $filename = isset($_POST['filename']) && is_string($_POST['filename'])
                        ? $_POST['filename']
                        : '';
                    if ($filename === '') {
                        throw new \App\Exceptions\BadRequestException('no file name provided');
                    }

                    $uploadDirectory = realpath('content/res/software/');
                    $filePath = "$uploadDirectory/" . $filename;

                    if (file_exists($filePath)) {
                        throw new \App\Exceptions\BadRequestException('file already exists');
                    } else {
                        if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                            throw new \Exception('uploading file failed');
                        }

                        $this->performGitCommitPush();
                    }
                } else {
                    throw new \Exception('uploading file failed');
                }
            }
        }
?>
<h1>post</h1>
<form method='post'>
    <label for='datetime'>datetime:</label>
    <div class='input-wrapper'><input
        type='text'
        id='datetime'
        name='datetime'
        value='<?= date('Y-m-d H:m:s'); ?>'
        required></div>
    <br>

    <label for='title'>title:&nbsp;&nbsp;&nbsp;</label>
    <div class='input-wrapper'><input
        type='text'
        id='title'
        name='title'
        required></div>
    <br>

    <label for='filename'>filename:</label>
    <div class='input-wrapper'><input
        type='text'
        id='filename'
        name='filename'
        required></div>.html
    <br>

    <div class='textarea-wrapper'>
        <textarea required rows='6' name='content'></textarea><br>
    </div>
    <button type='submit' name='submittype' value='submitpost'>submit</button>
</form>
<h1>file</h1>
<form method='post' enctype='multipart/form-data'>
    <label for='file'>choose file:</label>
    <div class='input-wrapper'>
        <input type='file' name='file' id='file' required>
    </div><br>

    <label for='filename'>filename:&nbsp;&nbsp;&nbsp;</label>
    <div class='input-wrapper'><input
        type='text'
        id='filename'
        name='filename'
        required></div>
    <br>
    <button type="submit" name='submittype' value='submitfile'>submit</button>
</form>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }

    private function performGitCommitPush(): void {
        $repoPath = realpath('../');
        chdir($repoPath);

        exec('git add .', $output, $returnVar);
        if ($returnVar !== 0) {
            /** @psalm-suppress MixedArgumentTypeCoercion */
            $output = implode('\n', $output);
            echo "git add error: $output";
        }

        $datetime = new \DateTime();
        $datetime = $datetime->format('Y-m-d H:m:s');
        unset($output);
        exec("git commit -m \"AUTO: $datetime\"", $output, $returnVar);

        if ($returnVar !== 0) {
            /** @psalm-suppress MixedArgumentTypeCoercion */
            $output = implode('\n', $output);
            echo "git commit error: $output";
        }

        unset($output);
        exec('git push', $output, $returnVar);
        if ($returnVar !== 0) {
            /** @psalm-suppress MixedArgumentTypeCoercion */
            $output = implode('\n', $output);
            echo "git push error: $output";
        }
    }
}
