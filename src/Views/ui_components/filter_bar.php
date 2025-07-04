<?php

/**
 * Componente de barra de filtros reutilizable
 *
 * Uso:
 * $filters = [
 *   ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar...', 'value' => ''],
 *   ['type' => 'select', 'name' => 'rol', 'options' => ['' => 'Todos', 'admin' => 'Admin'], 'value' => 'admin'],
 * ];
 * $buttons = [
 *   ['type' => 'submit', 'label' => 'Filtrar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900', 'icon' => 'fa-search'],
 *   ['type' => 'link', 'label' => 'Nuevo', 'href' => '/nuevo', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900', 'icon' => 'fa-plus'],
 * ];
 * include __DIR__ . '/../components/filter_bar.php';
 */
$form_action = $form_action ?? '';
$form_method = $form_method ?? 'get';
$form_class = $form_class ?? 'flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 bg-white p-4 rounded-xl shadow';
?>
<form action="<?= $form_action ?>" method="<?= $form_method ?>" class="<?= $form_class ?>">
    <div class="flex flex-1 flex-wrap gap-2 items-center">
        <?php foreach ($filters as $f): ?>
            <?php if (($f['type'] ?? 'text') === 'select'): ?>
                <select name="<?= $f['name'] ?>" class="form-select w-full md:w-48 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2">
                    <?php foreach ($f['options'] as $val => $text): ?>
                        <option value="<?= htmlspecialchars($val) ?>" <?= (isset($f['value']) && $f['value'] == $val) ? 'selected' : '' ?>><?= htmlspecialchars($text) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="<?= $f['type'] ?? 'text' ?>" name="<?= $f['name'] ?>" value="<?= htmlspecialchars($f['value'] ?? '') ?>" placeholder="<?= $f['placeholder'] ?? '' ?>" class="form-input w-full md:w-64 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2">
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="flex gap-2 items-center justify-end">
        <?php foreach ($buttons as $btn) include __DIR__ . '/button.php'; ?>
    </div>
</form>