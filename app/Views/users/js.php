    <script src="<?= base_url(ASSETSPATH.'custom/duplicateFormRows.js')?>"></script>

    <script>
       $(document).ready(function(){


            $('#datepicker').datepicker({
                language: "es",
                autoclose: true,
                format: "mm/dd/yyyy"
            });

            $(document).on('click', '.show_pwd', function(e){
                e.preventDefault();
                
                target = $(this).closest('.input-group').find('input[data-type="password"'); 

                if($(target).attr('type') == 'text')
                {
                    $(target).attr('type', 'password');
                    return;
                }

                $(target).attr('type', 'text');

                setTimeout(function(){
                    if($(target).attr('type') == 'text')
                    {
                        $(target).attr('type', 'password');
                    }
                },30000)
            })

            $('.phone').mask('000-000-0000');

            $('#datepicker').mask('00/00/0000'); 

            $('#tbl_users').DataTable({
                ordering:false,
                pageLength: 5, 
                lengthMenu:[5,10],
                columnDefs:[
                    {targets: '_all', className: 'text-center'}
                ]
            });

            $('form').formRowDuplicator();

            $('.card-collapse').on('show.bs.collapse',function(event){
                icon = $(this).parents('.card').find('.card-header > button > .arrow-icon'); 
                icon.addClass('rotate');  
                $('.card-collapse').not(this).each(function(){
                    $(this).collapse('hide');
                })
            });

            $('.card-collapse').on('shown.bs.collapse', function(e){
                $($(this).find('input[data-toggle="toggle"]')).bootstrapToggle('rerender')
            });

            $('.card-collapse').on('hide.bs.collapse',function(event){
                icon = $(this).parents('.card').find('.card-header > button > .arrow-icon'); 
                icon.removeClass('rotate');
            });

            $('#new_workstation').on('submit', function(e){
                e.preventDefault();
                $("#new_workstation_modal").modal('hide'); 
                $.ajax({
                    type: 'POST',
                    url : $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response){
                        //console.log(response);
                        $('#machine_details').html(response);
                        
                    }

                })
                
            }) 

            $('#workstation_select').on('change',function(e){
                modal = $('#workstation_select_modal');
                details = $(modal).find('#details'); 
                id = $(this).val(); 
                $.ajax({
                    type: 'POST',
                    url: "" + id,
                    success:function(response){
                       $(details).html(response);
                    }
                })
            });

            $('#workstation_select_btn').on('click', function(e){
                inputs_html = $('#workstation_select_modal').find('div:hidden');
                if(inputs_html.length == 0){
                    alert('Select A Workstation');
                    return;
                }
                $('#machine_details').html(inputs_html.html()); 
                $("#workstation_select_modal").modal('hide'); 
                
            });

            $('.pwd-gen').on('click', function(e){
                target = $(this).data('target');
                inputs = $(this).data('inputs'); 
                if(inputs.length > 0){
                    str = ''; 
                    $(inputs).each(function(){
                        input = $('input[name="'+this+'"]').val();
                        str = str + input.substr(0,3);
                    })
                    str = str.toLowerCase(); 
                }
                $.ajax({
                    url: '<? ?>' + str,
                    success: function(response){
                       $(target).val(response); 
                    }
                })
            });


        })

        function copytext(target) {
            event.preventDefault();

            setTimeout(function() {
                $('#copied_tip').remove();
            }, 800);

            $(target).append("<div class='tip' id='copied_tip'>Copied!</div>");

            var input = document.createElement('input');
                input.setAttribute('value', $(target).val());
                document.body.appendChild(input);
                input.select();

            var result = document.execCommand('copy');
                document.body.removeChild(input)
            return result;
        }

    </script>

    <script>
        $(document).ready(function(){
            (function () {
                'use strict';

                // Select the form
                const forms = document.querySelectorAll('.needs-validation');

                // Attach the event listener to the form, not the button
                Array.from(forms).forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault(); // Stop form submission
                            event.stopPropagation();
                            $('.card-collapse').addClass('show');
                        }
                            form.classList.add('was-validated'); // Trigger Bootstrap styles
                    }, false);
                });
            })();
        })
    </script>