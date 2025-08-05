<script src="<?= base_url(ASSETSPATH.'custom/duplicateFormRows.js')?>"></script>

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

        document.getElementById('alert-container').appendChild(alert);

        setTimeout(() => {
            const alertElement = bootstrap.Alert.getOrCreateInstance(document.getElementById(alertId));
            alertElement.close();
        }, duration);
    }

    $(document).ready(function(){
        $('.phone').mask('000-000-0000');
        $('form').formRowDuplicator();
        dataTable = $('.table').DataTable({
            orderable:false,
            columnDefs:[
                {className:'d-grid', targets:[4]}
            ]
        }); 

        $('form').on('submit', function(e){
            e.preventDefault(); 
            var submitButton = document.activeElement;
            $(submitButton).prop('disabled', true); 
            
            modal = $(this).parents('.modal'); 
            formData = $(this).serialize(); 
            $.ajax({
                type: 'POST',
                url: '<?= url_to('sadmin/user/create')?>',
                data: formData,
                success: function(response){
                    if(response.success != false ) {
                        console.log(response);
                        dataTable.row.add([
                            response.user.first_name,
                            response.user.last_name,
                            response.user.username,
                            response.user.email,
                            `<a href="#" class="btn btn-success"> New </a>`, 
                        ]).draw();
                        modal.modal('hide');
                        document.getElementById('userForm').reset();
                        $(submitButton).prop('disabled', false); 
                        showAlert('User Added Successfully!'); 
                    }
                },
                error: function(error)
                {
                    console.error('Error', error); 
                }


            })
        });

        const myModalEl = document.getElementById('userModal')
        myModalEl.addEventListener('shown.bs.modal', event => {
            $('.checkbox').bootstrapToggle('rerender');
        })

        $('.checkbox').on('change', function(e){
            container = $(this).data('target'); 
            $(container).collapse('toggle');
        })

        $('.date-picker').flatpickr({
            dateFormat: 'Y-m-d',
        }); 
    })
</script>