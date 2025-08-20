<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });
        const table = new DataTable('.table', { 
            lengthMenu: [50, 100, 200, { label: 'All', value: -1 }],
            pageLength: 100,
            layout: {
                topStart: {
                    buttons: ['pageLength',
                        {
                            extend: 'excel',
                            text : '<i class="bi bi-file-spreadsheet"></i>&nbsp;Export Spreadsheet'
                        }
                    ]
                }
            },
            columnDefs : [
                {
                    targets: 5,
                    render: $.fn.dataTable.render.number(',', '.', 2, '$') // Format as USD with 2 decimals
                }
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Calculate sum of column 5 (visible rows only)
                var pageTotal = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                // Calculate sum of column 5 (all rows)
                var total = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                // Update footer
                $(api.column(5).footer()).html(
                    '$' + pageTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + 
                    ' (Total: $' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ')'
                );
            }
        })
    })
</script>