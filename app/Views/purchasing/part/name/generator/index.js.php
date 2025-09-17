<script>
    $(document).ready(function(){

        function generateDigits() {
            const min = 10000;
            const max = 99999;
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function selectText(input) {

            if($(input).val() === '') return; 
            label = $(input).siblings('label'); 
            text  = label.text();
            label.text( text + '  * Successfully Copied *'); 
            input.select();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(input.value);
            } else {
                document.execCommand('copy');
            }

            setTimeout(() => {
                label.text(text);
            }, 3000);
        }





        $('#description, #part-id').on('focus', function(){
            selectText(this);
        })

        function getPartNumber()
        {
            inputs = $(collapse).find('.dim');

            form = $('#material-form option:selected').val();
            material = $('#material-type option:selected').val(); 
            property = $('#material-property option:selected').val(); 
            property_value = $('#material-property-value').val(); 
            standard = $('#standard').val(); 
            standard_value = $('#standard-number').val(); 
            um = $('#unit-measurement').val(); 

            serial = generateDigits();
            part = `${material}-${form}-${serial}`;

            count = inputs.length;

            if( count === 2)
            {
                str = ''; 
                dims = []
                for(i = 1; i <= count; i++)
                {
                    field = $(`#field-${i}`, collapse).val(); 
                    if( i === 1)
                    {
                        str += `${field} DIA`; 
                    }else{
                        if( field != '')
                        {
                            dims.push( ` ${field}`); 
                        }
                    }
                }
            }


            if( count === 3)
            {   
                str = ''; 
                
                dims = []; 
                for(i = 1; i <= count; i++)
                {
                    field = $(`#field-${i}`, collapse).val(); 
                    if( i === 1)
                    {
                        str += `${field} `; 
                    }else{
                        if( field != '')
                        {
                            dims.push( `${field}`); 
                        }
                    }
                }
            }


            if( count === 4)
            {   
                str = ''; 
                
                dims = []; 
                for(i = 1; i <= count; i++)
                {
                    field = $(`#field-${i}`, collapse).val(); 
                    if( i === 1)
                    {
                        str += `${field} `; 
                    }else{
                        if( field != '')
                        {
                            dims.push( `${field}`); 
                        }
                    }
                }
            }

            if( count === 5 && form === 'CHN')
            {   
                str = ''; 
                
                dims = []; 
                for(i = 1; i <= count; i++)
                {
                    field = $(`#field-${i}`, collapse).val(); 
                    if( i === 1)
                    {
                        str += `${field}`; 
                    }else if( i === 2 ){
                        if( field != '')
                        {
                            str += ` ${field}-ISW `;
                        }
                    }else{
                        if( field != '')
                        {
                            dims.push( `${field}`); 
                        }
                    }
                }
            }

            if( count === 5 && form === 'BEM')
            {   
                str = ''; 
                
                dims = []; 
                for(i = 1; i <= count; i++)
                {
                    field = $(`#field-${i}`, collapse).val(); 
                    if( i === 1)
                    {
                        str += `${field}-FLG`; 
                    }else if( i === 2 ){
                        if( field != '')
                        {
                            str += ` ${field}-WEB `;
                        }
                    }else{
                        if( field != '')
                        {
                            dims.push( `${field}`); 
                        }
                    }
                }
            }



            dim_length = dims.length;

            if( dim_length > 0 )
            {
                str += dims.join('X');
            }

            description = `${str} ${material}-${form}`;

            if(property != undefined && property_value != undefined)
            {
                description += ` ${property} ${property_value}`;
            }

            if( standard != undefined  && standard_value != undefined )
            {
                description += ` ${standard} ${standard_value}`
            }

            $('#part-id').val( part ); 
            $('#description').val(description.toUpperCase().trim()); 
            $('#unit').val(um);

        }





        container = new bootstrap.Collapse('#sheet'); 
        collapse = '#sheet'; 

        $('#material-form').on('change', function(){
            option = $(this).find(':selected'); 
            img = option.data('img'); 
            img_holder = $('.figure-img'); 
            src = img_holder.attr('src', img);
            collapse = option.data('target'); 
            container = bootstrap.Collapse.getInstance(collapse); 
            if(!container)
            {
                container = new bootstrap.Collapse(collapse);
            }else{
                container.show(); 
            }
        })

        $('input, select').on('change', function(){
            getPartNumber(); 
        })

    })
</script>