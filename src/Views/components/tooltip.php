<?php

/**
 * Componente de tooltip reutilizable
 *
 * Uso:
 * $tooltip = [
 *   'text' => 'Texto del tooltip',
 *   'content' => '<i class="fas fa-info-circle"></i>',
 *   'position' => 'top', // opcional: top, right, bottom, left
 * ];
 * include __DIR__ . '/../components/tooltip.php';
 */
if (!isset($tooltip) || !is_array($tooltip) || empty($tooltip['text']) || empty($tooltip['content'])) return;
$position = $tooltip['position'] ?? 'top';
echo "<span class='relative group'>";
echo $tooltip['content'];
echo "<span class='absolute z-10 hidden group-hover:block bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap {$position}' style='min-width:80px;'>" . htmlspecialchars($tooltip['text']) . "</span>";
echo "</span>";
