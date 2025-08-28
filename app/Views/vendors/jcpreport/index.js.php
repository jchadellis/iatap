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
            select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= base_url('vendors/jcp-report/data') ?>', 
                dataSrc: 'data',
            },        
            pageLength: 100,    
            responsive: true,
            order:[[3, 'desc']],
            language:{
                buttons:{
                    colvis: `<i class="bi bi-eye-slash"></i>&nbsp;Show/Hide Columns`, 
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                    excel: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`,
                    pdf: `<i class="bi bi-file-earmark-pdf"></i>&nbsp;Export to PDF`,
                }
            },
            columns:[
                {
                    data: 'vendor_id', 
                    title: 'Vendor ID', 
                    visible: false, 
                },
                {
                    data: 'name', 
                    title: 'Name', 
                },
                {
                    data: null, 
                    title: 'Address', 
                    render: function(data, type, row)
                    {
                        return `${data.street_1} ${data.city}, ${data.state}, ${data.zip}`;
                    }
                },
                {
                    data: 'jcp_expiration',
                    title: 'JCP Expiration', 
                    render: function(data, type, row){
                        
                        return data; 
                    }, 
                    className: 'text-center', 
                }
            ],
            columnDefs:[
                {
                    targets:[0],
                    className: 'dt-center', 
                    orderable: true, 
                    render: function(data, type, row){
                        return data || '-';
                    }
                }
            ],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength', 
                        {
                            extend: 'pdf', 
                            title: 'JCP Report', 
                            filename: function() {
                                return 'JCP Report_' + new Date().toISOString().slice(0,10);
                            },
                            exportOptions:{
                                columns: [1,2,3],
                            }
                        },
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                if(data.jcp_expiration == 'Y'){
                    $(row).addClass('table-warning'); 
                }
            }

        });

        table.on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                row = dt.row(indexes[0]).node(); 
                modal = $('#content-modal'); 
                modal.modal('show'); 
                selectedRow = $(dt.row(indexes).node()); 
            }
        });

        table.on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = table.rows(indexes).data().toArray();
                //console.log('Deselected rows:', data);
            }
        });

        $('.edit-btn').on('click', function(){
            modal = $('#content-modal'); 
            modal.modal('show'); 
        });

        $('#content-modal').on('hidden.bs.modal', function(){
            if(selectedRow) {
                row = table.row(selectedRow);
                row.deselect(); 
                selectedRow = null;
            }
        });



    })
</script>