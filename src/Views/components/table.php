<?php

/**
 * Componente de tabla reutilizable y flexible
 *
 * $headers: array de encabezados visibles (['Nombre', 'Email', ...])
 * $fields: array de claves de los datos (['first_name', 'email', ...])
 * $rows: array de arrays asociativos (cada fila)
 * $actions_config: array de acciones por fila (cada acción: type, url, permission, title, icon, class, onclick)
 * $custom_render: array opcional de closures para renderizar celdas personalizadas por campo
 */
?>
<div class="overflow-x-auto rounded-xl shadow">
    <table class="min-w-full tabla-app divide-y divide-gray-200 bg-white">
        <thead>
            <tr class="text-left text-xs font-semibold uppercase tracking-wider bg-primary text-white">
                <?php foreach ($headers as $header): ?>
                    <th class="px-4 py-3 text-left"><?= htmlspecialchars($header) ?></th>
                <?php endforeach; ?>
                <?php if (!empty($actions_config)): ?>
                    <th class="px-4 py-3 text-center">Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="<?= count($headers) + (empty($actions_config) ? 0 : 1) ?>" class="text-center py-8 text-muted">No hay datos para mostrar.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $idx => $row): ?>
                    <tr class="bg-white text-gray-900">
                        <?php foreach ($fields as $field): ?>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-900 text-left">
                                <?php
                                if (isset($custom_render[$field]) && is_callable($custom_render[$field])) {
                                    echo $custom_render[$field]($row[$field], $row);
                                } else {
                                    echo isset($row[$field]) ? htmlspecialchars($row[$field]) : '-';
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                        <?php if (!empty($actions_config)): ?>
                            <td class="px-4 py-3 text-center">
                                <div class="flex gap-2 justify-center">
                                    <?php foreach ($actions_config as $action): ?>
                                        <?php
                                        // Permiso
                                        if (!empty($action['permission']) && (!function_exists('current_user') || !current_user() || !current_user()->hasPermission($action['permission']))) {
                                            continue;
                                        }
                                        $url = is_callable($action['url']) ? $action['url']($row) : (isset($action['url']) ? str_replace('{id}', $row['id'], $action['url']) : '#');
                                        $icon = $action['icon'] ?? (
                                            $action['type'] === 'edit' ? 'fa-edit text-yellow-500' : (
                                                $action['type'] === 'delete' ? 'fa-trash text-red-500' : (
                                                    $action['type'] === 'view' ? 'fa-eye text-blue-500' : 'fa-cog')));
                                        $title = $action['title'] ?? ucfirst($action['type']);
                                        $class = $action['class'] ?? 'text-info hover:text-primary mx-1';
                                        $onclick = isset($action['onclick']) ? 'onclick="' . (is_callable($action['onclick']) ? $action['onclick']($row) : $action['onclick']) . '"' : '';
                                        ?>
                                        <a href="<?= $url ?>" class="btn btn-sm <?= $class ?>" title="<?= htmlspecialchars($title) ?>" <?= $onclick ?>><i class="fas <?= $icon ?>"></i></a>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>