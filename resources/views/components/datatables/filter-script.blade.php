@props(['tableId' => 'orders-datatable'])

<script>
    $(document).ready(function () {
        let table = window.LaravelDataTables["{{ $tableId }}"];
        let $filterForm = $('#filter-form');

        // Inject filter values before ajax request
        table.on('preXhr.dt', function (e, settings, data) {
            $filterForm.find('input, select').each(function () {
                let name = $(this).attr('name');
                let value = $(this).val();
                if (name) {
                    data[name] = value;
                }
            });
        });

        // On form submit -> redraw table
        $filterForm.on('submit', function (e) {
            e.preventDefault();
            table.draw();
        });

        // Optional: prevent DataTable alert box errors
        $.fn.dataTable.ext.errMode = 'none';
    });
</script>
