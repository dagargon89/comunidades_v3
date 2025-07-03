<?php
// Si existe un array $actions, úsalo (para roles, permisos, etc.)
if (isset($actions) && is_array($actions) && count($actions)) {
    echo '<div class="flex space-x-2">';
    foreach ($actions as $action) {
        if (!empty($action['permission']) && (!current_user() || !current_user()->hasPermission($action['permission']))) {
            continue;
        }
        $icon = $action['icon'] ?? (
            $action['type'] === 'edit' ? 'fa-edit text-yellow-500' : (
                $action['type'] === 'delete' ? 'fa-trash text-red-500' : (
                    $action['type'] === 'view' ? 'fa-eye text-blue-500' : 'fa-cog')));
        $title = $action['title'] ?? ucfirst($action['type']);
        $class = $action['class'] ?? 'text-info hover:text-primary mx-1';
        $onclick = isset($action['onclick']) ? 'onclick="' . $action['onclick'] . '"' : '';
        echo "<a href=\"{$action['url']}\" class=\"$class\" title=\"$title\" $onclick><i class='fas $icon'></i></a>\n";
    }
    echo '</div>';
    return;
}
// Si no, usa la lógica específica para usuarios y ejes
$entity = $usuario ?? $axis ?? null;
if (!$entity) return;
?>
<div class="flex space-x-2">
    <?php if (isset($usuario)): ?>
        <a href="/users/view?id=<?= $usuario['id'] ?>" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye text-blue-500"></i></a>
        <?php if (current_user() && current_user()->hasPermission('user.edit')): ?>
            <a href="/users/edit?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit text-yellow-500"></i></a>
        <?php endif; ?>
        <?php if (current_user() && current_user()->hasPermission('user.delete')): ?>
            <a href="/users/delete?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"><i class="fas fa-trash text-red-500"></i></a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($axis)): ?>
        <a href="/axes/view?id=<?= $axis['id'] ?>" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye text-blue-500"></i></a>
        <?php if (current_user() && current_user()->hasPermission('axis.edit')): ?>
            <a href="/axes/edit?id=<?= $axis['id'] ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit text-yellow-500"></i></a>
        <?php endif; ?>
        <?php if (current_user() && current_user()->hasPermission('axis.delete')): ?>
            <a href="/axes/delete?id=<?= $axis['id'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este eje?')"><i class="fas fa-trash text-red-500"></i></a>
        <?php endif; ?>
    <?php endif; ?>
</div>