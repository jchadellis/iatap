<?= view('components/loading-modal'); ?>
<script>
    document.addEventListener('DOMContentLoaded', ()=>{

            // Default button styling for all DataTables buttons
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary'
                }
            }
        });

        const table = new DataTable('#vendorTable', {
            ajax: function(data, callback, settings){ 
                const id = 'loadModal';
                const loadingModal = showLoadingModal(id, 'Loading Vendor List', `Please wait...`);
                const loadModal = document.getElementById(id);

                $.ajax({
                    url: '<?= base_url('vendors/data') ?>',
                    data: data,
                    dataType: 'json', 
                    success: function(response){
                        setTimeout(() => {
                            loadingModal.hide(); 
                        }, 1000);
                        callback(response); 
                    },
                    error: function(xhr, status, error){
                        loadingModal.hide(); 
s                    }
                })
            },
            processing: false, 
            pageLength: 100,
            columns:[
                {data: 'vendor_id', title: 'Vendor ID'},
                {data: 'name', title: 'Vendor Name'},
                {
                    data: 'on_time_percentage', 
                    title : 'On Time %',
                    render: function(data, type, row){
                        return `
                            <div class="progress w-100" role="progressbar" aria-label="Basic example" aria-valuenow="${row.on_time_percentage}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar ${row.bg_color}" role="progressbar" style="width: ${row.on_time_percentage}%;">
                                  ${row.on_time_percentage}%  
                                </div>
                            </div>`;
                    }
                },
                {data: 'street_1', title: 'Street 1'},
                {data: "street_2", title: "Street 2"},
                {data: "city", title: "City"},
                {data: "state", title: "State"},
                {data: "zip", title: "Zip"},
                {data: "phone", title: "Phone"},
                {data: "email", title: "Email"},
                {data: "total_lines", title: "Total Lines"},
                {data: "total_on_time", title: "Total On Time"},
                {data: "total_late", title: "Total Late"},
                {data: "ncp", title: "NCP"},
                {data: "start_date", title: "Start Date"},
                {data: "end_date", title: "End Date"},
               
            ],
            select: true, 
            layout:{
                top2Start: {
                    buttons: [
                        {
                            extend: "pageLength",
                        },
                        "spacer",
                        {
                            extend: "excel",
                            text: "Export to Excel",
                            title: "Vendors <?=date('m-d-Y')?>",
                            filename: "vendors_<?=date('Ymd')?>",
                            sheetName: "Vendors",
                                //insertCells: true,
                                excelStyles: [
                                
                                {
                                    rowref: "smart",
                                    cells: "t", 
                                    style:{
                                        fill:{
                                            pattern:{
                                                color:"1C3144",
                                            }
                                        },
                                        font: {                 
                                            size: 14,           
                                            color:"FFFFFF",
                                            b: true    
                                        },
                                    },

                                },
                                // Header style
                                {
                                    cells: "sh",                
                                    style: {      
                                        alignment:{
                                            vertical: "center",
                                            horizontal: "center",
                                        },              
                                        font: {                 
                                            size: 12,           
                                            color:"FFFFFF"        
                                        },
                                        fill: {                 
                                            pattern: {          
                                                color: "72a3d1" 
                                            }
                                        }
                                    }
                                },

                                // Even rows (starting with 2nd data row)
                                {
                                    cells: 's:n1,2',
                                    style: {
                                        fill: {
                                            pattern: {
                                                color: 'bedcf9'
                                            }
                                        }
                                    }
                                },

                            ]
                            
                        }
                    ]
                },
            },
            columnDefs:[
                {targets:[0,1], orderable: false},
                {targets:[0,1,2], className : 'text-center'},
                {targets:[3,4,5,6,7,8,9,10,11,12,13,14,15],  visible: false }
            ],
            createdRow: function( row, data, dataIndex ){
                $(row).attr('data-target', data.id );
            }
        });

        table.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                const rowNode = dt.row(indexes[0]).node();
                const target = $(rowNode).data('target');
                $(`#${target}`).modal('show');
            }
        });
    })
</script>