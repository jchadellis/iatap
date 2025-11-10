<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });

        Swal.fire({
            title : 'Loading...',
            text : 'Please wait while table is loading', 
            didOpen: function(){
                Swal.showLoading(); 
            },
        })
        const table = new DataTable('.table', {
            select: false, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= $urls['data'] ?>', 
                dataSrc: 'data',
            },        
            pageLength: 25,    
            responsive: true,
            order:[[0, 'desc']],
            language:{
                buttons:{
                    colvis: `<i class="bi bi-eye-slash"></i>&nbsp;Show/Hide Columns`, 
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                    excel: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`,
                    pdf: `<i class="bi bi-file-earmark-pdf"></i>&nbsp;Export to PDF`,
                }
            },
            columns:[
                {
                    data: 'id', 
                    title: 'PART ID', 
                },
                {
                    data: 'qty', 
                    title: 'QTY ISSUED', 
                },
                {
                    data: 'stock_um', 
                    title: 'UNIT of MEASUREMENT', 
                }

            ],
            columnDefs:[

            ],
            layout:{

            },
            createdRow: function(row, data, dataIndex){
                //Change Table Row Attributes 
            },
            initComplete: function(settings, json){
                Swal.close(); 
                if(!json.success)
                {
                    Swal.fire(json); 
                }
            }

        });

        table.on('select', function (e, dt, type, indexes){

        });

        table.on('deselect', function (e, dt, type, indexes) {

        });

        $('.edit-btn').on('click', function(){

        });

        $('#content-modal').on('hidden.bs.modal', function(){

        });



    })
</script>