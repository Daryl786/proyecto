<?php if ($flash['error']): ?>
    <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 4px;">
        <?= $this->e($flash['error']) ?>
    </div>
<?php endif; ?>

<?php if ($flash['success']): ?>
    <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 4px;">
        <?= $this->e($flash['success']) ?>
    </div>
<?php endif; ?>
