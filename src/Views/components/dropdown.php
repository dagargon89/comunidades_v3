<?php

/**
 * Componente de dropdown reutilizable
 *
 * Uso:
 * $dropdown = [
 *   'trigger' => '<button class="px-4 py-2 bg-primary text-white rounded">Opciones</button>',
 *   'content' => '<a href="#">Acción 1</a><a href="#">Acción 2</a>',
 *   'class' => '', // opcional
 * ];
 * include __DIR__ . '/../components/dropdown.php';
 */
if (!isset($dropdown) || !is_array($dropdown) || empty($dropdown['trigger']) || empty($dropdown['content'])) return;
$class = $dropdown['class'] ?? '';
echo "<div class='relative inline-block text-left $class'>";
echo $dropdown['trigger'];
echo "<div class='hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 dropdown-content z-50'>";
echo $dropdown['content'];
echo "</div></div>";
// Script básico para mostrar/ocultar
?>
<script>
    document.querySelectorAll('.relative.inline-block .dropdown-content').forEach(function(drop) {
        drop.previousElementSibling.addEventListener('click', function(e) {
            e.preventDefault();
            drop.classList.toggle('hidden');
        });
    });
</script>