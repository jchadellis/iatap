<script>
    $(document).ready(function(){

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success m-2",
                cancelButton: "btn btn-danger m-2"
            },
            buttonsStyling: false
        });

        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' 
                }
            }
        });

        const table = new DataTable('.table', {
            select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= base_url('purchasing/workrequest/data') ?>', 
                dataSrc: 'data',
            },        
            pageLength: 25,    
            responsive: true,
            order:[[5, 'desc']],
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
                    data: 'request_id', 
                    title: 'Request ID', 
                    visible: false, 
                },
                {
                    data: 'work_order', 
                    title: 'Work Order', 
                },
                {
                    data: 'request_by_email', 
                    title: 'Requested By', 
                },
                {
                    data: 'qty', 
                    title: 'Qty', 
                },
                {
                    data: 'part_id', 
                    title: 'Part ID', 
                },
                {
                    data: 'created_at', 
                    title: 'Created Date', 
                    render: function(data, type, row)
                    {   
                        var dt = new Date(data);

                        year  = dt.getFullYear();
                        month = (dt.getMonth() + 1).toString().padStart(2, "0");
                        day   = dt.getDate().toString().padStart(2, "0");
                        str = year + '-' + month + '-' + day;
                        return str ; 
                    }
                },
                {
                    data: 'due_date', 
                    title: 'Due Date', 
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
                        'excel',
                        {
                            text: '<i class="bi bi-plus-square"></i>&nbsp;New Work Request', 
                            className: 'btn-success',
                            action: function(e, dt, node, config ){
                                let modal = $('#add-modal'); 
                                modal.modal('show'); 
                                return; 
                            }
                        }
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                $(row).data('id', data.id); 
                $(row).data('request_id', data.request_id);
            }

        });

        table.on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                row = dt.row(indexes[0]).node(); 
                modal = $('#content-modal'); 

                selectedRow = $(dt.row(indexes).node()); 
                data = { 'id' : $(row).data('id') };
                url = `<?= base_url('purchasing/workrequest/get') ?>`;
                
                $.post(url, data, function(response){

                     if(response.success)
                     {
                        modal.modal('show'); 
                        content = modal.find('.modal-content > .modal-body'); 
                        content.html(response.data); 
                        $('.datepicker').flatpickr({
                            dateFormat: 'Y-m-d',
                        }); 

                        $('.demand-type-select').on('change', function(){
                            val = $(this).val();
                            if(val == '1'){
                                $('.demand-id-input').attr('disabled', false); 
                            }else{
                                $('.demand-id-input').attr('disabled', true); 
                            }
                        })

                        form = modal.find('form'); 
                        form.off('submit').on('submit', function(e){
                            e.preventDefault(); 
                            data = $(this).serialize(); 
                            url = "<?= base_url('purchasing/workrequest/update')?>"; 
                            $.post(url, data, function(response){
                                if(response.success)
                                {
                                    Swal.fire({
                                        title: `${response.title}`,
                                        text: `${response.message}`,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });

                                } else {
                                    Swal.fire({
                                        title: `${response.title}`,
                                        text: `${response.message}`,
                                        icon: 'warning',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        });

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

        $('#close-btn').on('click', function(){
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "Closing the request will remove it from the list.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Close",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                if(selectedRow)
                {
                    row = table.row(selectedRow).node(); 
                    url = `<?= base_url('purchasing/workrequest/close') ?>`; 
                    data = { 'id' :  $(row).data('id'), 'request_id' : $(row).data('request_id')}; 
                    $.post(url, data, function(response){
                        if(response.success)
                        {
                            swalWithBootstrapButtons.fire({
                                title: "Close Work Request!",
                                text: "The Work Request has been closed!",
                                icon: "success"
                            });
                            modal.modal('hide'); 
                        }
                    });
                }

            } else if ( result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Closing Work Request has been canceled.",
                    icon: "error"
                });
                modal.modal('hide'); 
            }
            });
        })

        $('#content-modal').on('hidden.bs.modal', function(){
            if(selectedRow) {
                row = table.row(selectedRow);
                row.deselect(); 
                selectedRow = null;
            }
        });


        $('.datepicker').flatpickr({
            dateFormat: 'Y-m-d',
        }); 

        $('.demand-type-select').on('change', function(){
            val = $(this).val();
            if(val == '1'){
                $('.demand-id-input').attr('disabled', false); 
            }else{
                $('.demand-id-input').attr('disabled', true); 
            }
        })


    })
</script>