<?php
namespace App\Views;

class BadRequestErrorView implements View {
    public function __construct(
        private readonly string $message,
    ) {}
    public function show(): void {
?>
<h1>400 Bad Request</h1>
<p>
<?= $this->message; ?>
</p>
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}
