<script>

    function showAlert(message, type = 'success', duration = 5000) {
        const alertId = 'alert-' + Date.now();

        const alert = document.createElement('div');
        alert.id = alertId;
        alert.className = `alert alert-${type} alert-dismissible fade show text-center`;
        alert.role = 'alert';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        document.getElementById('modal-alert-container').appendChild(alert);

        setTimeout(() => {
            const alertElement = bootstrap.Alert.getOrCreateInstance(document.getElementById(alertId));
            alertElement.close();
        }, duration);
    }

    $(document).ready(function(){



        // IP address sorting plug-in
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "ip-address-pre": function ( a ) {
                var m = a.split('.'), x;
                if (m.length == 4) {
                    x = ('000' + m[0]).slice(-3) + 
                        ('000' + m[1]).slice(-3) + 
                        ('000' + m[2]).slice(-3) + 
                        ('000' + m[3]).slice(-3);
                } else {
                    x = '';
                }
                return x;
            },
            "ip-address-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "ip-address-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });


        //$('form').dirtyForms(); 
        dataTable = $('.table').DataTable({
            columnDefs: [
                { className: 'd-grid', targets: 6},
                { orderable: false, targets: [0,1,2,3,5,6] }
            ],
             order: []  // no initial sorting
        }
            
        ); 
    
         $('form').on('submit', function(e){
            e.preventDefault(); 
            var submitButton = document.activeElement;
            $(submitButton).prop('disabled', true); 
            
            modal = $(this).parents('.modal'); 
            formData = $(this).serialize(); 

            $.ajax({
                type: 'POST',
                url: '<?= url_to('sadmin/asset/create')?>',
                data: formData,
                success: function(response){
                    console.log(response);
                    if(response != 'false') {
                        const url = '<?= base_url('sadmin/asset/edit/') ?>';
                        dataTable.row.add([
                            (response.is_active == 't') ? 'Yes' : 'No', 
                            response.display_name,
                            response.network_name,
                            response.type_id,
                            response.ip_address,
                            response.mac,
                            '<a href="'+ url + response.id +  '" class="btn btn-primary">Edit</a>', 
                        ]).draw();

                        document.getElementById('assetForm').reset();
                        $(submitButton).prop('disabled', false); 
                        showAlert('Added Successfully!'); 
                    }
                },
                error: function(error)
                {
                    console.error('Error', error); 
                }


            })
        });

        //$('#mac').mask('AA-AA-AA-AA-AA-AA');


    
    
    })
</script>