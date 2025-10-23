<style>
    .table.dataTable td, .table.dataTable th { font-size: .88em; }
</style>
<script src="<?= base_url(MANAGEDASSETS.'datatables.net-plugins/dataRender/ellipsis.min.js')?>"></script>
<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });

        function showLoading()
        {
            Swal.fire({
                title: 'Loading data...',
                text: 'Please wait while the work orders are being retrieved',
                allowOutsideClick: false, // Prevent closing by clicking outside
                allowEscapeKey: false,   // Prevent closing with Escape key
                onOpen: () => {
                    Swal.showLoading(); // Display the loading spinner
                },
            });
        }

        const table = new DataTable('.table', {
            //select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= base_url('purchasing/orders/data') ?>', 
                dataSrc: 'data',
            },
            pageLength: 200,    
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
                    title: 'Vendor',  
                    width: '5%',
                    className: 'text-center',
                }, //0
                {
                    data: 'base_id',
                    title: 'ID',
                    width: "5%",
                    className: 'text-center',
                }, //1
                {
                    data: 'desired_want_date',
                    title: 'Want Date', 
                    visible: false,
                    
                },//2
                {
                    data: 'part_id',
                    title: 'Part ID', 
                    width: '10%',
                    className: 'text-center',
                },//3
                {
                    data: 'description', 
                    title: 'Description',
                    orderable:false,
                    width: '20%',
                    className: 'text-truncate',
                },//4
                {
                    data: 'order_date',
                    title: 'Order By',
                    width: '8%',
                    className: 'text-center',
                },//5
                {
                    data: 'qty_to_order',
                    title: 'QTO', 
                    render: function(data, type, row)
                    {
                        return  row.qty_to_order + ' ' + row.stock_um; 
                    },
                     width: "10%",
                     orderable:false,
                     className: 'text-center',
                },//6
                {
                    data: 'qty_on_hand', 
                    title: 'QOH', 
                    width: "5%",
                    orderable:false,
                    className: 'text-center',
                },//7
                {
                    data: 'qty_on_order',
                    title: 'QOO',
                    width: "5%",
                    orderable:false,
                    className: 'text-center',
                },//8
                {
                    data: 'qty_remaining',
                    title: 'RQ',
                    width: "5%",
                    orderable:false,
                    className: 'text-center',
                },//9
                {
                    data: 'qty_in_demand',
                    title: 'QOD',
                    width: "5%",
                    orderable:false,
                    className: 'text-center',
                },//10
                {
                    data: 'certificates',
                    title: 'Certs', 
                    width: "7%",
                    orderable:false,
                    className: 'text-center',
                },//11
                {
                    data : 'dpas_rating',
                    title: 'DPAS', 
                    width: "5%",
                    orderable:false,
                    className: 'text-center',
                },
                {
                    data: 'safety_stock',
                    title: 'SS',
                    visible: false,
                },
                {
                    data: 'contract_no', 
                    title: 'Contract', 
                    width: '15%',
                    className: 'text-center',
                },
                {
                    data: 'planner_id', 
                    title: 'Type', 
                    visible: false,
                    
                },
                {
                    data: 'truck',
                    title: 'Is Truck', 
                    visible : false, 
                }

            ],
            columnDefs:[
                {
                    targets:[0,1,3,4,7,8,9],
                    className: 'dt-center', 
                },
                {
                    targets:[11,12],
                    render: DataTable.render.ellipsis(10,true),
                }
                // {
                //     orderable: false,
                //     targets:[4,7,8,9]
                // },
                // {
                //     targets:[0,4],
                //     width: '5%'
                // },
                // {
                //     targets:[3],
                //     width: '8%'
                // },
                // {
                //     targets:[7,8,9],
                //     width: '10%'
                // },
                // {
                //     targets:[5,6],
                //     width: '20%'
                // }
            ],
            layout:{
                topStart:{
                    buttons:[
                         'pageLength', 

                        {
                            extend: 'excelHtml5',   
                            text: '<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel', 
                            filename: 'WorkOrders_PurchaseReport_<?= date('Ymdhis') ?>',   // File name without extension
                            title: 'Work Orders Purchase Report',      // Sheet title
                            exportOptions: {
                                columns: ':visible', 
                                modifier: {
                                    page: 'all',       
                                    search: 'applied' 
                                },

                            },
                        },

                         {
                            extend: 'collection',
                            text: 'Type',
                            className: 'btn-secondary',
                            buttons: [
                                {
                                    text: 'Hardware',
                                    action: function(e, dt, node, config)
                                    {                                        
                                        dt.column(15).search('(^$|null)', true, false).column(16).search('0',true, false).draw(); 
                                        $('#label').html('Showing Hardware Work Orders')
                                    }
                                },
                                {
                                    text: 'Wire',
                                    action: function(e, dt, node, config)
                                    {                                        
                                        dt.column(15).search('W', true, false).draw(); 
                                       $('#label').html('Showing Wire Work Orders')
                                    }
                                },
                                {
                                    text: 'Chemical',
                                    action: function(e, dt, node, config)
                                    {                                        
                                        dt.column(15).search('C', true, false).draw(); 
                                        $('#label').html('Showing Chemical Work Orders')
                                    }
                                },
                                {
                                    text: 'Paint',
                                    action: function(e, dt, node, config)
                                    {                                        
                                        dt.column(15).search('P', true, false).draw(); 
                                        $('#label').html('Showing Paint Work Orders')
                                    }
                                },
                                {
                                    text: 'Material',
                                    action: function(e, dt, node, config)
                                    {
                                         dt.column(15).search('M', true, false).draw(); 
                                         $('#label').html('Showing Material Work Orders')
                                    }
                                },
                                {
                                    text: 'Fabricated',
                                    action: function(e, dt, node, config)
                                    {
                                         dt.column(15).search('D', true, false).draw(); 
                                         $('#label').html('Showing Fabricated Work Orders')
                                    }
                                },
                                {
                                    text: 'Trucks', 
                                    action: function(e, dt, node, config)
                                    {
                                        dt.column(16).search('1', true, false).draw(); 
                                        $('#label').html('Showing 5K, 7K, DHC Trucks');
                                    }
                                },
                                {
                                    text: 'All',
                                    action: function(e, dt, node, config)
                                    {
                                        dt.column(15).search('', true, false).draw();
                                        $('#label').html('Showing All Work Orders')
                                    }
                                }
                            ]
                         },
                    ],
                    div:{
                        html:` <div class="row">
                                 <div class="col-5">
                                    <input type="text" class="form-control date-picker" id="end_date" placeholder="End Date">
                                 </div>
                                 <div class="col">
                                    <div class="d-flex justify-content-center align-items-center h-100 w-100 rounded-1" style="background-color: #FF8B75; ">
                                         <span class="" id="label" >Showing Hardware Work Orders</span>
                                    </div>
                                 </div>
                                </div>`, 
                    }
                }
            },
            createdRow: function(row, data, dataIndex){
                //Change Table Row Attributes 
            }

        });

        table.on('init', function(){
            table.column(15).search('(^$|null)', true, false);
            table.column(16).search('0',true, false);
            table.draw(); 
        });

        table.on('draw.dt', function(){
            Swal.close(); 
            $("#dt-search-0").focus(); 
        })

        table.on('select', function (e, dt, type, indexes){
            return;
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

        const datepicker = flatpickr("#end_date", {
            dateFormat: 'Y-m-d', 
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance)
            {
                url = '<?= base_url('purchasing/orders/data/') ?>'+ dateStr; 
                table.ajax.url(url).load();
                showLoading();
            },
        })

        showLoading(); 
    })
</script>