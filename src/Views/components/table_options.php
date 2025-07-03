<?php
// Componente de opciones de tabla reutilizable
// Requiere: id de la tabla a controlar (por defecto 'main-table')
$table_id = $table_id ?? 'main-table';
$per_page = $per_page ?? 10;
$per_page_options = [10, 20, 50, 100];
?>
<div class="flex items-center gap-4 mb-2">
    <form method="get" class="inline-block">
        <?php foreach ($_GET as $k => $v): if ($k !== 'per_page'): ?>
                <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
        <?php endif;
        endforeach; ?>
        <label class="text-sm mr-1">Mostrar</label>
        <select name="per_page" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
            <?php foreach ($per_page_options as $opt): ?>
                <option value="<?= $opt ?>" <?= $per_page == $opt ? 'selected' : '' ?>><?= $opt ?></option>
            <?php endforeach; ?>
        </select>
        <span class="text-sm ml-1">filas</span>
    </form>
    <button type="button" class="btn btn-secondary btn-sm" onclick="exportTableToCSV('<?= $table_id ?>')" title="Exportar a CSV"><i class="fas fa-file-csv"></i></button>
    <button type="button" class="btn btn-secondary btn-sm" onclick="copyTableToClipboard('<?= $table_id ?>')" title="Copiar tabla"><i class="fas fa-copy"></i></button>
    <button type="button" class="btn btn-secondary btn-sm" onclick="printTable('<?= $table_id ?>')" title="Imprimir tabla"><i class="fas fa-print"></i></button>
</div>
<script>
    function exportTableToCSV(tableId) {
        const table = document.getElementById(tableId);
        let csv = [];
        for (let row of table.rows) {
            let rowData = [];
            for (let cell of row.cells) {
                rowData.push('"' + cell.innerText.replace(/"/g, '""') + '"');
            }
            csv.push(rowData.join(','));
        }
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'tabla.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    function copyTableToClipboard(tableId) {
        const table = document.getElementById(tableId);
        let text = '';
        for (let row of table.rows) {
            let rowData = [];
            for (let cell of row.cells) {
                rowData.push(cell.innerText);
            }
            text += rowData.join('\t') + '\n';
        }
        navigator.clipboard.writeText(text).then(function() {
            alert('Tabla copiada al portapapeles');
        });
    }

    function printTable(tableId) {
        const table = document.getElementById(tableId);
        const win = window.open('', '', 'width=900,height=700');
        win.document.write('<html><head><title>Imprimir tabla</title>');
        win.document.write('<link rel="stylesheet" href="/assets/css/tailwind.min.css">');
        win.document.write('</head><body>');
        win.document.write(table.outerHTML);
        win.document.write('</body></html>');
        win.document.close();
        win.print();
    }
</script>