<script>
    $(document).ready(function(){
        $('#search-btn').on('click', function(e){
            e.preventDefault(); 
            $po = $('#po_number-input').val(); 

            $.ajax({
                url: '<?= base_url('warehouse/po/getpo/')?>'+$po,
                type: 'GET',
                success:function(response){
                    $('#table-container').html(response); 
                }
            })
        })
    })
</script>