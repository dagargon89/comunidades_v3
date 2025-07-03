<?php

/**
 * Componente de notificación tipo toast reutilizable
 *
 * Uso:
 * $toast = [
 *   'message' => 'Operación exitosa',
 *   'type' => 'success', // success, error, info, warning
 *   'duration' => 3000, // milisegundos
 * ];
 * include __DIR__ . '/../components/toast.php';
 */
if (!isset($toast) || !is_array($toast) || empty($toast['message'])) return;
$type = $toast['type'] ?? 'info';
$duration = $toast['duration'] ?? 3000;
$colors = [
    'success' => 'bg-green-500 text-white',
    'error' => 'bg-red-500 text-white',
    'info' => 'bg-blue-500 text-white',
    'warning' => 'bg-yellow-400 text-black',
];
$color = $colors[$type] ?? $colors['info'];
echo "<div class='fixed top-5 right-5 z-50 $color px-4 py-2 rounded shadow-lg toast' style='display:none;'>" . htmlspecialchars($toast['message']) . "</div>";
// Script para mostrar y ocultar automáticamente
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toast = document.querySelector('.toast');
        if (toast) {
            toast.style.display = 'block';
            setTimeout(function() {
                toast.style.display = 'none';
            }, <?= $duration ?>);
        }
    });
</script>