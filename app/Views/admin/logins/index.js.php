<script>
    $(document).ready(function(){
        const showPwdBtns = document.querySelectorAll('.show-pwd'); 

        function handleShowPwd(button)
        {

            row = button.closest('tr');
            id = row.dataset.id; 
            currentHTML = button.innerHTML; 
            
            fetch(`<?= base_url('sadmin/login-manager/decrypt/') ?>${id}`)
                .then(response=>response.json())
                .then(data=>{
                    Swal.fire({
                        title: data.title, 
                        text: data.text, 
                        icon: data.icon, 
                        html: `<div id="copyTarget">${data.text}</div> 
                        <button id="copyBtn" class="swal2-confirm swal2-styled" style="margin-top:10px;">Copy</button>`,
                        showConfirmButton: false, 
                        didOpen:()=>{
                        const btn = document.getElementById('copyBtn');
                            btn.addEventListener('click', () => {
                            const text = document.getElementById('copyTarget').innerText;
                            
                            // Fallback copy method
                            const textarea = document.createElement('textarea');
                            textarea.value = text;
                            document.body.appendChild(textarea);
                            textarea.select();
                            try {
                                document.execCommand('copy');
                                Swal.fire({
                                icon: 'successs',
                                title: 'Copied!',
                                text: 'Text copied to clipboard',
                                timer: 1200,
                                showConfirmButton: false
                                });
                            } catch (err) {
                                Swal.fire('Oops!', 'Unable to copy text', 'error');
                            }
                            document.body.removeChild(textarea);
                            });
                        }

                    }).then((result)=>{
                        
                    })
                })



        }

        showPwdBtns.forEach(button => {
            button.addEventListener('click', ()=>{
                handleShowPwd(button); 
            })
        });

        table = $('.table').DataTable({
            //select:true, 
            layout:{
                topStart:{
                    buttons:[
                        {
                            text: '<i class="bi bi-plus-square"></i> New Login / Password', 
                            action: function(){
                                $('#form_modal').modal('show'); 
                            },
                            className: 'btn-primary text-white'
                        },
                        {
                            extend:'collection', 
                            text: 'User Select', 
                            classname: 'btn-success text-white', 
                            buttons:[
                                <?php foreach($user_btns as $button ) : ?>
                                {
                                    text: '<?= $button['name'] ?>', 
                                    action: function(){
                                        window.location.href = '<?= base_url('sadmin/login-manager/'.$button['id']) ?>';
                                    }
                                },
                                <?php endforeach; ?>
                            ]
                        },
                        {
                            text:'<i class="bi bi-x-circle"></i> Clear',
                            action: function(){
                                window.location.href = '<?= base_url('sadmin/login-manager') ?>'; 
                            },
                            className: 'btn-warning',
                        }

                    ]
                }
            },
            columnDefs:[
                {width:'10%', targets:[2,3]}
            ]
        });

        $('.show-pwd').on('click', function(){

            return;
            btns = $('.show-pwd');

            btns.each(function(){
                $(this).attr('disabled', true); 
            })

            btn = $(this);
            btn.removeClass('btn-warning').addClass('btn-success').text('Showing..'); 

            row = $(this).closest('tr'); 
            id = row.data('id'); 

            pwd_field = $(row).find('.pwd-field'); 
            copy_btn = $(row).find('.copy-pwd'); 

            fetch(`<?= base_url('sadmin/login-manager/decrypt/') ?>${id}`)
                .then(response => response.json())
                .then(data => {
                    pwd_field.text(data.data);
                    copy_btn.attr('disabled', false); 
                    copy_btn.on('click', function(){
                        const passwordText = pwd_field.text();
                        
                        // Create a temporary input field
                        const tempInput = $('<input>');
                        $('body').append(tempInput);
                        tempInput.val(passwordText).select();
                        
                        try {
                            document.execCommand('copy');
                            $(this).text('Copied!');
                            setTimeout(() => $(this).text('Copy'), 1000);
                        } catch (err) {
                            // Show modal with selectable text
                            showPasswordModal(passwordText);
                        } finally {
                            tempInput.remove();
                        }
                    })
                    

                })

            setTimeout(() => {      
                btns.each(function(){
                    $(this).attr('disabled', false); 
                })          
                btn.removeClass('btn-success').addClass('btn-warning').html(`<i class="bi bi-eye"></i> Show`);
                copy_btn.attr('disabled', true);
                pwd_field.text('*********'); 
            }, 5000);
        })

        $('#edit_modal').on('show.bs.modal', function(e){
            btn = $(e.relatedTarget); 
            id = btn.data('id'); 
            url = `<?= base_url('sadmin/login-manager/edit/')?>${id}`;
            body  = $(this).find('.modal-body'); 
            $.get(url, function(response){
                body.html(response.modal); 
            });
        })

        $('.save_btn').on('click', function(e){
            e.preventDefault(); 
            modal = $('#form_modal'); 
            form = $( $(this).parents('form') );
            data = form.serialize(); 
            url = `<?= base_url('sadmin/login-manager/save') ?>`; 
            $.post(url, data, function(response){       
                if(response.success)
                {
                    window.location.href = '<?= base_url('sadmin/login-manager/') ?>'
                }
            })

        })

        $('.form-submit-btn').on('click', function(e){
            e.preventDefault(); 
            modal = $('#edit_modal'); 
            form = $( $(this).parents('form') );
            data = form.serialize(); 
            url = `<?= base_url('sadmin/login-manager/save') ?>`; 
            $.post(url, data, function(response){       
                if(response.success)
                {
                    window.location.href = '<?= base_url('sadmin/login-manager/') ?>'
                }
            })

        })

    })
</script>