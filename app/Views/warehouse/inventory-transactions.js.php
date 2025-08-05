<script>
    $(document).ready(function(){
       var table =  new DataTable('.table', {
            ajax:{
                url: '<?= base_url('warehouse/get-transactions')?>',
                type: 'POST',
                dataSrc: "" ,
                data: function(d){
                    d.json = true; 
                    d.transaction_date = $('#transaction_date').val(); 
                },
            },
            scrollY:'60vh',
            columnDefs:[
                {orderable: false, targets : [1,2,3,4,5,6,7]},
                {className: 'text-center', targets : [0,1,2,3,4,5,6,7]},
                {width: '10%', targets: [0,1,4,5,6,7]},
                {width: '20%', targets: [2]},
                {width: '25%', targets: [3]},
            ],
            columns:[
                {data:'trans_id'},
                {data:'trans_base_id'},
                {data:'part_id'},
                {data:'part_description'},
                {data:'trans_qty'},
                {data:'trans_loc_id'},
                {data:'part_loc_qty'},
                {
                    data:'printed',
                    render: function(data,type,row){
                        if(data){
                            return 'Yes';
                        }
                        return 'No';
                    }
                }
            ],
            order:[[0, 'desc']],
            select:{
                style: 'multi'
            },
            paging:false,
        }); 

        $('.datepicker').flatpickr({
            dateFormat: 'Y-m-d',
        }); 

        table.on('select deselect', function () {
            let selectedIndexes = table.rows({ selected: true }).indexes();

            // If more than 2 rows are selected, keep only the first and last
            if (selectedIndexes.length > 2) {
                let keepIndexes = [selectedIndexes[0], selectedIndexes[selectedIndexes.length - 1]];

                selectedIndexes.each(function (idx) {
                    if (!keepIndexes.includes(idx)) {
                        table.row(idx).deselect();
                    }
                });

                // Return early to wait for the next "deselect" to retrigger the handler
                return;
            }

            var selectedRows = table.rows({ selected: true }).data();
            var count = selectedRows.length;

            if (count >= 2) {
                $('#start_transaction').val(selectedRows[0]['trans_id']).prop('disabled', false);
                $('#end_transaction').val(selectedRows[count - 1]['trans_id']).prop('disabled', false);
                $('#print_btn').prop('disabled', false);
            } else if (count === 1) {
                $('#start_transaction').val(selectedRows[0]['trans_id']).prop('disabled', false);
                $('#end_transaction').val(selectedRows[0]['trans_id']).prop('disabled', false);
                $('#print_btn').prop('disabled', false);
            } else {
                $('#start_transaction').val('').prop('disabled', true);
                $('#end_transaction').val('').prop('disabled', true);
                $('#print_btn').prop('disabled', true);
            }
        });



        $('#transaction_date').on('change',function(){
            table.ajax.reload();
        })
    })


    function getPDF() {
        const formData = $('form').serializeArray();

        const tab = window.open('', 'pdfTab');

        const form = $('<form>', {
            method: 'POST',
            action: 'print-pick-list', 
            target: 'pdfTab'
        });

        $.each(formData, function(i, field) {
            form.append($('<input>', {
                type: 'hidden',
                name: field.name,
                value: field.value
            }));
        });

        form.appendTo('body').submit().remove();
    }
</script>