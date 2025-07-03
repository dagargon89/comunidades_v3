<?php

/**
 * Componente de botón reutilizable
 *
 * Uso:
 * $btn = [
 *   'type' => 'submit' | 'button' | 'reset' | 'link',
 *   'label' => 'Texto',
 *   'class' => 'clases tailwind',
 *   'icon' => 'fa-save', // opcional
 *   'href' => '/ruta',   // solo para type=link
 *   'title' => 'Tooltip', // opcional
 *   'attrs' => 'data-extra="1"', // opcional
 * ];
 * include __DIR__ . '/../components/button.php';
 */
if (!isset($btn) || !is_array($btn) || empty($btn['label'])) return;
$type = $btn['type'] ?? 'button';
$label = $btn['label'];
$base_class = 'px-6 py-2 rounded-xl font-bold text-base transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
$class = isset($btn['class']) ? $base_class . ' ' . $btn['class'] : $base_class . ' bg-fuchsia-800 text-white';
$icon = !empty($btn['icon']) ? "<i class='fas {$btn['icon']} mr-1'></i>" : '';
$title = !empty($btn['title']) ? "title=\"{$btn['title']}\"" : '';
$attrs = $btn['attrs'] ?? '';
if ($type === 'link') {
    $href = $btn['href'] ?? '#';
    echo "<a href=\"$href\" class=\"$class\" $title $attrs>$icon$label</a>";
} else {
    echo "<button type=\"$type\" class=\"$class\" $title $attrs>$icon$label</button>";
}
