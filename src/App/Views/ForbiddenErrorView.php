<?php
namespace App\Views;

class ForbiddenErrorView implements View {
    public function __construct(
        private readonly string $message,
    ) {}
    public function show(): void {
?>
<h1>403 Forbidden</h1>
<p>
<?= $this->message; ?>
</p>
<p>
if you didn't try to break site intentionaly, this should not happen;
contact me with repro steps
</p>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
