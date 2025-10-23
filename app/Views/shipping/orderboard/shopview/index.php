<div class="container-fluid m-2">
    <table class="table table-striped table-bordered fs-1 table-primary" id="table">
        <thead>
            <tr class="sticky">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const table = new DataTable('#table',{
        pageLength: -1,
        ajax:{
            url: '<?= $urls['data'] ?>', 
            dataSrc: 'data',
        },
        fixedHeader: true,
        order:[7,'asc'],
        layout: null,
        columns: [
            {
                data: 'order_id', 
                title: 'ORDER', 
                render: function(data, type, row)
                {
                    return `<span class="fw-bold"> ${data} </span>`; 
                }
            },
            {
                data: 'formatted_date', 
                title: 'SHIP DATE',
            },  
            {
                data: 'line_no', 
                title: 'LINE',
                visible: false,
            },
            {
                data: 'line_part_id', 
                title: "PART/DESCRIPTION", 
                render: function(data, type, row)
                {
                    return `<span class="fw-bold"> ${data} </span> /  ${row.part_description}`; 
                }
            },
            {
                data: 'line_order_qty',
                title: 'ORDER QTY', 
            },
            {
                data: 'qty_on_hand', 
                title: 'ON HAND', 
            },
            {
                data: 'qty_on_order', 
                title: "ON ORDER", 
            },
            {
                data: 'ship_date',
                visible: false,
            }

        ],
        columnDefs:[
            {targets: ['_all'], orderable:false},
            {targets: [0,1,2,4,5,6], className:'text-center'},
            {targets: [0,4,5,6], width: '6%'},
            {targets: [1], width: '7%'},
            {targets: [3], width: '25%'},

        ],
        createdRow: function(row, data)
        {
            $(row).addClass(data.table_row_color);
            $(row).addClass('fs-2')
        }
    }); 


    setInterval(() => {
        table.ajax.reload(null, false); 
    }, 300000);
});
</script>