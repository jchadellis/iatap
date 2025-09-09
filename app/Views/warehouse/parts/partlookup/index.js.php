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
                url: '<?= base_url('warehouse/parts/part-lookup/data') ?>', 
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
                    data: 'id', 
                    title: 'Part ID',
                },
                {
                    data: 'description', 
                    title : 'Description', 
                },
                {
                    data: 'qty_on_hand', 
                    title: 'QTY', 
                },
                {
                    data: 'primary_loc_id', 
                    title: 'Location ID', 
                },
                {
                    data: 'unit_price', 
                    title: 'Unit Price', 
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
                            title: 'Custom Title', 
                            filename: function() {
                                return 'Custom_File_Name_' + new Date().toISOString().slice(0,10);
                            },
                        },
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                $(row).data('id', data.id); 
            }

        });

        table.on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                row = dt.row(indexes[0]).node(); 
                modal = $('#content-modal'); 
                modal.modal('show'); 
                selectedRow = $(dt.row(indexes).node()); 
                data = { 'id' : $(row).data('id') };
                url = `<?= base_url('warehouse/parts/part-lookup/details')?>`;
                
                $.post(url, data, function(response){
                     if(response.success)
                     {
                        modal.find('.modal-content').html(response.data);
                     }else{
                        Swal.fire({
                            title: `${response.title}`,
                            text: `${response.message}`,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                     }
                })
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

        $('#search-btn').on('click', function(e){
            e.preventDefault(); 
            Swal.showLoading()
            form = $('#part-search-form'); 
            url = '<?= base_url('warehouse/parts/part-lookup/data') ?>'; 
            data = form.serialize(); 
            table.clear()
            $.post(url, data, function(response){
                if(response.success)
                {
                    table.rows.add(response.data).draw(); 
                    Swal.close(); 
                }else{
                    Swal.fire({
                        title: response.title, 
                        text: response.message,
                        icon: 'warning', 
                    })
                }
            })
        })

    })
</script>