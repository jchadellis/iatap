<script src="<?= base_url(ASSETSPATH.'custom/duplicateFormRows.js')?>"></script>
<script>
    $(document).ready(function(){
        function showAlert(message, type = 'warning', target = '#alert.container') {
            const alert = $(`<div class="alert alert-${type} m-0 py-2 px-4" role="alert">${message} <a href="#" class="alert-link">Save User</a> </div>`);
            if($('#alert-container').children().length == 0){
                 $('#alert-container').append(alert);
            }
        }

        $('form').dirtyForms(); 

        $('form').on('dirty.dirtyforms', function(){
            btn = $(this).find('.form-btn'); 
            btn.prop('disabled', false); 
        })

        $('form').on('clean.dirtyforms', function(){
            btn = $(this).find('.form-btn'); 
            btn.prop('disabled', true); 
        })

        $('.alert-link').click(function(e){
            e.preventDefault(); 
            btn = $(e.currentTarget); 
            modal = $(btn.data('target'));  
            modal.modal('show'); 

            return'';
            window.location.href = "<?= base_url('sadmin/login-manager/') ?>"
        })
        
        $('form').formRowDuplicator();

        $('.gen-pw').on('click', function(){

            $('form').dirtyForms(); 

            function generatePassword() {
                const chars = '!@#$%^&*';
                let fName = '<?= $user->first_name ?>'.toLowerCase();
                let lName = '<?= $user->last_name ?>'.toLowerCase(); 
                let password = '';
                
                for (let i = 0; i < 4; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));               
                }
                return fName.substring(0,3) + lName.substring(0,3) + password;
            }
            
            const newPassword = generatePassword();
            // Assuming you have a password input field nearby
            $(this).closest('form').find('#user[password]').val(newPassword);


            pwField = $('#password'); 
            pwField.val(newPassword).text(newPassword).trigger('input').trigger('change');
        })
    })
</script>