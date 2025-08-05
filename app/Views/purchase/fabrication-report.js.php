<?= view('components/loading-modal'); ?>
<script>
    $.extend(true, $.fn.dataTable.Buttons.defaults, {
        dom: {
            button: {
                className: 'btn btn-primary' // new default
            }
        }
    });

    $(document).ready(function(){
        $('.table').DataTable({
            ajax: function(data, callback, settings){ 
                const id = 'loadModal';
                const loadingModal = showLoadingModal(id, 'Loading Fabrication Report', `Please wait...`);
                const loadModal = document.getElementById(id);

                $.ajax({
                    url: '<?= base_url('purchasing/fabrication-report/data') ?>',
                    data: data,
                    dataType: 'json', 
                    success: function(response){
                        loadingModal.hide(); 
                        callback(response); 
                    },
                    error: function(xhr, status, error){
                        console.log(status); 

                    }
                })
            },
            columns:[
                {data: "part_id", title: "Part"},
                {data: "wo_base_id", title: "Base ID"},
                {data: "description", title: "Description"},
                {data: "qty_in_demand", title: "QID"},
                {data: "qty_on_order", title: "QOO"},
                {data: "qty_on_hand", title: "QOH"},
                {data: "order", title: "Order"},
                {data: "vendor", title: "Vendor"},
            ],
            processing: false, 
            pageLength: 100,
            select:true,
            columnDefs:[
                {orderable: false, targets : [1,2,3,4,5,6,7]},
                {className: 'text-center', targets : [1,2,3,4,5,6,7]}
            ],
            layout: {
                topStart: {
                    buttons: [
                    "pageLength",
                    "spacer",
                    {
                        extend: "pdf",
                        text: "Print To PDF",
                        title: "Paint Purchase Report <?=date('m-d-Y')?>",
                        filename: "paint_purchase_report_<?=date('Ymd'); ?>",
                        orientation: "landscape",
                        pageSize: "LETTER",
                    },
                    "spacer",
                    {
                        extend: "excel",
                        text: "Export to Excel",
                        title: "Paint Purchase Report <?=date('m-d-Y')?>",
                        filename: "paint_purchase_report_<?=date('Ymd')?>",
                        sheetName: "Purchase Report",
                    },
                    "spacer",
                    {
                        extend:'colvis',
                    }
                    ]
                }
            }
        }); 
    })
</script>