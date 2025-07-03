<?php

use function current_user;

if (!isset($axis)) return;
?>
<div class="flex space-x-2">
    <?php if (current_user() && current_user()->hasPermission('axis.view')): ?>
        <a href="/axes/view?id=<?= $axis['id'] ?>" class="btn btn-info btn-sm">Ver</a>
    <?php endif; ?>
    <?php if (current_user() && current_user()->hasPermission('axis.edit')): ?>
        <a href="/axes/edit?id=<?= $axis['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
    <?php endif; ?>
    <?php if (current_user() && current_user()->hasPermission('axis.delete')): ?>
        <a href="/axes/delete?id=<?= $axis['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este eje?')">Eliminar</a>
    <?php endif; ?>
</div>