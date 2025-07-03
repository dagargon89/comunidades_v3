<?php

/**
 * Componente de badge/etiqueta reutilizable
 *
 * Uso:
 * $badge = [
 *   'text' => 'Activo',
 *   'color' => 'bg-green-100 text-green-800',
 *   'class' => '', // opcional
 * ];
 * include __DIR__ . '/../components/badge.php';
 */
if (!isset($badge) || !is_array($badge) || empty($badge['text'])) return;
$color = $badge['color'] ?? 'bg-gray-200 text-gray-800';
$class = $badge['class'] ?? '';
echo "<span class='inline-block px-2 py-1 rounded-full text-xs font-semibold $color $class'>" . htmlspecialchars($badge['text']) . "</span>";
