<?php

/**
 * Componente de tabla reutilizable
 *
 * $headers: array de encabezados (['Nombre', 'Email', ...])
 * $fields: array de claves de los datos (['first_name', 'email', ...])
 * $rows: array de arrays asociativos (cada fila)
 * $actions: array de acciones por fila (['ver', 'editar', ...])
 * $actions_render: función anónima para renderizar acciones personalizadas (opcional)
 */
?>
<div class="overflow-x-auto rounded-xl shadow">
    <table class="min-w-full tabla-app divide-y divide-gray-200 bg-white">
        <thead>
            <tr class="text-left text-xs font-semibold uppercase tracking-wider bg-primary text-white">
                <?php foreach ($headers as $header): ?>
                    <th class="px-4 py-3 text-left"><?= htmlspecialchars($header) ?></th>
                <?php endforeach; ?>
                <?php if (!empty($actions)): ?>
                    <th class="px-4 py-3 text-center">Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="<?= count($headers) + (empty($actions) ? 0 : 1) ?>" class="text-center py-8 text-muted">No hay datos para mostrar.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $idx => $row): ?>
                    <tr class="bg-white text-gray-900">
                        <?php foreach ($fields as $field): ?>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-900 text-left">
                                <?= isset($row[$field]) ? htmlspecialchars($row[$field]) : '-' ?>
                            </td>
                        <?php endforeach; ?>
                        <?php if (!empty($actions)): ?>
                            <td class="px-4 py-3 text-center">
                                <?php
                                if (isset($actions_render) && is_callable($actions_render)) {
                                    echo $actions_render($row);
                                } else {
                                    foreach ($actions as $action) {
                                        // Ejemplo de iconos y tooltips
                                        $icon = [
                                            'ver' => 'fa-eye',
                                            'editar' => 'fa-edit',
                                            'eliminar' => 'fa-trash',
                                            'reset' => 'fa-key',
                                            'rol' => 'fa-user-tag',
                                            'correo' => 'fa-envelope',
                                            'bloquear' => 'fa-user-lock',
                                            'desbloquear' => 'fa-user-check',
                                        ][$action] ?? 'fa-cog';
                                        $title = ucfirst($action);
                                        echo "<button class='text-info hover:text-primary mx-1' title='$title'><i class='fas $icon'></i></button>";
                                    }
                                }
                                ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>