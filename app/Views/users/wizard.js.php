<script src="<?= base_url(ASSETSPATH.'custom/duplicateFormRows.js')?>"></script>

<script>
    $(document).ready(function(){
        //$('.date-picker').datepicker(); 
        $('.phone').mask('000-000-0000');
        $('.date-picker').mask('00/00/0000'); 
        $('form').formRowDuplicator();
    })
</script>