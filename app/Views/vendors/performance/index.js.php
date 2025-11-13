<script>
    document.addEventListener('DOMContentLoaded', ()=>{
        const mainModalEl = document.getElementById('main-modal');
        const mainModal = new bootstrap.Modal(mainModalEl); 
        const secondaryModalEl = document.getElementById('secondary-modal');
        const secondaryModal = new bootstrap.Modal(secondaryModalEl);
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

        Swal.fire({
            title: 'Loading',
            text: 'Please wait while the vendor list is loading...', 
            icon: 'info', 
            didOpen: ()=>{
                Swal.showLoading(); 
            }
        })

        const table = new DataTable('#vendorTable', {
            ajax: function(data, callback, settings){ 
                $.ajax({
                    url: '<?= base_url('vendors/performance/data') ?>',
                    data: data,
                    dataType: 'json', 
                    success: function(response){
                        callback(response); 
                        Swal.fire({
                            title: response.title, 
                            html: response.html, 
                            icon: response.icon,
                        })
                    },
                    error: function(xhr, status, error){
                    }
                })
            },
            order: [0, 'asc'],
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
                {
                    data: 'late_percentage', 
                    title : 'Late %',
                    render: function(data, type, row){
                        return `
                            <div class="progress w-100" role="progressbar" aria-label="Basic example" aria-valuenow="${data}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar ${row.bg_color}" role="progressbar" style="width: ${data}%;">
                                  ${data}%  
                                </div>
                            </div>`;
                    }
                },
                {data: "total_lines", title: "Lines"},
                {data: "total_on_time", title: "On Time"},
                {data: "total_late", title: "Late"},
                {
                    data: 'open_purchase_orders', 
                    title: 'Open',
                    // render: function(data, type, row)
                    // {
                    //     return `<button type="button" class="btn btn-link open-pos-btn text-decoration-none">${data}</button>`;
                    // }
                },
                {data: 'street_1', title: 'Street 1'},
                {data: "street_2", title: "Street 2", render:function(data, type, row){ return data ? data : '&nbsp;'}},
                {data: "city", title: "City"},
                {data: "state", title: "State"},
                {data: "zip", title: "Zip"},
                {data: "phone", title: "Phone", render:function(data, type, row){ return data ? data : '&nbsp;'}},
                {data: "email", title: "Email", render:function(data, type, row){ return data ? data : '&nbsp;'}},

                {data: "ncp", title: "NCP"},
                {data: "start_date", title: "Start Date"},
                {data: "end_date", title: "End Date"},
               
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
                        },
                    ],
                    div: {
                        html:`
                            <form id="date-range-form">
                                <div class="row">
                                    <div class="col-10"> 
                                        <div class="input-group"> 
                                            <span class="input-group-text" >Start Date</span>
                                            <input type="text" name="start_date" class="form-control form-control-sm  datepicker text-center">
                                            <span class="input-group-text">-</span>
                                            <span class="input-group-text">End Date</span>
                                            <input type="text" name="end_date" class="form-control form-control-sm  datepicker text-center">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>`,
                    }
                },
            },
            columnDefs:[
                {targets:[0,16], width: '10%'},
                {targets:[0,2,3,4,5,7], orderable: false},
                {targets:[0,1,16], className : 'text-center'},
                {targets:[2,3,4,5,6], className: 'text-end'},
                {targets:[8,9,10,11,12,13,14,15,16,17],  visible: false }
            ],
            createdRow: function( row, data, dataIndex ){
                $(row).attr('data-target', data.id );
                $(row).attr('data-vendor_id', data.vendor_id); 
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();



                var totalLines = api
                    .column(4, { page: 'all' })
                    .data()
                    .reduce(function (a, b) {
                        return Number(a) + Number(b);
                    }, 0);

                var totalOnTime = api
                    .column(5, { page: 'all' })
                    .data()
                    .reduce(function (a, b){
                        return Number(a) + Number(b); 
                    }, 0);

                var totalLate = api
                    .column(6, {page :'all'})
                    .data()
                    .reduce(function (a, b){
                        return Number(a) + Number(b);
                    },0);


                var onTimePercent = (totalOnTime / totalLines) * 100; 
                var latePercent = (totalLate / totalLines) * 100; 
                
                $(api.column(2).footer()).html(`${onTimePercent.toFixed(2)}%`); 
                $(api.column(3).footer()).html(`${latePercent.toFixed(2)}%`)
                $(api.column(4).footer()).html(totalLines);
                $(api.column(5).footer()).html(totalOnTime);
                $(api.column(6).footer()).html(totalLate);
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
            const modalBtn = modalBody.querySelector('#purchase-order-modal-btn');
            modalBtn.addEventListener('click', function(e){
                e.preventDefault();
                url = `<?= base_url('vendors/performance/open-lines/') ?>${this.dataset.id}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data =>{
                        if(data.success)
                        {
                            secondaryModalContent = secondaryModalEl.querySelector(".modal-content"); 
                            secondaryModalBody = secondaryModalContent.querySelector('.modal-body'); 
                            secondaryModalBody.innerHTML = data.data; 
                        }else{
                            showAlert(data);
                        }
                    });
                secondaryModal.show(); 
            })
        }

        function showAlert(data)
        {

            Swal.fire({
                title: data.title, 
                html: data.html, 
                icon: data.icon,
                sanitize: false,
            })
        }

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

        table.on('init', function(){
            Swal.close(); 
            const dateForm = document.getElementById('date-range-form'); 
            const getPoBtns = document.querySelector('.open-pos-btn'); 

            $('.datepicker').flatpickr(); 
            if( dateForm )
            {
                dateForm.addEventListener('submit', function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: 'Plese wait...',
                        text: 'Fetching new data...', 
                        icon: 'info', 
                        showConfirmButton: false, 
                        allowOutsideClick: true,
                        willOpen: () =>{
                            Swal.showLoading(); 
                        } 
                    })

                    formData = new FormData(dateForm);
                    url = '<?= base_url('vendors/performance/data') ?>'; 

                    fetch(url, {
                        method : 'POST', 
                        body : formData,
                    }).then(response => response.json())
                        .then(data => {
                            if(data.success)
                            {
                                table.clear(); 
                                table.rows.add(data.data).draw(); 
                                Swal.close();
                                showAlert(data)

                                setTimeout(() => {
                                    Swal.close();
                                }, 3000);

                            }
                        });

                });
            }

        })

        table.off('select').on('select', function (e, dt, type, indexes) {
            row = dt.row('.selected').node(); 
            id = row.dataset.vendor_id;  
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