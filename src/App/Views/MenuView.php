<?php
namespace App\Views;

class MenuView implements View {
    public function __construct(
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}
    public function show(): void {
?>
<ul>
    <li><a href="/">/</a></li>
    <li><a href="/software"> /software</a></li>
    <li><a href="/blog">/blog</a></li>
    <li><a href="/rss">/rss</a></li>
    <li><a href="/people">/people</a></li>
    <li><a href="/ophs">/ophs</a></li>
    <li><a href="/family">/family</a></li>
    <li><a href="/activity">/activity</a></li>
<?php
        if ($this->currentUser !== null && $this->currentUser->admin) {
            echo '<li><a href="/cms/software">/cms/software</a></li>';
        }
?>
</ul>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
