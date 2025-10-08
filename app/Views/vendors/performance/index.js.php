<script>
    document.addEventListener('DOMContentLoaded', ()=>{
        const mainModalEl = document.getElementById('main-modal');
        const mainModal = new bootstrap.Modal(mainModalEl); 
        const vendorModalUrl = "<?= base_url('vendors/performance/vendor') ?>"; 
        const vendorEmailBtn = document.getElementById('vendor-email-btn');
        const vendorEmailForm = document.getElementById('vendor-email-form'); 

        
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary'
                }
            }
        });

        const table = new DataTable('#vendorTable', {
            ajax: function(data, callback, settings){ 
                $.ajax({
                    url: '<?= base_url('vendors/performance/data') ?>',
                    data: data,
                    dataType: 'json', 
                    success: function(response){
                        callback(response); 
                    },
                    error: function(xhr, status, error){
                    }
                })
            },
            order: [16, 'desc'],
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
                {data: "street_2", title: "Street 2", render:function(data, type, row){ return data ? data : '&nbsp;'}},
                {data: "city", title: "City"},
                {data: "state", title: "State"},
                {data: "zip", title: "Zip"},
                {data: "phone", title: "Phone", render:function(data, type, row){ return data ? data : '&nbsp;'}},
                {data: "email", title: "Email", render:function(data, type, row){ return data ? data : '&nbsp;'}},
                {data: "total_lines", title: "Total Lines"},
                {data: "total_on_time", title: "Total On Time"},
                {data: "total_late", title: "Total Late"},
                {data: "ncp", title: "NCP"},
                {data: "start_date", title: "Start Date"},
                {data: "end_date", title: "End Date"},
                {data: 'open_purchase_orders', title: 'Open'},
               
            ],
            select: true, 
            language:{
                buttons:{
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                }
            },
            layout:{
                top2Start: {
                    buttons: [
                        {
                            extend: "pageLength",
                        },
                        "spacer",
                        {
                            extend: "excelHtml5",
                            text: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`,
                            title: "Vendors <?=date('m-d-Y')?>",
                            filename: "vendors_<?=date('Ymd')?>",
                            sheetName: "Vendors",
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

                                    {
                                        columns: [0,2,5,6,7,8,9,11,12,13,14,15,16],
                                        //applyTo: 'data',
                                        style: {
                                            alignment: {
                                                horizontal: 'center'
                                            }
                                        }
                                    }

                            ]                 
                        }
                    ]
                },
            },
            columnDefs:[
                {targets:[0,16], width: '10%'},
                {targets:[0,1], orderable: false},
                {targets:[0,1,2,16], className : 'text-center'},
                {targets:[3,4,5,6,7,8,9,10,11,12,13,14,15],  visible: false }
            ],
            createdRow: function( row, data, dataIndex ){
                $(row).attr('data-target', data.id );
            }
        });

        function handlePost(url, data)
        {
            return new Promise((resolve, reject) => {
                $.post(url, data, function(response){
                    if(response.success)
                    {
                        resolve(response.data);
                    } else {
                        reject(response);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown){
                    reject(errorThrown);
                });
            });
        }

        function handleShowModal(modalEl, modal, content){
            modalContent = modalEl.querySelector('.modal-content'); 
            modalBody = modalContent.querySelector('.modal-body'); 
            modalBody.innerHTML = content; 

            $('#message').trumbowyg({
                btns: [ 
                    ['viewHTML'],
                    ['undo', 'redo'], 
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['link'],
                    ['lineheight']
                ],
                height: 50,
                autogrow: true,
            });


            modal.show(); 
        }

        function showAlert(data)
        {

            // let message = '<ul class="list-group">'; 

            // for (const field in data.message) {
            //     const item = data.message[field];

            //     if (typeof item === 'object') {
            //         for (const subfield in item) {
            //             message += `<li class="list-group-item">${item[subfield]}</li>`;
            //         }
            //     } else {
            //         message += `<li class="list-group-item">${item}</li>`;
            //     }
            // }

            // message += '</ul>';      

            Swal.fire({
                title: data.title, 
                html: data.message, 
                icon: data.icon,
                sanitize: false,
            })
        }

        // function showWarning(data)
        // {

        //     let message = '<ul class="list-group">'; 

        //     for (const field in data.message) {
        //         const item = data.message[field];

        //         if (typeof item === 'object') {
        //             for (const subfield in item) {
        //                 message += `<li class="list-group-item">${item[subfield]}</li>`;
        //             }
        //         } else {
        //             message += `<li class="list-group-item">${item}</li>`;
        //         }
        //     }

        //     message += '</ul>';

        //     Swal.fire({
        //         title: data.title, 
        //         icon: message, 
        //         text: data.message,
        //     })
        // }

        vendorEmailForm.addEventListener('submit', async function(event) {
            event.preventDefault(); 

            const form = new FormData(vendorEmailForm);
            const url = '<?= base_url('vendors/performance/email-vendor') ?>';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: form, 
                });

                if (!response.ok) throw new Error(`HTTP error ${response.status}`);

                const result = await response.json();

                if(result.success)
                {
                    mainModal.hide(); 
                    showAlert(result);
                    
                }else{
                    showAlert(result); 
                }

            } catch (error) {
                console.error('Error:', error);
            }
        });


        table.off('select').on('select', function (e, dt, type, indexes) {
            row = dt.row('.selected').node(); 
            id = row.dataset.target;  
            handlePost(vendorModalUrl, {id: id})
                .then(content => {
                    handleShowModal(mainModalEl, mainModal, content); 
                })
                .catch(error => {
                    showAlert( error );
                });
        });


    })
</script>