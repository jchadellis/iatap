<script>
    $(document).ready(()=>{
        $('#po_counts_form').on('submit', (e)=>{
            e.preventDefault(); 
            form = $("#po_counts_form"); 
            data = form.serialize(); 
            start = $('#start');
            end = $('#end'); 
            count = $('#count'); 
            $.get('<?= base_url('purchasing/po-counts/')?>', data,  (response)=>{
                count.html(response[0].id); 
                start.html(response[0].start); 
                end.html(response[0].end); 
            }, 'json');
        })

        $('#period').flatpickr({
            dateFormat: 'm-d-Y',
        }); 
    })
</script>