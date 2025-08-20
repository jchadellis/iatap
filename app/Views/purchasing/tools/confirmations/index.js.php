<?= view('components/loading-modal'); ?>

<script>
$(document).ready(()=>{
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' 
                }
            }
        });
        const table = $('.table').DataTable({
            ordering: true,
            autoWidth: false,
            select: true,
            pageLength: 100,
            language:{
                buttons:{
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                }
            },
            layout: {
                topStart: {
                    buttons: [
                        "pageLength",
                        "spacer",
                        {
                            extend: "excel",
                            text: `<i class="bi bi-file-spreadsheet"></i>&nbsp; Export to Excel`,
                            title: "PO Bookings <?=date('m-d-Y')?>",
                            filename: "po_booking_<?=date('Ymd')?>",
                            sheetName: "Purchase Order Bookings",
                        }
                    ]
                },
                top2End: 'search',
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
                { targets: [2,3,4],  orderable: false },
                { targets: 1, type: 'date' } // if you're using DD-MM-YYYY
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
                table.column(3).search('').draw();
            } else{
                table.column(3).search(buyer).draw(); 
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

                let url = '<?= base_url('purchasing/tools/confirmations/review') ?>';
                $.post(url, postData, function (response) {

                    if( response.success ){
                        loadingModal.hide();
                        const modal = $('#email_modal');
                        console.log(modal);
                        modal.find('.modal-content').html(response.html);
                        modal.modal('show');
                        console.log(modal);
                        $('#email-vendor').on('click', function(e){
                            e.preventDefault();
                            data = $('#email-form').serialize(); 

                            let url = "<?= base_url('purchasing/tools/confirmations/send-email') ?>";
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
                                    }).then( (result) => {
                                        if(result.isConfirmed){
                                            input = $(`#${response.field}`);
                                            input.focus(); 
                                        }
                                    });
                                }
                            })
                        })
                    }   
                });
            });
        })

})



</script>