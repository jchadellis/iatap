<script>
    $(document).ready(function(){



        class FormHandler{
            constructor( options = {} ){
                const defaultOptions = {
                    modalId : 'modal', 
                    modalFormId : 'modal-form', 
                    modalContentId : 'modal-content', 
                    modalCollapse: 'demand-type-collapse',
                    selectElement: null, 
                    urls: {
                        save: '<?= $urls['save'] ?>',
                        edit:'<?= $urls['edit'] ?>',
                        new: '<?= $urls['new'] ?>', 
                        close: '<?= $urls['close'] ?>',
                    },
                    
                    buttons: {
                        action_save: 'save-btn',
                        action_close: 'close-btn',
                    }, 
                    formReset: true, 
                    editFormReset: true,
                    table: null, 
                }

                this.options = {...defaultOptions, ...options}; 
                this.modal_element = document.getElementById(this.options.modalId); 
                this.modal_form = document.getElementById(this.options.modalFormId); 
                this.modal_content = document.getElementById(this.options.modalContentId); 
                this.modal = new bootstrap.Modal(this.modal_element); 
                this.collapse_element = null; 
                this.row_index = null;
                this.table = this.options.table; 
                this.init();
            }
            
            init(){
                this.modal_element.addEventListener('shown.bs.modal', () => this.handleFormInit());
                this.modal_element.addEventListener('hidden.bs.modal', () => this.cleanUp());
            }

            newRecord(){
                const url = this.options.urls.new; 

                return fetch(url, { method:'POST'}).then(response => response.json()).then(result => result ); 
            }

            editRecord(id){
                const url = this.options.urls.edit;
                const data = { id : id }
                const json = JSON.stringify(data); 

                return fetch(url, { method:'POST', body: json }).then(response => response.json()).then(result => result ); 
            }

            closeRecord(){
                const data = new FormData(this.modal_form);
                const obj = Object.fromEntries(data); 
                const url = this.options.urls.close;
                const json = JSON.stringify(data); 

                return fetch(url, { method:'POST', body: json }).then(response => response.json()).then(result => result ); 
            }

            async saveRecord(){
                const data = new FormData(this.modal_form);
                const obj = Object.fromEntries(data); 
                const url = this.options.urls.save; 
                const json = JSON.stringify(obj); 

                const result = await fetch(url, { method:'POST', body: json }).then(response => response.json()).then(result => result ); 

                if( result.success ){
                    swal.fire(result).then((response) => {
                        if(response.isConfirmed){
                            this.modal.hide(); 
                            this.updateTable(result.data); 
                        }
                    })
                }else{
                    swal.fire(result);
                }
            }

            async action(type, id = null, row = null){
                
                let result;

                if( row ){
                    this.row_index = row; 
                }
                
                if(type === 'new'){
                    result = await this.newRecord(); 
                }

                if(type === 'edit'){
                    result = await this.editRecord(id); 
                }

                if(type === 'close'){
                    result = await this.closeRecord(id); 
                }

                if(type === 'save'){
                    result = await this.saveRecord();
                    return; 
                }

                if(result){
                    this.modal_content.innerHTML = result.body;
                    this.modal.show();
                }
            }

            handleFormInit(){
                const closeBtn = document.getElementById(this.options.buttons.action_close); 
                const saveBtn = document.getElementById(this.options.buttons.action_save); 
                const optionSelect = document.getElementById(this.options.selectElement);
                this.collapse_element = document.getElementById(this.options.modalCollapse); 
 
                if( closeBtn ){
                    closeBtn.addEventListener('click', () => this.closeRecord());
                }
                if( saveBtn ){
                    saveBtn.addEventListener('click', () => this.saveRecord()); 
                }
                if( optionSelect ){
                    optionSelect.addEventListener('change', () => this.optionAction(optionSelect));
                }

                this.collapse_element.addEventListener('shown.bs.collapse', event => {
                    this.initCheckBoxes();  
                })
                
                this.collapse_element.addEventListener('shown.bs.collapse', event => {
                    this.initCheckBoxes();  
                })

                this.initCheckBoxes(); 

                flatpickr('.datepicker', {
                    dateFormat: 'Y-m-d', 
                })

            }

            initCheckBoxes(){
                const checkboxes = this.modal_content.querySelectorAll('.checkbox'); 
                checkboxes.forEach(checkbox => {
                    $(checkbox).bootstrapToggle('rerender');
                }) 
            }

            clearCollapseFields(){
                const collapse_element = document.getElementById(this.options.modalCollapse); 
                const inputs = collapse_element.querySelectorAll('input, select'); 
                
                inputs.forEach((input) => {
                    if( input.tagName === 'SELECT'){
                        input.value = 0; 
                        input.selectedIndex = 0; 
                    }

                    if( input.getAttribute('type') === 'checkbox' ) 
                    {
                        input.checked = false; 
                    }

                    if( input.getAttribute('type') === 'text'){
                        input.value = '';  
                    }
                })
            }

            optionAction(element) {
                const selected = element.selectedIndex; 
                const collapseEl = document.getElementById(this.options.modalCollapse);


                // Dispose any old instance to prevent stale state
                const existing = bootstrap.Collapse.getInstance(collapseEl);
                if (existing) existing.dispose();

                const collapse = new bootstrap.Collapse(collapseEl, { toggle: false });

                if (selected === 2){
                    
                   collapse.show();
                }else{

                    if( collapseEl.dataset.id && collapseEl.classList.contains('show') ){
                        swal.fire({
                            icon: 'warning', 
                            title: 'Warning', 
                            html: 'This action <span class="fw-bold text-danger">will clear</span> existing demand details. Are you sure?', 
                            showConfirmButton: true, 
                            showCancelButton: true,
                        }).then((result) => {
                            if(result.isConfirmed){
                                this.clearCollapseFields(); 
                                return; 
                            }else{
                                element.value = 2; 
                                element.selectedIndex = 1; 
                            }
                        })
                    }
                    collapse.hide();
                }

                this.initCheckBoxes(); 

            }

            updateTable(data){
                if(this.table){
                    if( this.row_index !== null ) {
                        table.row(this.row_index).data(data).draw(false);    
                        table.rows().deselect(); 
                    }else{
                        table.row.add(data).draw(false)
                        table.order([5, 'desc']).draw(); 
                    }
                }
                this.row_index = null; 
            }

            cleanUp(){
                this.table.rows().deselect(); 
            }

        }    


        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' 
                }
            }
        });

        const table = new DataTable('#table', {
            select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= $urls['data'] ?>', 
                dataSrc: 'data',
            },        
            pageLength: 25,    
            responsive: true,
            order:[[7, 'desc']],
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
                    title: 'ID',
                },
                {
                    data: 'work_order', 
                    title: 'Work Order', 
                },
                {
                    data: 'created_by', 
                    title: 'Requested By', 
                },
                {
                    data: 'qty', 
                    title: 'Qty', 
                },
                {
                    data: 'part_id', 
                    title: 'Part ID', 
                },
                {
                    data: 'demand_type', 
                    title: 'Type', 
                },
                {
                    data: 'demand_id', 
                    title: 'Demand ID', 
                },
                {
                    data: 'created_at', 
                    title: 'Created Date', 
                },
                {
                    data: 'want_date', 
                    title: 'Due Date', 
                },
            ],
            columnDefs:[
                { targets:[0,1,2,3,5,6,7,8], className:'text-center'},
                { targets:[1,2,7,8,5,6], width:'11%'},
                { targets:[3], width:'5%'},
                { targets:[0], width: '8%'},
                { targets:[2,3], orderable: false}
            ],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength', 
                        'excel',
                        {
                            text: '<i class="bi bi-plus-square"></i>&nbsp;New Work Request', 
                            className: 'btn-success',
                            action: function(e, dt, node, config ){
                                formHandler.action('new'); 
                            }
                        }
                    ]
                }
            },
            createdRow: function(row, data, dataIndex){
                row.dataset.id = data.id; 
            }

        });

        const formHandler = new FormHandler({
            selectElement: 'demand-type-select',
            table: table,
        }); 


        table.on('select', function (e, dt, type, indexes){
            const row = dt.row(); 
            const selectedRow = dt.row(indexes[0]).node(); 
            const id = selectedRow.dataset.id; 
            formHandler.action('edit', id, indexes);            
        });

        table.on('deselect', function (e, dt, type, indexes) {

        });

        $('#close-btn').on('click', function(){
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "Closing the request will remove it from the list.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Close",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                if(selectedRow)
                {
                    row = table.row(selectedRow).node(); 
                    url = `<?= $urls['close'] ?>`; 
                    data = { 'id' :  $(row).data('id'), 'request_id' : $(row).data('request_id')}; 
                    $.post(url, data, function(response){
                        if(response.success)
                        {
                            swalWithBootstrapButtons.fire({
                                title: "Close Work Request!",
                                text: "The Work Request has been closed!",
                                icon: "success"
                            });
                            modal.modal('hide'); 
                        }
                    });
                }

            } else if ( result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Closing Work Request has been canceled.",
                    icon: "error"
                });
                modal.modal('hide'); 
            }
            });
        })

        $('.datepicker').flatpickr({
            dateFormat: 'Y-m-d',
        }); 

    })
</script>