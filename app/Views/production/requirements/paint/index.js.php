<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary'
                }
            }
        });
        const table = new DataTable('.table', {
            pageLength: 100,
            ajax:{
                url: '<?= base_url('production/requirements/paint/data') ?>',
                dataSrc: 'data', 
            },
            columns:[
                {
                    data: 'base_id', 
                    title: 'WO', 
                    width: '8%',
                    className: 'text-center', 
                },
                {
                    data: 'sub_id', 
                    title: 'Sub ID', 
                    width: '8%',
                    className: 'text-center', 
                },
                {
                    data: 'seq_no', 
                    title: 'Oper. No.',
                    width: '8%',
                    className: 'text-center', 
                },
                {
                    data: 'resource_id', 
                    title: 'Dept.',
                    width: '8%',
                    className: 'text-center', 
                },
                {
                    data: 'part_id', 
                    title: 'Part No.'
                },
                {
                    data: 'description',
                    title: 'Description',  
                },
                {
                    data: 'calc_qty', 
                    title: 'Required',
                },
                {
                    data: 'issued_qty', 
                    title: 'Issued', 
                },
                {
                    data: 'qty_on_hand',
                    title: 'QOH',  
                }
            ],
            layout:{
                topStart:{
                    buttons:[
                        'pageLength', 
                        {
                            extend: 'excel', 
                            text: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`,
                        },
                        {
                            extend: 'collection',
                            text: 'Select Dept.',
                            className:'dept-select',
                            buttons:[
                                {
                                    text: 'All Depts.', 
                                    action: function( e, dt, node, config )
                                    {   
                                        dt.column(3).search('', true, false).draw(); 
                                    }                                    
                                },
                                {
                                    text: 'Paint', 
                                    action: function( e, dt, node, config )
                                    {   
                                        dt.column(3).search('232', true, false).draw(); 
                                    }

                                },
                                {
                                    text: 'Inspection', 
                                    action: function( e, dt, node, config )
                                    {   
                                        dt.column(3).search('240', true, false).draw(); 
                                    }
                                }, 
                                {
                                    text: 'Sand', 
                                    action: function( e, dt, node, config )
                                    {   
                                        dt.column(3).search('230', true, false).draw(); 
                                    }
                                },
                                {
                                    text: 'Sandblast', 
                                    action: function( e, dt, node, config )
                                    {   
                                        dt.column(3).search('102', true, false).draw(); 
                                    }
                                },
                                {
                                    text: 'Service', 
                                    action: function( e, dt, node, config )
                                    {   
                                        dt.column(3).search('SERVICE', true, false).draw(); 
                                    }
                                }
                            ]
                        }
                    ]
                }
            },
            language:{
                buttons:{
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                }
            },
        });
    })
</script>