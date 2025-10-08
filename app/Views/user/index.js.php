<script>
    $('#show-pto').on('click', function(){
        id = $(this).data('user'); 
        console.log(id); 
        Swal.fire({
            title: 'Enter Password', 
            input: 'password', 
            showCancelButton: true, 
        }).then((result)=>{
            if(result.isConfirmed)
            {
                url = "<?= base_url('user/get-pto') ?>"; 
                data = { password: result.value, id: id };

                $.post(url, data, function(response){
                    if( response.success )
                    {
                        Swal.fire({
                            title : `Paid Time Off`,
                            html: `<p><span class="fw-bold">Free Days</span>: ${response.data.details.free_days}</p> 
                                   <p><span class="fw-bold">Vacation Days</span>: ${response.data.details.vac_days}</p>`,
                            icon : 'info',
                        });
                    }else{
                        Swal.fire({
                            title: 'Sorry!', 
                            icon: 'warning', 
                            text: response.message,
                        })
                    }
                })
            }
        })
    })

    $(document).ready(function(){
        $('#email_signature').trumbowyg({
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
    })

</script>