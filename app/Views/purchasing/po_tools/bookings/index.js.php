
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
            url : "<?= base_url('purchasing/po-tools/bookings/get/-30') ?>",
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
            {
                data: 'next_vendor_update_at', 
                title: 'Next Vendor Update Req.',
                width: '5%',
            },
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
                                  ${clamped}% of ${row.lead_time_days} / ${Math.min(Math.max(row.elapsed_days, 0),row.lead_time_days) } &nbsp; 
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
                width: '5%'},
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
            {
                data: 'id', 
                title: 'Details',
                render: function(data, type, row){
                    return `
                        <button class="btn btn-sm btn-primary update-btn" data-id="${data}">
                            OPEN
                        </button> 
                    `; 
                    
                }, 
                className: 'd-grid',
                width: '5%',
            }

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
            [10, 20, 50, 100, 200, -1],
            [10, 20, 50, 100, 200, 'Show All']
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
            topStart: {
                buttons: [
                    {
                        text: "< 30 Days or Late",
                        className: 'btn-outline-danger filter-btn active',
                        action: function () {
                            // get new date based on filter button
                            table.ajax.url('<?= base_url('purchasing/bookings/data/-30')?>').load();
                            
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
                            table.ajax.url('<?= base_url('purchasing/bookings/data/30-75')?>').load();
                            
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
                            table.ajax.url('<?= base_url('purchasing/bookings/data/75-120')?>').load();
                            
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
                            table.ajax.url('<?= base_url('purchasing/bookings/data/120+')?>').load();
                            
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
                            table.ajax.url('<?= base_url('purchasing/bookings/data/all')?>').load();
                            
                            // Update active button
                            $('.filter-btn').removeClass('active');
                            $(this[0].node).addClass('active');
                        }
                    }
                ]
            }
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

    // Row selection behavior
    table.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            const rowNode = table.row(indexes[0]).node();
            const vendor = $(rowNode).data('vendor');
            const purchase_order = $(rowNode).data('purchase_order');
            const promise_date = $(rowNode).data('promise_date');

            const id = 'poLoadingModal';
            const loadingModal = showLoadingModal(id, 'Loading Purchase Order', `Please wait while the Purchase Order: ${purchase_order}`);
            const poModal = document.getElementById(id);

            poModal.addEventListener('shown.bs.modal', function onShown() {
                setTimeout(() => {}, 1000);
                poModal.removeEventListener('shown.bs.modal', onShown);

                const url = '<?= base_url('purchasing/po-booking-review/') ?>' + vendor + '/' + purchase_order + '/' + promise_date;
                $.get(url, function (response) {
                    loadingModal.hide();
                    const modal = $('#content_modal');
                    modal.find('.modal-content').html(response);
                    modal.modal('show');
                });
            });
        }
    });

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