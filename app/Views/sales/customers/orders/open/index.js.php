
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
            //select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= $urls['data'] ?>', 
                dataSrc: 'data',
            },      
            fixedHeader: {
                header: true,
            },  
            pageLength: -1,    
            responsive: true,
            order:[[0, 'asc'], [3, 'asc']],
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
                    data: 'order_id', 
                    title: 'Order', 
                },
                {
                    data: 'customer_id', 
                    title: "Customer", 
                },
                {
                    data: 'ship_date', 
                    title: 'Ship Date',
                },
                {
                    data: 'col_line_no', 
                    title : 'Line No', 
                },

                {
                    data: 'part_id', 
                    title: 'Part ID', 
                },
                {
                    data: 'description', 
                    title: 'Description', 
                },
                {
                    data: 'col_order_qty', 
                    title: 'Ordered', 
                },
                {
                    data: 'qty_on_hand', 
                    title: 'QOH', 
                },
                {
                    data: 'qty_on_order', 
                    title: 'QOO', 
                },
                {
                    data: 'qty_in_demand', 
                    title: 'QID',
                },
                {
                    data: 'col_unit_price', 
                    title: "Price", 
                    render: function(data, type, row){
                        number = new Intl.NumberFormat('en-US',{ style: "currency", currency: 'USD'}).format(data);
                        return number;
                    }
                },
            ],
            columnDefs:[
                {
                    targets:[0,1,2,3,4,6,7,8,9],
                    className: 'text-center',
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
                //data = { 'id' : $(row).data('id') };
                //url = `base_url()`;
                
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