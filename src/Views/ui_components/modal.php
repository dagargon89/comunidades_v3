<?php

/**
 * Componente de modal reutilizable
 *
 * $id: string, id único del modal
 * $title: string, título del modal
 * $content: string, HTML del contenido
 * $footer: string, HTML de los botones (opcional)
 */
?>
<div id="<?= htmlspecialchars($id) ?>" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 p-0 overflow-hidden animate-fade-in">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($title) ?></h3>
            <button onclick="closeModal('<?= htmlspecialchars($id) ?>')" class="text-gray-400 hover:text-danger text-2xl font-bold focus:outline-none">&times;</button>
        </div>
        <div class="px-6 py-6">
            <?= $content ?>
        </div>
        <?php if (!empty($footer)): ?>
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50">
                <?= $footer ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .animate-fade-in {
        animation: fade-in 0.2s ease;
    }
</style>