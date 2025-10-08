<script>
    $(document).ready(function(){
        const serviceTicketModallEl = document.getElementById('service-ticket-modal');
        const serviceTicketModal = new bootstrap.Modal(serviceTicketModallEl);
        const newTicketModalEl = document.getElementById('new-ticket-modal');
        const newTicketModal = new bootstrap.Modal(newTicketModalEl); 
        const closeTicketBtn = document.getElementById('close-ticket-btn');
        const updateTicketBtn = document.getElementById('update-ticket-btn'); 
        const newTicketBtn = document.getElementById('new-ticket-btn'); 

        function showAlert(data)
        {
            Swal.fire({
                title: data.title, 
                text: data.message, 
                icon: data.icon, 
            })
        }

        function showWarning(message)
        {
            Swal.fire({
                title: 'Error!', 
                text: message, 
                icon: 'warning', 
            })
        }

        function handleGetTicket(table)
        {
            row = table.row('.selected').node();
            id = $(row).data('id');  
            type = $(row).data('type');
            status = $(row).data('status'); 

            content = $(serviceTicketModallEl).find('.modal-body'); 
            form = $(serviceTicketModallEl).find('form'); 

            if(status === 'Closed')
            {
                showAlert( { title:'Closed', icon: 'info', message: 'Ticket has been closed. Updates are not Possible'}); 
                return;
            }

            url = "<?= $urls['get'] ?>"; 
            data = {'id' : id, 'type' : type};
            handlePost(url, data)
                .then(result => {
                    serviceTicketModal.show();
                    content.html(result.data); 
                })
                .catch(error => {
                    showWarning('There was an error while retrieving the service ticket details');
                });
        }

        function handleUpdateTicket()
        {
            selectedRow = table.row('.selected');  // Get the selected row
            selectedRowIndex = selectedRow.index(); // Get the index of the selected row
            data = $(form).serialize(); 
            url = "<?= $urls['save'] ?>"; 

            handlePost(url, data)
                .then(result => {
                    showAlert({title: result.title, message: result.message, icon: result.icon});
                    serviceTicketModal.hide();
                    selectedRow.data(result.data);
                })
        }

        function handleCloseTicket()
        {
            selectedRow = table.row('.selected'); 
            id = $(selectedRow.node()).data('id'); 
            url = "<?= $urls['close'] ?>"; 
            serviceTicketModal.hide();

            Swal.fire({
                input: "textarea", 
                inputLabel : "Work Performed", 
                inputPlaceholder: "Must enter the worked performed before close this ticket.", 
                showCancelButton: true, 
            }).then((result)=>{
                data = { 'id': id, 'work_performed': result.value}; 
                handlePost(url, data)
                    .then(result => {
                        showAlert({title: result.title, message: result.message, icon: result.icon});
                        selectedRow.data(result.data);
                        table.draw();
                    })
            });
            

        }

        function handleNewTicket()
        {
            form = $('form', '.modal.show'); 
            data = form.serialize(); 
            url = "<?= $urls['new'] ?>"

            currentData = table.rows().data().toArray(); 

            table.clear().rows.add(currentData).draw(); 
      
            handlePost(url, data)
                .then(result => {
                    showAlert({title: result.title, message: result.message, icon: result.icon });
                    currentData.splice(0, 0, result.data); 
                    table.clear().rows.add(currentData).draw(); 
                    newTicketModal.hide();  
                })
        }

        function updateTableRow(){
            
            let rowIndex = table.row(':selected');
            table.row.add(response.data).draw(false);

            // Move the newly added row to the correct position
            let rows = table.rows().nodes();
            let newRowIdx = rows.length - 1; // new row is at the end
            if (newRowIdx !== rowIndex) {
                $(rows[newRowIdx]).insertBefore($(rows[rowIndex]));
            }
            // Remove the selected row
            selectedRow.remove().draw(false);
        }

        function handlePost(url, data)
        {
            return new Promise((resolve, reject) => {
                $.post(url, data, function(response){
                    if(response.success) {
                        resolve(response);
                    } else {
                        Swal.fire({
                            title : response.title, 
                            icon : response.icon, 
                            html : response.message, 
                        })
                        reject(response);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown){
                    reject({success: false, error: errorThrown});
                });
            });
        }

        function getFloatingInput(name, message){
            input = `<div class="mb-3">
                         <input type="text" class="form-control" name="${name}" value=""></input>
                         <label for="${name}">${message}</label>
                    </div>`;
            return input; 
        }

        updateTicketBtn.addEventListener('click', ()=>{
            handleUpdateTicket();
        }); 

        closeTicketBtn.addEventListener('click', (table)=>{
            handleCloseTicket();
        }); 

        newTicketBtn.addEventListener('click', ()=>{
            handleNewTicket(); 
        })

        const table = new DataTable('#table',{
            ajax: {
                url: '<?= $urls['all'] ?>', 
                dataSrc: 'data',
            },
            select: true,
            order: [0, 'desc'],
            columns:[
                {
                    data: 'need_date', 
                    title: 'Need Date',
                    render: function(data, type, row)
                    {
                        return  `${data}&nbsp;<span class="badge ${row.badge_color}">${row.priority}</span>`;
                    }
                },
                {
                    data: 'reference_id', 
                    title: 'Request ID', 
                    render: function(data, type, row)
                    {
                        return data ? data : row.id;
                    }
                },
                {
                    data: 'user', 
                    title: 'Request By', 
                    render: function(data, type, row){
                        return data.first_name + ' ' + data.last_name;
                    }
                },
                {
                    data: 'assigned_to',
                    title: 'Assigned To', 
                    render: function(data, type, row){
                        if( row.assigned_to_user.first_name )
                        {
                            return row.assigned_to_user.first_name + ' ' + row.assigned_to_user.last_name; 
                        }
                        return data; 
                    }
                },

                {
                    data: 'title', 
                    title: 'Ticket Name', 
                },
                {
                    data: 'description', 
                    title: 'Description',
                    visible: true,
                },

                {
                    data: 'status', 
                    title: 'Status',
                }
            ],
            columnDefs:[
                { targets: [1,2,3], orderable: false, },
                { targets: [0, 1, 2, 3, 6], className: 'text-center'},
                { targets: [1,2,3,6], width: '10%'},
                { targets: [0,4], width: '12%'},

                // { targets: [2], className: 'text-truncate'}
            ],
            createdRow: function( row, data, dataIndex ){
                if(row){
                    $(row).attr('data-id', data.id );
                    $(row).attr('data-type', data.type); 
                    $(row).attr('data-status', data.status); 
                    $(row).addClass(data.row_color);
                }
            },
            layout:{
                topStart:{
                    buttons:[
                        'pageLength',
                        {
                            text: '<i class="bi bi-plus-square"></i> New Request  Ticket', 
                            action: function(){
                                newTicketModal.show(); 
                            },
                            className: 'btn-success'
                        }
                    ],
                    div:{
                        html: `
                            <input class="checkbox" type="checkbox" data-toggle="toggle" data-off="Hide Closed" data-on="Show Closed" checked>&nbsp;
                            Priority Levels : 
                            <span class="badge text-bg-info">&nbsp<span class="fw-bold">None</span></span>&nbsp
                            <span class="badge text-bg-secondary">&nbsp<span class="fw-bold">Low</span></span>&nbsp
                            <span class="badge text-bg-primary">&nbsp<span class="fw-bold">Medium</span></span>&nbsp
                            <span class="badge text-bg-warning">&nbsp<span class="fw-bold">High</span></span>&nbsp 
                            
                            `,

                    }
                }
            },
        });

        table.on('select', function(){
            handleGetTicket(table); 
        })

        $('.date-picker').flatpickr({
            dateFormat: 'Y-m-d',
        }); 

        $('.checkbox').bootstrapToggle();

        $('.checkbox').on('change', function(){
            if($(this).is(':checked')) {
                // hide closed tickets
                table.column(6).search('^(?!Closed$).*$', true, false).draw();
                
            } else {
                // Show closed tickets
                table.column(6).search('').draw();
            }
        });

        table.on('init', function(){
            table.column(6).search('^(?!Closed$).*$', true, false).draw();
        })

        var vatap = '<?= $urls['previous'] ?? '' ?>'

        if(vatap == 'http://vatap/')
        {
            Swal.fire({
                icon: 'info',
                title: 'Welcome',
                html: `
                    <p>It looks like you came from <b>vatap</b>.</p>
                    <p>This is our new service and request ticket entry system. Everything has been moved here for a smoother experience.</p>
                `,
                confirmButtonText: 'Continue',
                confirmButtonColor: '#3085d6'
            });
        }
    })
</script>

