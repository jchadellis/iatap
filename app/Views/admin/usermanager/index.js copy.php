<script>
    $(document).ready(function(){
        let table; 
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });

        table = new DataTable('.table', {
            select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= base_url('sadmin/user-manager/data') ?>', 
                dataSrc: 'data',
            },        
            pageLength: 25,    
            responsive: true,
            order:[[0, 'asc'],[1, 'asc']],
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
                    data: 'row_order', 
                    title: 'Row Order', 
                    visible: false, 
                },
                {
                    data: null, 
                    title: 'Name',
                    render:function(data, type, row)
                    {
                        return `${data.first_name} ${data.last_name}`;
                    }
                },
                {
                    data: 'last_name', 
                    title: 'Last Name', 
                    visible: false, 
                },
                {
                    data: 'username',
                    title: 'Username', 
                },
                {
                    data: 'email', 
                    title: 'Email Address', 
                }
            ],
            columnDefs:[
                {
                    targets:[0],
                    className: 'dt-center', 
                    orderable: true, 
                    render: function(data, type, row){
                        return data || '-';
                    }
                }
            ],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength', 
                        {
                            text: '<i class="bi bi-plus-square"></i>&nbsp;Add User', 
                            action: function(e, dt, node, config ){
                                modal = $('#new-user-modal'); 
                                modal.modal('show');
                                url = `<?= base_url('sadmin/user-manager/new') ?>`; 
                                $.post(url, '', function(response){

                                    if(response.success){

                                        modal.find('.modal-content').html(response.data); 

                                        saveBtn = $('.save-btn'); 

                                        form = modal.find('form'); 

                                        form.dirtyForms(); 

                                        form.on('dirty.dirtyforms', function(){
                                            saveBtn.prop('disabled', false); 
                                        })

                                        form.on('clean.dirtyforms', function(){
                                            saveBtn.prop('disabled', true); 
                                        })
                                        
                                        saveBtn.on('click', function(e){
                                            e.preventDefault(); 
                                            url = "<?= base_url('sadmin/user-manager/add') ?>"; 
                                            data = form.serialize();
                                            $.post(url, data, function(response){
                                                if(response.success){
                                                    form.dirtyForms('setClean'); 

                                                    modal.modal('hide'); 
                                                    
                                                    currentData = Array.from(table.data()); 

                                                    Swal.fire({
                                                            title: response.title,
                                                            text: response.message,
                                                            icon: 'success',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Email Password',
                                                            cancelButtonText: 'Close'
                                                        }).then((result)=>{
                                                            const user = response.user; 
                                                            if(result.isConfirmed)
                                                            {
                                                                url = `<?= base_url('sadmin/user-manager/email') ?>`; 
                                                                data = { id: response.id, password: response.password}; 
                                                                $.post(url, data, function(response){
                                                                    if(response.success)
                                                                    {
                                                                        Swal.fire({
                                                                            title: response.title, 
                                                                            message: response.message, 
                                                                            icon: 'success', 
                                                                        })
                                                                    }else{
                                                                        Swal.fire({
                                                                            title: response.title, 
                                                                            message: response.message,
                                                                            icon: 'warning',
                                                                        })
                                                                    }
                                                                })
                                                            } 
                                                            table.row.add(response.user).draw(); 
                                                            $(table.row(':first').node()).addClass('table-success');

                                                        })
                                                    } else{
                                                        Swal.fire({
                                                            title: response.title, 
                                                            text: response.message, 
                                                            icon: 'warning', 
                                                            confirmationText: 'OK', 
                                                        })
                                                    }
                                                form.dirtyForms('setClean'); 
                                                modal.modal('hide'); 
                                            })
                                        });

                                        $('.gen-pw').on('click', function(){

                                            function generatePassword() {
                                                const chars = '!@#$%^&*';
                                                let fName = $("input[name=first_name]").val().toLowerCase();
                                                let lName = $("input[name=last_name]").val().toLowerCase(); 
                                                let password = '';
                                                
                                                for (let i = 0; i < 4; i++) {
                                                    password += chars.charAt(Math.floor(Math.random() * chars.length));               
                                                }
                                                return fName.substring(0,3) + lName.substring(0,3) + password;
                                            }
                                            
                                            const newPassword = generatePassword();
                                            // Assuming you have a password input field nearby
                                            $(this).closest('form').find('#user[password]').val(newPassword);


                                            pwField = $('#password'); 
                                            pwField.val(newPassword).text(newPassword).trigger('input').trigger('change');
                                        });

                                    }
                                })
                            },
                            className: 'btn-success', 
                        }
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                 $(row).data('id', data.id);  
            }

        });

        table.off('select').on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                row = dt.row(indexes[0]).node(); 
                modal = $('#edit-user-modal'); 
                modal.modal('show'); 
                selectedRow = $(dt.row(indexes).node()); 
                data = { 'id' : $(row).data('id') };
                url = `<?= base_url('sadmin/user-manager/edit') ?>`;
                
                $.post(url, data, function(response){
                     if(response.success)
                     {
                        modal.find('.modal-content').html(response.data); 

                        saveBtn = $('.save-btn'); 

                        form = modal.find('form'); 

                        form.dirtyForms(); 

                        form.on('dirty.dirtyforms', function(){
                            saveBtn.prop('disabled', false); 
                        })

                        form.on('clean.dirtyforms', function(){
                            saveBtn.prop('disabled', true); 
                        })

                        saveBtn.on('click', function(e){
                            e.preventDefault(); 
                            url = "<?= base_url('sadmin/user-manager/save') ?>"; 
                            data = form.serialize(); 

                            $.post(url, data, function(response){
                                if(response.success){
                                    form.dirtyForms('setClean'); 
                                    
                                    modal.modal('hide'); 

                                    if(response.email)
                                    {
                                        Swal.fire({
                                            title: response.title,
                                            text: response.message,
                                            icon: 'success',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Email Password',
                                            cancelButtonText: 'Cancel'
                                        }).then((result)=>{
                                            if(result.isConfirmed)
                                            {
                                                url = `<?= base_url('sadmin/user-manager/email') ?>`; 
                                                data = { id: response.id, password: response.password}; 
                                                $.post(url, data, function(response){
                                                    if(response.success)
                                                    {
                                                        Swal.fire({
                                                            title: response.title, 
                                                            message: response.message, 
                                                            icon: 'success', 
                                                        })
                                                    }else{
                                                        Swal.fire({
                                                            title: response.title, 
                                                            message: response.message,
                                                            icon: 'warning',
                                                        })
                                                    }
                                                })
                                            }
                                        })
                                    }else{
                                        Swal.fire({
                                            title: response.title, 
                                            text: response.message, 
                                            icon: 'success', 
                                            confirmationText: 'OK', 
                                        })
                                    }

                                } else{
                                    Swal.fire({
                                        title: response.title, 
                                        text: response.message, 
                                        icon: 'warning', 
                                        confirmationText: 'OK', 
                                    })

                                    form.dirtyForms('setClean'); 
                                        
                                    modal.modal('hide'); 
                                    }
                            })

                        });

                        $('.gen-pw').on('click', function(){

                            function generatePassword() {
                                const chars = '!@#$%^&*';
                                let fName = response.first_name.toLowerCase();
                                let lName = response.last_name.toLowerCase(); 
                                let password = '';
                                
                                for (let i = 0; i < 4; i++) {
                                    password += chars.charAt(Math.floor(Math.random() * chars.length));               
                                }
                                return fName.substring(0,3) + lName.substring(0,3) + password;
                            }
                            
                            const newPassword = generatePassword();
                            // Assuming you have a password input field nearby
                            $(this).closest('form').find('#user[password]').val(newPassword);


                            pwField = $('#password'); 
                            pwField.val(newPassword).text(newPassword).trigger('input').trigger('change');
                            
                        });

                     }else{
                        Swal.fire({
                            title: `${response.title}`,
                            text: `${response.message}`,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                     }
                })
            }
        });

        table.on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = table.rows(indexes).data().toArray();
                //console.log('Deselected rows:', data);
            }
        });

        $('.edit-btn').on('click', function(){
            modal = $('#edit-user-modal'); 
            modal.modal('show'); 
        });

        $('#edit-user-modal').on('hidden.bs.modal', function(){
            if(selectedRow) {
                row = table.row(selectedRow);
                row.deselect(); 
                selectedRow = null;
            }
        });

    })
</script>