<?= view('components/loading-modal'); ?>
<script>
    $(document).ready(function(){

        const table = new DataTable('#table', {
            ajax:{
                url: '<?= base_url('purchasing/safety-stock/data') ?>',
                dataSrc: 'data', 
            },
            processing: false, 
            pageLength: 100,
            select: true,
            columns:[
                {data: "id", title: "Part ID"},
                {data: "description", title: "Part Description"},
                {data: "pref_vendor_id", title: "Vendor"},
                {data: "qty_on_hand", title: "O/H"},
                {data: "qty_on_order", title: "O/O"},
                {data: "qty_in_demand", title: "O/D"},
                {data: "safety_stock_qty", title: "S/S"},
                {data: "qty_sold", title: "SOLD"},
                {data: "last_amount", title: "Last $", render: function(data, type, row){
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(data);
                }},
                {data: "maximum_order_qty", title: "MAX"},
            ],
            columnDefs:[
                {targets:[2,3,4,5,6,7,8,9], orderable: false},
                {targets: [0,2,3,4,5,6,7,9], className: 'text-center'},
                {targets: 8, className: 'text-end'},
                {targets: [3,4,5,6,7,8,9], width: '5%'},
                {targets: [0,2], width: '15%'},
                {targets: [1], width:'30%' },
            ],
            createdRow: function( row, data, dataIndex ){
                $(row).addClass(data.bg_color);
            },
        })
    });


</script>