<?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?= $_SESSION['flash_error'];
        unset($_SESSION['flash_error']); ?>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        <?= $_SESSION['flash_success'];
        unset($_SESSION['flash_success']); ?>
    </div>
<?php endif; ?>