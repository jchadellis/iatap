<script>
    $(document).ready(function(){
        table = new $('.table').DataTable({
            select:{
                os:true, 
                multi: true,
            },
            ajax: {
                url: '<?= base_url('employee/training/data') ?>',
                dataSrc: 'data',
            },
            columns:[
                {
                    data: 'employee_id',
                    visible: false,
                },
                {
                    data: 'employee_name',
                    title: 'Name',
                },
                {
                    data: 'resource_type', 
                    title: 'Training Type',
                },
                {
                    data: 'resource_name',
                    title: 'Training Description',  
                },
                {
                    data: 'training_date', 
                    title: 'Training Date',
                },
                {
                    data: 'trainer_name',
                    title: 'Trainer',
                    className: 'text-truncate',
                }
            ],
            order:[[4, 'desc']],
            columnDefs:[
                {width:'15%', targets: [0,1,2,4,5], className: 'text-center'},
                {searchable: false, targets: [2,3,4,5]},
                {searchable: true, targets:[0,1]}
            ],
            language: {
                search: 'Filter Employee ID / NAME'
            },
            layout:{
                topStart:{
                    buttons:[
                        'pageLength',
                        'pdf',
                        {
                            text:"<i class=\"bi bi-plus-square\"></i> Add Record",  
                            action: function(){
                                $('#newRecord').modal('show'); 
                            },
                            className: 'add-record-btn', 
                        }
                    ]
                }
            }
        });

        table.on('draw', function(){
            $('.add-record-btn').removeClass('btn-primary').addClass('btn-success'); 
        })

        $('.date-picker').flatpickr(); 
    })
</script>