<?php

/**
 * Componente de paginación reutilizable
 *
 * Uso:
 * $pagination = [
 *   'current' => 2,
 *   'total' => 10,
 *   'base_url' => '/usuarios?page=',
 * ];
 * include __DIR__ . '/../components/pagination.php';
 */
if (!isset($pagination) || !is_array($pagination) || $pagination['total'] <= 1) return;
$current = $pagination['current'] ?? 1;
$total = $pagination['total'] ?? 1;
$base_url = $pagination['base_url'] ?? '?page=';
echo '<nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">';
for ($i = 1; $i <= $total; $i++) {
    $active = $i === $current ? 'bg-primary text-white' : '';
    echo "<a href='{$base_url}{$i}' class='px-3 py-1 border {$active}'> $i </a>";
}
echo '</nav>';
