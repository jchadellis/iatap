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
            select: false, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            data:[],
            ajax:{
                url: '', 
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
                    data: 'location_id', 
                    title: 'Location', 
                },
                {
                    data: 'id', 
                    title: 'Part ID', 
                },
                {
                    data: 'description', 
                    title: 'Description', 
                },
                {
                    data: 'location_qty', 
                    title: 'Location Qty', 
                },

            ],
            columnDefs:[
                { targets: [0,3], width:'15%', className:'text-center'}
            ],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength',
                        {
                            extend: 'print',
                            text: '<i class="bi bi-printer"></i>&nbsp;Print',
                            title: 'Inventory Location Qtys',
                            autoPrint: true,
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function (win) {
                                const $body = $(win.document.body);
                                const $table = $body.find('table');

                                // Global styles
                                $body.css({
                                    'font-size': '10pt',
                                    'margin': '0'
                                });

                                // Table styling
                                $table.addClass('compact').css({
                                    'font-size': 'inherit',
                                    'border-collapse': 'collapse',
                                    'width': '100%'
                                });

                                // Optional: Add header above the table
                                //$body.prepend('<h6 style="text-align:center; margin-bottom:10px;">Inventory Location QTYs</h6>');

                                // Append safe CSS for print layout
                                $(win.document.head).append(`
                                    <style>
                                        @media print {
                                            @page {
                                                size: A4 portrait;
                                                margin: 0.25in;
                                            }
                                            body {
                                                margin: 0in !important;
                                            }
                                            table {
                                                page-break-inside: auto !important;
                                                border-collapse: collapse !important;
                                                width: 100% !important;
                                            }
                                            thead { display: table-header-group; }
                                            tfoot { display: table-footer-group; }
                                            table tr {
                                                page-break-inside: avoid !important;
                                                page-break-after: auto !important;
                                            }
                                            /* More specific alternate row coloring */
                                            table tr:nth-child(even) td {
                                                background-color: #f2f2f2 !important;
                                            }
                                            table tr:nth-child(odd) td {
                                                background-color: transparent !important;
                                            }
                                            th, td {
                                                border: 1px solid #a3a3a3ff !important;
                                                padding: 6px 8px !important;
                                                text-align: left !important;
                                            }
                                        }
                                    </style>
                                `);
                            }
                        },
                        // {
                        //     extend: 'pdf', 
                        //     title: 'Inventory Location Qtys', 
                        //     filename: function() {
                        //         return 'inventory_location_qtys' + new Date().toISOString().slice(0,10);
                        //     },
                        // },
                    ],
                    div:{
                        html:`  <form id="form-cycle-report"><div class="d-flex flex-row justify-content-center align-items-center h-100">
                                    <input type="text" name="start" value="" class="form-control" placeholder="Start Location"> 
                                    <div class="d-flex align-items-center h-100 p-3"> TO </div>
                                    <input type="text" name="finish" value="" class="form-control" placeholder="End Location">
                                    <button type="submit" class="btn btn-primary ms-2 text-nowrap" id="get-report">Get Report</button>
                                </div></form>`,
                    }
                }
            },
            createdRow: function(row, data, dataIndex){
                //Change Table Row Attributes 
            }
        });

        table.on('init', function(){

        })

        table.on('preXhr.dt', function() {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });

        table.on('xhr.dt', function() {
            Swal.close();
        });

        document.addEventListener('submit', function(e){
            e.preventDefault(); 
            const reportForm = document.getElementById('form-cycle-report'); 
            const data = new FormData(reportForm);
            
            Swal.fire({
                title: 'Loading data...',
                text: 'Please wait while data is fetched.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });


            fetch('<?= base_url('warehouse/cycle-counts/data')?>',{
                method: 'POST', 
                body: data, 
            }).then(result=>result.json())
             .then(data => {
                if(data.success)
                {
                    table.clear(); 
                    table.rows.add(data.data).draw(); 
                    swal.close(); 
                }else{
                    Swal.fire({
                        title: data.title, 
                        icon: data.icon, 
                        html: data.html, 
                    })
                }
             })
        })

    })
</script>