<script>
$(document).ready(function() {
    const table = $('.table').DataTable({
        order:[],
        select: true, 
        pageLength: 200,
        layout: {
            topStart: {
                    buttons: [
                        "pageLength",
                        "spacer",
                        {
                            extend: "excel",
                            text: "Export to Excel",
                            title: "PO Bookings <?=date('m-d-Y')?>",
                            filename: "po_booking_<?=date('Ymd')?>",
                            sheetName: "Purchase Order Bookings",
                        }
                    ]
                }
        }
    });

    $('#statusFilter').on('change', function() {
        var selected = $(this).val();
        if (selected) {
            table.column(4).search('^' + selected + '$', true, false).draw();  // exact match
        } else {
            table.column(4).search('').draw(); // show all
        }
    });

    table.on('select', function (e, dt, type, indexes) {
       const spinner = $('#spinnerModal');
       spinner.modal('show');  
        if (type === 'row') {
            const rowNode = table.row(indexes[0]).node();
            const woID = $(rowNode).data('workorder');
            const deptID = $('#deptFilter').val(); 
            $.get('<?= base_url('workorder/') ?>' + woID + '/' + deptID, {}, function (response) {
                spinner.modal('hide'); 
                const modal = $('#wo-modal');
                modal.find('.modal-content').html(response);
                modal.modal('show');
            });
        }
    });

    $('#deptFilter').on('change', (e) => {
        id = $(e.target).val();
        window.location.href = "<?= base_url('workorders/') ?>" + id ;
    })


    $('#wo-modal').on('click','.part-submit-btn', function(e){
        e.preventDefault(); 
        form = $(this).parents('form'); 
        data = form.serialize(); 
        action = form[0].action;
        method = form[0].method; 

        $.ajax({
            url: `${action}`, 
            method : 'POST', 
            data: data, 
            success: function(response){
                console.log(response); 
                showMessageModal(response.message, 'success');
                console.log(response);
            },
            error: function(xhr)
            {
                console.log(xhr); 
            }

        })
    })
});


function showMessageModal(message, type = 'success') {
  const alertHtml = `<div class="alert alert-${type}" role="alert">${message}</div>`;
  $('#modalMessageBody').html(alertHtml);
  const modal = new bootstrap.Modal(document.getElementById('messageModal'));
  modal.show();
}
</script>