<script>
    $(document).ready(function(){
        const table = new DataTable('.table', {
            select : true, 
            ajax: {
                url : `<?= base_url('sales/customers/get'); ?>`,
                dataSrc: 'data', 
            },
            columns: [
                { 
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'addr_1'
                }
            ],
            createdRow: function(row, data, dataIndex)
            {
               $(row).data('id', data.id); 
               //console.log(data.id); 
            }
        })

        table.on('select', function(e, dt, type, indexes){
            if(type === 'row')
            {
               row = $(dt.row(indexes).node()); 
               id = row.data('id'); 
               console.log(id); 
               window.open(`<?= base_url('sales/customer/') ?>${id}`, '__self'); 
            }
        })

    })
</script>