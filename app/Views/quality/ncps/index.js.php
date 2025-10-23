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
            title: 'Loading...', 
            text: 'Please wait while data is loading', 
            didOpen: function(){
                Swal.showLoading(); 
            }
        })
        const table = new DataTable('.table', {
            select: true, 
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
                    data: 'finding_id',
                    title: 'ID', 
                },
                {
                    data: 'finding_date', 
                    title: 'Date', 
                },
                {
                    data: 'target_review_date', 
                    title: 'Review By', 
                },
                {
                    data: 'resource', 
                    title: 'Resource', 
                },
                {
                    data: 'name', 
                    title: 'Initiated By', 
                },
                {
                    data: 'vendor', 
                    title: 'Vendor',
                },
                {
                    data: 'part_id', 
                    title: "Part", 
                },
                {
                    data: 'status', 
                    title: 'Status', 
                }

            ],
            columnDefs:[
                {  targets: [0], width: '5%', className: 'text-center' },
                {  targets: [1,2,3,7], width: '8%', className: 'text-center'},
                {  targets: [4], width: '12%', className: 'text-center'},
                {  targets: [5], widthh: '18%', className: 'text-center' },
                {  targets: [0,1,2,3,4,5,6,7], orderable: false}
            ],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength', 
                        {
                            extend: 'excelHtml5', 
                            title: 'Custom Title', 
                            filename: function() {
                                return 'Custom_File_Name_' + new Date().toISOString().slice(0,10);
                            }
                        },
                        {
                            extend: 'pdf', 
                            title: 'Custom Title', 
                            filename: function() {
                                return 'Custom_File_Name_' + new Date().toISOString().slice(0,10);
                            },
                        },
                    ],
                    div:{
                        html: `<?= view('components/date-range') ?>`,
                    }
                }
            },
            createdRow: function(row, data, dataIndex){
                //Change Table Row Attributes 
            },
            initComplete: function(settings, json)
            {
                setTimeout(() => {
                    Swal.close(); 
                    Swal.fire(json);   
                }, 1000);
                handleForm();
            }

        });

        table.on('select', function (e, dt, type, indexes){
        });

        table.on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = table.rows(indexes).data().toArray();
            }
        });

        $('.edit-btn').on('click', function(){
            modal = $('#content-modal'); 
            modal.modal('show'); 
        });

        $('#content-modal').on('hidden.bs.modal', function(){
            if(selectedRow) {
                row = table.row(selectedRow);
                row.deselect(); 
                selectedRow = null;
            }
        });

        function handleForm()
        {   
            const dateForm = document.getElementById('date-range-form'); 
            if( dateForm )
            {
                dateForm.addEventListener('submit', function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: 'Plese wait...',
                        text: 'Fetching new data...', 
                        icon: 'info', 
                        showConfirmButton: false, 
                        allowOutsideClick: true,
                        didOpen: () =>{
                            Swal.showLoading(); 
                        } 
                    })

                    formData = new FormData(dateForm);
                    url = '<?= $urls['data'] ?>'; 

                    fetch(url, {
                        method : 'POST', 
                        body : formData,
                    }).then(response => response.json())
                    .then(data => {
                        if(data.success)
                        {
                            table.clear(); 
                            table.rows.add(data.data).draw(); 
                            
                            setTimeout(() => {
                               Swal.close(); 
                               Swal.fire(data);   
                            }, 1000);
                            
                                                                         
                        }
                    });
                });
            }
        }

        $('.datepicker').flatpickr(); 

    })
</script>