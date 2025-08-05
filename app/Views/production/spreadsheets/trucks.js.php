<script>
    table = $('.table').DataTable({
        select: true,
    })

    table.on('select', function(e, dt, type, indexes){
        if(type === 'row'){
            const rowNode = dt.row(indexes[0]).node();
            id = $(rowNode).data('id'); 
            url = `<?= base_url('production/truck/') ?>${id}`; 
            window.location.href=url;
        }
    })
</script>