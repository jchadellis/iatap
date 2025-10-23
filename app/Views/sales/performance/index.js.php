<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });

        const table = new DataTable('#performance-table', {
            select: true, 
            lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
            ajax:{
                url: '<?= $url ?>', 
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
                    title: 'Customer ID',  
                },
                {
                    data: 'name', 
                    title: 'Name', 
                },
                {
                    data: 'total_lines', 
                    title: 'Total Lines', 
                },
                {
                    data: 'total_on_time', 
                    title : 'On Time', 
                },
                {
                    data: 'total_late', 
                    title: 'Total Late', 
                },
                {
                    data: 'on_time_percentage', 
                    title: 'On Time %',
                },
                {
                    data: 'late_percentage', 
                    title: 'Late %'
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
                    div: {
                        html:`
                            <form id="date-range-form">
                                <div class="row">
                                    <div class="col-10"> 
                                        <div class="input-group"> 
                                            <span class="input-group-text" >Start Date</span>
                                            <input type="text" name="start_date" class="form-control form-control-sm  datepicker text-center">
                                            <span class="input-group-text">-</span>
                                            <span class="input-group-text">End Date</span>
                                            <input type="text" name="end_date" class="form-control form-control-sm  datepicker text-center">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div></form>`,
                    }
                }
            },
            createdRow: function(row, data, dataIndex){
                //console.log(data); 
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();



                var totalLines = api
                    .column(2, { page: 'all' })
                    .data()
                    .reduce(function (a, b) {
                        return Number(a) + Number(b);
                    }, 0);

                var totalOnTime = api
                    .column(3, { page: 'all' })
                    .data()
                    .reduce(function (a, b){
                        return Number(a) + Number(b); 
                    }, 0);

                var totalLate = api
                    .column(4, {page :'all'})
                    .data()
                    .reduce(function (a, b){
                        return Number(a) + Number(b);
                    },0);


                var onTimePercent = (totalOnTime / totalLines) * 100; 
                var latePercent = (totalLate / totalLines) * 100; 
                
                $(api.column(2).footer()).html(totalLines);
                $(api.column(3).footer()).html(totalOnTime);
                $(api.column(4).footer()).html(totalLate);
                $(api.column(5).footer()).html(`${onTimePercent.toFixed(2)}%`); 
                $(api.column(6).footer()).html(`${latePercent.toFixed(2)}%`)
            },
            initComplete: function(settings, json)
            {
                Swal.close(); 
                Swal.fire(json);
            }
        });

        table.on('select', function (e, dt, type, indexes){
            if (type === 'row') {
                row = dt.row(indexes[0]).node(); 
                modal = $('#content-modal'); 
                modal.modal('show'); 
                selectedRow = $(dt.row(indexes).node()); 
                //data = { 'id' : $(row).data('id') };
                //url = `base_url()`;
                
                //$.post(url, data, function(response){
                    //do something with data.
                    //  if(response.success)
                    //  {
                    //     Swal.fire({
                    //         title: `${response.title}`,
                    //         text: `${response.message}`,
                    //         icon: 'success',
                    //         confirmButtonText: 'OK'
                    //     });
                    //  }else{
                    //     Swal.fire({
                    //         title: `${response.title}`,
                    //         text: `${response.message}`,
                    //         icon: 'warning',
                    //         confirmButtonText: 'OK'
                    //     });
                    //  }
                //})
            }
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

        Swal.fire({
            title: 'Loading',
            text: 'Please wait while the vendor list is loading...', 
            icon: 'info', 
            didOpen: ()=>{
                Swal.showLoading(); 
            }
        })


        table.on('init', function(){
            const dateForm = document.getElementById('date-range-form'); 
            const getPoBtns = document.querySelector('.open-pos-btn'); 

            $('.datepicker').flatpickr(); 
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
                    url = '<?= base_url('sales/performance/data') ?>'; 

                    fetch(url, {
                        method : 'POST', 
                        body : formData,
                    }).then(response => response.json())
                        .then(data => {
                            if(data.success)
                            {
                                table.clear(); 
                                table.rows.add(data.data).draw(); 
                                //Swal.close();
                                showAlert(data)
                            }
                        });
                });
            }
        })

    })
</script>