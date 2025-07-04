<?php

/**
 * Componente de formulario reutilizable
 *
 * Uso:
 * $fields = [
 *   ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => '', 'required' => true],
 *   ['name' => 'rol', 'label' => 'Rol', 'type' => 'select', 'options' => ['admin' => 'Admin', 'user' => 'Usuario'], 'value' => 'user'],
 *   ...
 * ];
 * $action = '/ruta/guardar';
 * $method = 'post';
 * $buttons = [
 *   ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-secondary'],
 *   ['type' => 'link', 'label' => 'Cancelar', 'href' => '/ruta', 'class' => 'btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400']
 * ];
 */
?>
<div class="flex flex-col items-center w-full">
    <div class="bg-white rounded-lg shadow p-8 max-w-2xl w-full mx-auto">
        <form method="<?= $method ?? 'post' ?>" action="<?= $action ?? '' ?>" class="space-y-4">
            <?php foreach ($fields as $field): ?>
                <div>
                    <?php
                    $type = $field['type'] ?? 'text';
                    // Solo mostrar el label si el campo NO es hidden
                    if ($type !== 'hidden') {
                        $label = $field['label'] ?? '';
                        if ($label !== '') {
                            // Renderizar el label normalmente
                            echo "<label for='" . htmlspecialchars($field['name']) . "' class='form-label'>" . htmlspecialchars($label) . "</label>";
                        }
                    }
                    ?>
                    <?php if (($type === 'select') || ($type === 'textarea')): ?>
                        <div class="mt-2">
                            <?php if ($type === 'select'): ?>
                                <select name="<?= $field['name'] ?>" id="<?= $field['name'] ?>" class="form-select w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" <?= !empty($field['required']) ? 'required' : '' ?>>
                                    <?php foreach ($field['options'] as $val => $text): ?>
                                        <option value="<?= htmlspecialchars($val) ?>" <?= (isset($field['value']) && $field['value'] == $val) ? 'selected' : '' ?>><?= htmlspecialchars($text) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php elseif ($type === 'textarea'): ?>
                                <textarea name="<?= $field['name'] ?>" id="<?= $field['name'] ?>" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" <?= !empty($field['required']) ? 'required' : '' ?>><?= htmlspecialchars($field['value'] ?? '') ?></textarea>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <input type="<?= $type ?>" name="<?= $field['name'] ?>" id="<?= $field['name'] ?>" value="<?= htmlspecialchars($field['value'] ?? '') ?>" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" <?= !empty($field['required']) ? 'required' : '' ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div class="mt-6 flex gap-2 justify-end">
                <?php foreach ($buttons as $btn): ?>
                    <?php include __DIR__ . '/button.php'; ?>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
</div>