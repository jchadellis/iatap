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
                url: '<?= base_url('vendors/list/data') ?>', 
                dataSrc: 'data',
            },        
            pageLength: 25,    
            responsive: true,
            order:[[0, 'asc']],
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
                },
                {
                    data: 'name', 
                    title: 'Name', 
                },
                {
                    data: 'open_date', 
                    title: 'Created', 
                },
                {
                    data: 'modify_date', 
                    title: 'Last Updated', 
                },
                {
                    data: 'street_1', 
                    title: 'Street Address', 
                    visible: false, 
                },
                {
                    data: 'street_2', 
                    title: 'Street Address 2', 
                    visible: false, 
                },
                {
                    data: 'state', 
                    title: 'State', 
                    visible: false, 
                },
                {
                    data: 'city', 
                    title: 'City', 
                    visible: false, 
                },
                {
                    data: 'zip', 
                    title: 'Zip', 
                    visible: false, 
                },
                {
                    data: 'phone', 
                    title: 'Phone', 
                    visible: false, 
                },
                {
                    data: 'email', 
                    title: 'email', 
                    render: function(data, type, row){
                        data = data ?? ''; 
                        return data.toLowerCase(); 
                    },
                    visible: false, 
                },
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
                            title: 'Vendor List', 
                            filename: function() {
                                return 'Vendor_List_' + new Date().toISOString().slice(0,10);
                            }
                        },
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                //Change Table Row Attributes 
            }

        });

        table.on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                // row = dt.row(indexes[0]).node(); 
                // modal = $('#content-modal'); 
                // modal.modal('show'); 
                // selectedRow = $(dt.row(indexes).node()); 
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