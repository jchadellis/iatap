
<?= view('components/loading-modal'); ?>

<script>
$(document).ready(() => {
    let activeFilter = null;

    // Default button styling for all DataTables buttons
    $.extend(true, $.fn.dataTable.Buttons.defaults, {
        dom: {
            button: {
                className: 'btn'
            }
        }
    });

    const table = new DataTable('.table', {

        ajax: {
            url : "<?= base_url('purchasing/tools/bookings/data/-30') ?>",
            dataSrc: 'data', 
        },
        columns:[
            {
                data: 'id', 
                title: 'PO NO.', 
                width: '5%'
            },
            {
                data: 'true_promise.date',
                visible: false // HIDDEN column for sorting
            },
            {
                data: 'true_promise',  
                title:'Promise Date',
                render: function(data, type, row){
                    tpDate = new Date(data.date); 
                    return tpDate.toLocaleDateString(); 
                },
                width: '5%',
            },
            {
                data: 'last_vendor_update_at',  
                title:'Last Vendor Update Req.',
                width: '5%',
            },
            // {
            //     data: 'next_vendor_update_at', 
            //     title: 'Next Vendor Update Req.',
            //     width: '5%',
            // },
            {
                data: 'linear_progress', 
                visible: false, 
            },
            {
                data: 'linear_progress', 
                title:'Lead Time Progress',
                render: function(data, type, row){

                    const percent = parseInt(data, 10) || 0;

                    clamped = Math.min(Math.max(percent, 0), 100); 

                    if( percent <= 25 ){
                        colorClass = 'bg-success';
                    }else if( percent > 25 && percent <= 89 ){
                        colorClass = 'bg-primary'; 
                    }else if( percent >= 90 && percent <= 99 ){
                        colorClass = 'bg-warning text-dark'; 
                    }else{
                        colorClass = 'bg-danger'; 
                    }

                    return `
                        <div class="d-flex justify-content-center align-items-center" style="height: 100%; min-height: 20px;">
                            <div class="progress w-100" style="max-width: 300px; height: 20px;">
                                <div class="progress-bar ${colorClass}" role="progressbar" style="width: ${clamped}%;">
                                  ${clamped}% &nbsp; 
                                </div>
                            </div>
                        </div>
                    `;
                },
                width: '10%',
            },
            { 
                title: 'Vendor', 
                render: function(data, type, row){
                  return  `<b> ${row.vendor_id} </b> - ${row.name}`; 
                },
                width: '25%'
            },
            {
                data: 'buyer', 
                title: 'Buyer', 
                width: '5%'
            },
            {
                data: 'contact_first_name', 
                // title:'C. Name', 
                // width: '5%', 
                visible: false,
                // render: function(data, type, row){
                //     return `${row.contact_first_name} ${row.contact_last_name} `; 
                // }
            },
            {
                data: 'phone', 
                // title: 'C. Phone', 
                // width: '10%'},
                visible: false,
            },
            // {
            //     data: 'id', 
            //     title: 'Details',
            //     render: function(data, type, row){
            //         return `
            //             <button class="btn btn-sm btn-primary update-btn" data-id="${data}">
            //                 OPEN
            //             </button> 
            //         `; 
                    
            //     }, 
            //     className: 'd-grid',
            //     width: '5%',
            // }
        ],
        createdRow: function( row, data, dataIndex ){
            const date = new Date(data.true_promise.date);
            const formattedDate = date.toISOString().split('T')[0];
            $(row).attr('data-vendor', data.vendor_id );
            $(row).attr('data-purchase_order', data.id);
            $(row).attr('data-true_promise', formattedDate );
        },
        ordering: true,
        autoWidth: false,
        select: true,
        pageLength: 200,

        lengthMenu: [
            [10, 20, 50, 100, 200, -1],//Values
            [10, 20, 50, 100, 200, 'Show All']//labels
        ],

        layout: {
            top2Start: {
                buttons: [
                    {
                        extend: "pageLength",
                        className: 'btn-primary'
                    },
                    "spacer",
                    {
                        extend: "excel",
                        text: "Export to Excel",
                        title: "PO Bookings <?=date('m-d-Y')?>",
                        filename: "po_booking_<?=date('Ymd')?>",
                        sheetName: "Purchase Order Bookings",
                        className: "btn-primary"
                    }
                ]
            },
            top2End: 'search',
            topStart: {
                buttons: [
                    {
                        text: "< 30 Days or Late",
                        className: 'btn-outline-danger filter-btn active',
                        action: function () {
                            // get new date based on filter button
                            table.ajax.url('<?= base_url('purchasing/tools/bookings/data/-30')?>').load();
                            
                            // Update active button
                            $('.filter-btn').removeClass('active');
                            $(this[0].node).addClass('active');
                        }
                    },
                    {
                        text: "30 - 75 Days",
                        className: 'btn-outline-orange filter-btn',
                        action: function () {
                            // get new date based on filter button
                            table.ajax.url('<?= base_url('purchasing/tools/bookings/data/30-75')?>').load();
                            
                            // Update active button
                            $('.filter-btn').removeClass('active');
                            $(this[0].node).addClass('active');
                        }
                    },
                    {
                        text: "75 - 120 Days",
                        className: 'btn-outline-primary filter-btn',
                        action: function () {
                            // get new date based on filter button
                            table.ajax.url('<?= base_url('purchasing/tools/bookings/data/75-120')?>').load();
                            
                            // Update active button
                            $('.filter-btn').removeClass('active');
                            $(this[0].node).addClass('active');
                        }
                    },
                    {
                        text: "120 + Days",
                        className: 'btn-outline-success filter-btn',
                        action: function () {
                            // get new date based on filter button
                            table.ajax.url('<?= base_url('purchasing/tools/bookings/data/120+')?>').load();
                            
                            // Update active button
                            $('.filter-btn').removeClass('active');
                            $(this[0].node).addClass('active');
                        }
                    },
                    {
                        text: "Clear Filter",
                        className: 'btn-outline-dark filter-btn',
                        action: function () {
                            // get new date based on filter button
                            table.ajax.url('<?= base_url('purchasing/tools/bookings/data/all')?>').load();
                            
                            // Update active button
                            $('.filter-btn').removeClass('active');
                            $(this[0].node).addClass('active');
                        }
                    },
                ],
            },
            topEnd:[
                {
                    div: {
                        className:'layout-full',
                        html: ` 
                            <select class="form-select" name="buyer" placeholder="" id="buyer-select">
                                <option value="all" selected>All Buyers</option>
                                <?php if(isset($buyers)) : ?>
                                    <?php foreach($buyers as $key => $value ) : ?>
                                        <option value="<?= $value ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        ` 
                    }
                },
                {
                    div:{
                        html: `<button type="button" class="btn btn-primary" id="review-vendor" disabled><i class="bi bi-envelope-arrow-up-fill"></i>&nbsp; Request Update For Selected POs</button>`,
                    }
                }
            ]

        },

        columnDefs: [
            { targets: [2, 3, 4, 5, 6, 7,8,9], orderable: false },
            { targets: 1, type: 'date-eu' },
            { targets: [0, 1, 2, 3, 4, 6,  8, 9], className: 'align-middle text-center'},
            { target : [7], className: 'align-middle text-start text-truncate'}
            //{ targets: 9, visible: false } // Assuming percentage is column 9
        ],

        order: [[1, 'asc'], [5, 'desc']]
    });

    // Register the filter before any draw
    table.search(function (_searchAll, rowData) {
        if (!activeFilter) return true;
        const pct = parseFloat(rowData[9]) || 0;

        if (activeFilter === '25') return pct <= 25;
        if (activeFilter === '50') return pct > 25 && pct <= 50;
        if (activeFilter === '80') return pct > 50 && pct <= 80;
        if (activeFilter === '90') return pct > 80 && pct <= 90;
        if (activeFilter === 'late') return pct >= 100; 
        return true;
    }).draw();

    // Ctrl+F overrides browser search to focus on DataTables search input
    $(document).on('keydown', function (e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            $('#dt-search-0').focus();
        }
    });

    $('#buyer-select').on('change', function(){
        buyer = $(this).val(); 
        if( buyer === 'all' ){
            table.column(7).search('').draw();
        } else{
            table.column(7).search(buyer).draw(); 
        } 
    })

    // Row selection behavior
    table.on('select', function (e, dt, type, indexes) {
        $('#review-vendor').attr('disabled', false); 
    });

    table.on('deselect', function(e,dt,type, indexes){
        $('#review-vendor').attr('disabled', true); 
    });

    $('#review-vendor').on('click', function(e){
        e.preventDefault(); 

        const id = 'poLoadingModal';

        selectedRows = table.rows({ selected: true }); 

        postData = {
            items : [],
        };
    
        //SETUP VARS TO CHECK IF VENDOR IS UNIQUE; 
        let firstVendorId = null;
        let allSameVendor = true;

        $.each(selectedRows[0], function(){
            row = $(table.row(this).node()); 
            row = $(table.row(this).node()); 
            const vendorId = row.data('vendor');
            const poId = row.data('purchase_order');
            
            // Set first vendor ID as reference
            if (firstVendorId === null) {
                firstVendorId = vendorId;
            }
            
            // Check if current vendor matches first vendor
            if (vendorId !== firstVendorId) {
                allSameVendor = false;
                return false; // Break out of loop
            }
            
            globalThis.vendor = vendorId; 
            globalThis.po = poId; 
            
            postData.items.push({
                po_id : poId,
                vendor_id : vendorId
            }); 
        });

            // Check if all vendors are the same
        if (!allSameVendor) {
            Swal.fire({
                title: 'Vendor Selection Error',
                text: 'Please select Purchase Orders from the same vendor only.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        const loadingModal = showLoadingModal(id, 'Loading Purchase Order', `Please wait while the Purchase Order`);
        const poModal = document.getElementById(id);

        poModal.addEventListener('shown.bs.modal', function onShown() {
            setTimeout(() => {}, 1000);
            poModal.removeEventListener('shown.bs.modal', onShown);

            let url = '<?= base_url('purchasing/tools/bookings/view-email') ?>';
            $.post(url, postData, function (response) {
                if( response.success ){
                    loadingModal.hide();
                    const modal = $('#email_modal');
                    modal.find('.modal-content').html(response.html);
                    modal.modal('show');

                    $('#email-vendor').on('click', function(e){
                        e.preventDefault();
                        data = $('#email-form').serialize(); 
                        let url = "<?= base_url('purchasing/tools/bookings/send-email') ?>";
                        $.post(url, data, function(response){
                            if (response.success) {
                                modal.modal('hide'); 
                                Swal.fire({
                                    title: `${response.title}`,
                                    html: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                //modal.modal('hide'); 
                                return;
                            } else {
                                Swal.fire({
                                    title: `${response.title}`,
                                    html: `${response.message}`,
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                    })
                }   
            });
        });
    })

    // Email form AJAX logic
    $('#email_form').on('submit', function (e) {
        e.preventDefault();

        const form = $(e.target);
        const data = form.serialize();
        const id = 'emailLoadingModal';

        const bsModal = showLoadingModal(id, 'Sending Email', 'Please wait while we send the email...');
        const modalEl = document.getElementById(id);

        modalEl.addEventListener('shown.bs.modal', function onShown() {
            modalEl.removeEventListener('shown.bs.modal', onShown);

            $.get('<?= base_url('vendor/email-delivery-update') ?>', data, function (response) {
                modalEl.addEventListener('hidden.bs.modal', function onHidden() {
                    modalEl.removeEventListener('hidden.bs.modal', onHidden);
                    setTimeout(() => {}, 1000);
                    alert(response.message);

                    if (response.success) {
                        $('#content_modal').modal('hide');
                        modalEl.remove();
                    }
                });

                bsModal.hide();
            });
        });
    });
});


</script>