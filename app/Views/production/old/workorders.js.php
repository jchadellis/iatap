<script>
$(document).ready(function() {
    const table = $('.table').DataTable({
        order:[],
        select: true, 
        pageLength: 25,
        layout: {
            topStart: [
                {
                    pageLength: {
                        menu: [25, 50, 100, 200, { label: 'All', value: -1 }],
                    }
                },
            ],
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
        if (type === 'row') {
            const rowNode = table.row(indexes[0]).node();
            const woID = $(rowNode).data('workorder');
            const deptID = $('#deptFilter').val(); 
            $.get('<?= base_url('production/workorder/') ?>' + woID + '/' + deptID, {}, function (response) {
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