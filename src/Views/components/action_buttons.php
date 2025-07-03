<?php

/**
 * Componente de botones de acción reutilizables
 *
 * Uso:
 * $actions = [
 *   [
 *     'type' => 'edit',
 *     'url' => '/users/edit?id=1',
 *     'permission' => 'user.edit',
 *     'title' => 'Editar',
 *     'class' => 'text-blue-600 hover:text-blue-900',
 *   ],
 *   [
 *     'type' => 'delete',
 *     'url' => '/users/delete?id=1',
 *     'permission' => 'user.delete',
 *     'title' => 'Eliminar',
 *     'class' => 'text-red-600 hover:text-red-900',
 *     'onclick' => "return confirm('¿Seguro que deseas eliminar este usuario?')"
 *   ],
 * ];
 */
$icon_map = [
    'edit' => 'fa-edit',
    'delete' => 'fa-trash',
    'view' => 'fa-eye',
    'reset' => 'fa-key',
    'rol' => 'fa-user-tag',
    'correo' => 'fa-envelope',
    'block' => 'fa-user-lock',
    'unblock' => 'fa-user-check',
];
foreach ($actions as $action) {
    if (!empty($action['permission']) && (!current_user() || !current_user()->hasPermission($action['permission']))) {
        continue;
    }
    $icon = $action['icon'] ?? ($icon_map[$action['type']] ?? 'fa-cog');
    $title = $action['title'] ?? ucfirst($action['type']);
    $class = $action['class'] ?? 'text-info hover:text-primary mx-1';
    $onclick = isset($action['onclick']) ? 'onclick="' . $action['onclick'] . '"' : '';
    echo "<a href=\"{$action['url']}\" class=\"$class\" title=\"$title\" $onclick><i class='fas $icon'></i></a>\n";
}
