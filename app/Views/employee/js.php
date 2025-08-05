<script>
    $(document).ready(function(){
        function showAlert(message, type = 'warning', target = '#alert.container') {
            const alert = $(`<div class="alert alert-${type} m-0 py-2 px-4 show" role="alert" id="message-alert">${message}</div>`);
            if($('#alert-container').children().length == 0){
                 $(target).append(alert);
            }
           
        }
        $("#daterange").flatpickr({
            mode: 'multiple',
            dateFormat: 'm-d-Y', 
            conjunction: ' / ', 
        });

        $('.datepicker').flatpickr({
            dateFormat: 'm-d-Y',
        }); 

        $('.timepicker').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
        }); 

        //$('.datepicker').mask('00-00-0000'); 
        $('.timepicker').mask('00:00');

        let suppressChange = false; 
        $('input[type="checkbox"]').on('change', function () {
            if(suppressChange) return; 

            const $current = $(this);
            const $target = $($current.data('target')); 
            const $alert = $current.data('alert');
            const $message = $current.data('message');

            if($target){
                $target.toggleClass('d-none');
                $input = $target.find('input');
                $input.focus(); 
            }
            
            if($current.prop('checked')){
                suppressChange = true; 

                $('input[type="checkbox"]').not($current).each(function(){
                    const $cb = $(this);
                    if($cb.prop('checked')){
                        $cb.bootstrapToggle('off'); 
                        $oldTarget = $($cb.data('target'));
                        $oldTarget.toggleClass('d-none'); 
                        $oldInput = $oldTarget.find('input');
                        $("#message-alert").alert('close'); 
                        $oldInput.each(function(){
                            $(this).val(''); 
                        })
                    }
                })
                suppressChange = false; 
            }
            if($alert){
                showAlert($message, 'info', '#message-container'); 
            }
            
        });


    })
</script>