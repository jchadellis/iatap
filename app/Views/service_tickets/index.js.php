<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        const table = new DataTable('#table', {
            //select: true, 
            ajax:{
                url:'<?= $data_url ?>',
                dataSrc: 'data', 
            },
            columns:[
                {data: "id"},
                {data: "user", title: "Requested By"},
                {data: "need_date", title: "Requested Date"},
                {
                    data: "priority", 
                    title: "Priority", 
                    render: function(data, type, row){
                        return data.toUpperCase(); 
                    }
                },
                {data: "description", title: "Ticket Request"},
                {
                    data: "status", 
                    title: "Status",
                    render: function(data, type, row){
                        return `
                            <h5><span class="badge ${row.status_color}">${data}</span></h5>
                        `;
                    }
                },
                {
                    render: function(data, type, row){
                        return `
                            <button 
                                class="btn ${row.btn_color} w-100" 
                                type="button" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal${row.id}"
                                ${row.flag ? 'disabled' : '' } 
                                <?= ($user->inGroup('it')) ? '' : 'disabled' ?>
                            >${row.btn_text} &nbsp;<i class="bi ${ row.btn_icon ?  'bi-pencil-square' : '' }"></i></button>`; 
                    },
                }
            ],
            columnDefs:[
                {targets: 0, visible: false},
                {orderable: false, targets: '_all'},
                {width: '12%', targets:[1,2,3,5,6]},
                {width: '40%', targets:[4]},
                {className: 'text-center', targets:[2,3,5,6]},
                {className: 'align-middle', targets: '_all'}
            ],
            layout:{
                topStart:{
                    buttons:[
                        {
                            text: '<i class="bi bi-plus-square"></i> New Service Ticket', 
                            action: function(){
                                $('#it_modal_form').modal('show'); 
                            },
                            className: 'btn-success'
                        }
                    ]
                }
            },
            createdRow: function( row, data, dataIndex ){
                $(row).attr('data-target', data.id );
            },
            language:{
                emptyTable: 'There are currently no <?= ($type == 'it' ) ? strtoupper($type) : ucfirst($type) ?> tickets',
            }
        }) 

        table.on('select', function(e,dt, type, indexes){
        })

        $('.date-picker').flatpickr({
            dateFormat: 'Y-m-d',
        }); 

        $('.form-submit-btn').on('click', function(e){
            e.preventDefault(); 
            row = $(this).data('row_id'); 

            modal = $(this).parents('.modal'); 

            form = $(this).parents('form'); 
            data = form.serialize(); 

            id = $(this).data('id'); 
            url = `<?= $save_url ?>`;

            $.post(url, data, function(response){
                if(response.success)
                {
                   alert(response.message);
                   if(response.type == 'new')
                   {
                        table.row.add(response.data).draw(false);
                   }else{
                        if(row)
                        {
                            table.row(row).data(response.data).draw(false);
                        }
                   }
                   modal.modal('toggle');  
                } else {
                    alert(response.message); 
                }
            }, 'json');
        });

        $('.complete-btn').on('click', function(e){
            e.preventDefault(); 
            btn = $(this)
            row = btn.data('row_id'); 

            btn.text('Submit'); 
            btn.attr('disabled', true);

            modal = btn.parents('.modal'); 

            form = btn.parents('form'); 
            data = form.serialize(); 

            id = btn.data('id'); 

            input1 = $('#resolution_input'+id);
            input2 = $('#comment_input'+id); 

            input1.attr('disabled', false);
            input1.focus();

            input1.on('blur', function(){
                input2.attr('disabled', false);
                input2.focus(); 
                btn.attr('disabled', false); 
            })

            btn.on('click', function(){

                // ADD ALERT OR CONFIRMATION BE FOR CONTINUING. 
                input1Val = input1.val(); 
                input2Val = input2.val(); 
                
                url =  `<?= $delete_url ?>`;
                console.log(url); 
                data = {'id' : id, 'work_performed' : input1Val, 'comments' : input2Val , 'type' : '<?= $type ?>' };

                $.post(url, data, function(response){
                    if(response.success){
                        alert(response.message); 
                        table.row(row).remove().draw(false); 
                        if(response.inGroup){
                            table.row.add(response.data[0]).draw(false); 
                        }
                        modal.modal('toggle');
                    } 
                })
            })

        })

        $('.exit-btn').on('click', function(e){
            btn = $(this).parent('.modal-footer').children('.complete-btn'); 
            row = $(this).parent('.modal-footer').siblings('.modal-body').children('.row').last();
            textarea = row.find('textarea'); 
            textarea.each(function(){
                $(this).val(''); 
                $(this).attr('disabled', true); 
            })
            icon = `<i class="bi bi-check-square"></i> &nbsp;`; 
            btn.text('Mark Completed').prepend(icon); 
        })

        $('.modal').on('show.bs.modal', function(e){
            row = $(e.relatedTarget).closest('tr'); 
            btn =  $(this).find('.form-submit-btn'); 
            btn2 = $(this).find('.complete-btn'); 
            rowIndex = table.row(row).index(); 
            btn.data( 'row_id', rowIndex );
            btn2.data('row_id', rowIndex); 
        })
    })
</script>