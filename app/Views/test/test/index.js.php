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
                url: '<?= base_url('path/to/data') ?>', 
                dataSrc: 'data',
            },        
            pageLength: 25,    
            responsive: true,
            order:[[0, 'desc']],
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
                    data: 'col-1', 
                    title: 'column 1', 
                    render: function(data, type, row){
                        // Add null/undefined check
                        if (type === 'display' || type === 'type') {
                            return data || '-';
                        }
                        return data; 
                    }, 
                },
                // {
                //     data: null,
                //     orderable: false, 
                //     className: 'd-grid', 
                //     render: function(data, type, row)
                //     {
                //         return `<button class="btn btn-primary edit-btn"><i class="bi bi-pencil"></i>&nbsp;Edit</button>`;
                //     }
                // }
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
                            extend: 'excelHtml5', 
                            title: 'Custom Title', 
                            filename: function() {
                                return 'Custom_File_Name_' + new Date().toISOString().slice(0,10);
                            }
                        },
                        {
                            extend: 'pdf', 
                            title: 'Custom Title', 
                            filename: function() {
                                return 'Custom_File_Name_' + new Date().toISOString().slice(0,10);
                            },
                        },
                        {
                            text: 'Button Text', 
                            action: function(e, dt, node, config ){
                                //do something
                                return; 
                            }
                        }
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                //Change Table Row Attributes 
            }

        });

        table.on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                row = dt.row(indexes[0]).node(); 
                modal = $('#content-modal'); 
                modal.modal('show'); 
                selectedRow = $(dt.row(indexes).node()); 
                //data = { 'id' => $(row).data('id') };
                //url = `base_url'`;
                
                //$.post(url, data, function(response){
                    //do something with data.
                    //  if(response.success)
                    //  {
                    //     Swal.fire({
                    //         title: `${response.title}`,
                    //         text: `${response.message}`,
                    //         icon: 'success',
                    //         confirmButtonText: 'OK'
                    //     });
                    //  }else{
                    //     Swal.fire({
                    //         title: `${response.title}`,
                    //         text: `${response.message}`,
                    //         icon: 'warning',
                    //         confirmButtonText: 'OK'
                    //     });
                    //  }
                //})
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