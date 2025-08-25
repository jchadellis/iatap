<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });
        const table = new DataTable('.table', {
            ajax:{
                url: '<?= base_url('hr/employee/management/data') ?>',
                dataSrc: 'data', 
            },
            order:[ [1, 'asc'] ], 
            columns:[
                {
                    data: 'first_name', 
                    title: 'First', 
                },
                {
                    data: 'last_name', 
                    title: 'Last', 
                },
                {
                    data: 'addr_1', 
                    title: 'Street', 
                },
                {
                    data: 'city', 
                    title: 'City', 
                },
                {
                    data: 'state', 
                    title: 'State', 
                },
                {
                    data: 'zipcode', 
                    title: 'Zip',
                },
                {
                    data: 'group', 
                    title: 'Group', 
                },
                {
                    data: 'phone', 
                    title: 'Primary Phone',
                    visible: false, 
                },
                {
                    data: 'phone_2', 
                    title: 'Secondary Phone', 
                    visible: false,  
                },
                {
                    data: 'personal_email', 
                    title: 'Personal Email', 
                    visible: false,
                },
                {
                    data: 'contact_2', 
                    title: 'Primary Contact',
                    visible: false, 
                },
                {
                    data: 'contact_2_primary', 
                    title: 'Primary',
                    visible: false, 
                },
                {
                    data: 'contact_2_secondary', 
                    title: 'Secondary',
                    visible: false,
                },
                {
                    data: 'contact_2_alternate', 
                    title: 'Alternate',
                    visible: false,
                },
                {
                    data: 'contact_3', 
                    title: 'Secondary Contact',
                    visible: false, 
                },
                {
                    data: 'contact_3_primary', 
                    title: 'Primary',
                    visible: false, 
                },
                {
                    data: 'contact_3_secondary', 
                    title: 'Secondary',
                    visible: false,
                },
                {
                    data: 'contact_3_alternate', 
                    title: 'Alternate',
                    visible: false,
                }
            ],
            select:true,
            createdRow: function(row, data, dataIndex){
                $(row).data('id', data.id);
            },
            lengthMenu: [25, 50, 100, {label: 'All' , value : -1}],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength', 
                        {
                            extend: 'excelHtml5', 
                            title: 'Employee Contact Information', 
                            filename: 'employee_contact_info_<?= date('mdy') ?>',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17]
                            } 
                        }
                    ]
                }
            },
            language:{
                buttons:{
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                    excel: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`
                }
            },
        });
        const modal = new bootstrap.Modal(document.getElementById('employeeModal'), {
            backdrop: true,
            keyboard: true
        });

        $('#employeeModal').on('hidden.bs.modal', function(){
            if(selectedRow) {
                row = table.row(selectedRow);
                row.deselect(); 
                selectedRow = null;
            }
        });

        table.on('select', function(e, dt, type, indexes){
            row = dt.row(indexes[0]).node(); 
            id = $(row).data('id'); 
            selectedRow = $(dt.row(indexes).node()); 
            url = '<?= base_url('hr/employee/management/employee') ?>';
            data = {
                id : $(row).data('id'), 
            }
            
            $.post(url, data, function(response){
                if(response.success)
                {
                    modal.show(); 
                    $('#employeeModal .modal-content').html(response.data); 
                }
            })
        });

        $(document).on('click', '#modal-save-btn', function(e){
            e.preventDefault();
            url = '<?= base_url('hr/employee/management/employee/save') ?>', 
            form = $('#modal-form'); 
            data = form.serialize(); 
            $.post(url, data, function(response){
                if (response.success) {
                    Swal.fire({
                        title: 'Data Saved',
                        text: `${response.message}`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    $('#employeeModal').modal('hide'); 
                    
                    return;
                }else{
                    Swal.fire({
                        title: 'Failed To Save',
                        text: `${response.message}`,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                     $('#employeeModal').modal('hide'); 
                }
            });
        });
    })
</script>