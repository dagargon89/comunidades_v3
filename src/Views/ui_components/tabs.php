<?php

/**
 * Componente de tabs reutilizable
 *
 * Uso:
 * $tabs = [
 *   'tabs' => [
 *     ['id' => 'tab1', 'label' => 'Tab 1', 'active' => true],
 *     ['id' => 'tab2', 'label' => 'Tab 2'],
 *   ],
 *   'contents' => [
 *     'tab1' => '<div>Contenido 1</div>',
 *     'tab2' => '<div>Contenido 2</div>',
 *   ],
 * ];
 * include __DIR__ . '/../components/tabs.php';
 */
if (!isset($tabs) || !is_array($tabs) || empty($tabs['tabs']) || empty($tabs['contents'])) return;
echo "<div>";
echo "<div class='flex border-b mb-4'>";
foreach ($tabs['tabs'] as $tab) {
    $active = !empty($tab['active']) ? 'border-primary text-primary' : 'border-transparent text-gray-500';
    echo "<button class='px-4 py-2 -mb-px border-b-2 font-semibold focus:outline-none $active' onclick=\"showTab('{$tab['id']}')\">{$tab['label']}</button>";
}
echo "</div>";
foreach ($tabs['tabs'] as $tab) {
    $display = !empty($tab['active']) ? 'block' : 'none';
    echo "<div id='{$tab['id']}' style='display:{$display};'>{$tabs['contents'][$tab['id']]}</div>";
}
echo "</div>";
?>
<script>
    function showTab(id) {
        <?php foreach ($tabs['tabs'] as $tab): ?>
            document.getElementById('<?= $tab['id'] ?>').style.display = 'none';
        <?php endforeach; ?>
        document.getElementById(id).style.display = 'block';
    }
</script>