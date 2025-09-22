<?= view('components/loading-modal'); ?>

<script>
$(document).ready(()=>{
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });
        const table = $('.table').DataTable({
            ordering: true,
            autoWidth: false,
            select: true,
            pageLength: 100,

            layout: {
                topStart: {
                    buttons: [
                        "pageLength",
                        "spacer",
                        {
                            extend: "excel",
                            text: "Export to Excel",
                            title: "PO Bookings <?=date('m-d-Y')?>",
                            filename: "po_booking_<?=date('Ymd')?>",
                            sheetName: "Purchase Order Bookings",
                        }
                    ]
                }
            },

            columnDefs: [
                { targets: [2,3,4,5,6],  orderable: false },
                { targets: 1, type: 'date-eu' } // if you're using DD-MM-YYYY
            ],

            order: [[1, 'asc']]
        })

        $(document).on('keydown', function (e) {
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault(); // prevent browser find dialog
                
                // Focus DataTables search input
                input =  $('#dt-search-0').focus();
            }
        });

        table.on('select', function (e, dt, type, indexes) {

            if (type === 'row') {
                const rowNode = table.row(indexes[0]).node();
                const vendor = $(rowNode).data('vendor');
                const purchase_order = $(rowNode).data('purchase_order'); 
                const promise_date = $(rowNode).data('promise_date'); 
                id = 'poLoadingModal'; 

                loadingModal = showLoadingModal(id, 'Loading Purchase Order', `Please wait while the Purchase Order :${purchase_order}`); 

                poModal = document.getElementById(id); 

                poModal.addEventListener('shown.bs.modal', function onShown(){
                    setTimeout(() => {
                        
                    }, 1000);
                    poModal.removeEventListener('shown.bs.modal', onShown); 

                    url = '<?= base_url('purchasing/po-confirmation-review/') ?>' + vendor + '/' + purchase_order + '/' + promise_date ; 

                    $.get( url ,  function (response) {
                        loadingModal.hide(); 
                        const modal = $('#content_modal');
                        modal.find('.modal-content').html(response);
                        modal.modal('show');
                    });
                })

               

            }
        });

        $('#email_form').on('submit', function (e) {
            e.preventDefault();
            const form = $(e.target);
            const data = form.serialize();

            const id = 'emailLoadingModal';

            // 1. Create modal
            const bsModal = showLoadingModal(id, 'Sending Email', 'Please wait while we send the email...');
            const modalEl = document.getElementById(id);

            // 2. When modal is shown, fire off the AJAX
            modalEl.addEventListener('shown.bs.modal', function onShown() {
                modalEl.removeEventListener('shown.bs.modal', onShown);

                $.get('<?= base_url('vendor/email-confirmation') ?>', data, function (response) {

                    // 3. When it's time to hide, attach the hidden listener *now* while response is in scope
                    modalEl.addEventListener('hidden.bs.modal', function onHidden() {
                        modalEl.removeEventListener('hidden.bs.modal', onHidden);
                        setTimeout(() => {
                            
                        }, 1000);
                        alert(response.message);

                        if (response.success) {
                            $('#content_modal').modal('hide');
                            modalEl.remove();
                        }
                    });

                    // 4. Now hide
                    bsModal.hide();
                });
            });
        });

    })



</script>