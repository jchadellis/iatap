<script>
    $(document).ready(function(){
        table = new $('.table').DataTable({
            select: true, 
            pageLength: 50,
            ajax: {
                url: '<?= base_url('production/schedule/data/') ?>',
                dataSrc: 'data',
            },
            columns:[
                {
                    data : 'workorder_base_id',
                    title: 'WO ID',    
                    className: 'text-center',   
                   
                },
                {
                    data:  'sequence_no',
                    title: 'SEQ',          
                    className: 'text-center',   
                   
                },
                {
                    data: 'workorder_sub_id',
                    title: 'LEG',
                    className : 'text-center',
                   
                },
                {
                    data : 'dept',
                    title: 'Dept',                 
                    className: 'text-center text-truncate',   
                   
                },
                {
                    data : 'part_id',
                    title: 'Part #',              
                    className: 'text-start',    
                   
                },
                {
                    data:  'description',
                    title: 'Description',          
                    className: 'text-center text-truncate',   
                   
                },
                {
                    data:  'run_hrs',
                    title: 'Run HRS',              
                    className: 'text-center',   
                   
                },
                {
                    data:  'actual_hrs',
                    title: 'Actual HRS',           
                    className: 'text-center',   
                   
                },
                {
                    data:  'could_start',
                    title: 'Could Start', 
                    render: DataTable.render.date(),
                    className: 'text-center',   
                   
                },
                {
                    data:  'start_date',
                    title: 'Must Start',     
                    render: DataTable.render.date(),      
                    className: 'text-center',   
                   
                },
                {
                    data:  'finish_date',
                    title: 'Finish By',   
                    render: DataTable.render.date(),       
                    className: 'text-center',   
                   
                },
            ],
            layout: {
                topStart: {
                    buttons: [
                    {
                        extend: 'collection',
                        text: 'Dept Select',
                        className:'collection-1',
                        buttons: [
                            {
                                text:'Weld',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/weld') ?>').load(); 
                                }
                            },
                            {
                                text:'Waterjet',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/waterjet') ?>').load(); 
                                }
                            },
                            {
                                text:'Assembly',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/assembly') ?>').load(); 
                                }
                            },
                            {
                                text:'Sheetmetal',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/sheetmetal') ?>').load(); 
                                }
                            },      
                            {
                                text:'Machine Shop',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/machine_shop') ?>').load(); 
                                }
                            },
                            {
                                text:'Paint',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/paint') ?>').load(); 
                                }
                            },
                            {
                                text:'Quality',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/quality') ?>').load(); 
                                }
                            },                
                            {
                                text:'All Departments',
                                action: function(e, dt, node, config)
                                {
                                    dt.ajax.url('<?= base_url('production/schedule/data/all') ?>').load(); 
                                }
                            },
                        ]
                    },
                    {
                        extend: 'collection',
                        text: 'Launch Schedule',
                        className:'collection-2',
                        buttons: [
                        {
                            text:'Weld',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/weld') ?>', '_blank'); 
                            }
                        },
                        {
                            text:'Waterjet',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/waterjet') ?>', '_blank'); 
                            }
                        },
                        {
                            text:'Assembly',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/assembly') ?>', '_blank'); 
                            }
                        },
                        {
                            text:'Sheetmetal',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/sheetmetal') ?>', '_blank'); 
                            }
                        },      
                        {
                            text:'Machine Shop',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/machine_shop') ?>', '_blank'); 
                            }
                        },
                        {
                            text:'Paint',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/paint') ?>', '_blank');  
                            }
                        },
                        {
                            text:'Quality',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/quality') ?>', '_blank'); 
                            }
                        },                
                        {
                            text:'All Departments',
                            action: function(e, dt, node, config)
                            {
                                window.open('<?= base_url('production/schedule/shop-view/all') ?>', '_blank'); 
                            }
                        },
                    ],
                },             

                    {
                        extend: "pageLength",
                        className: 'text-white',
                    },                
                    {
                        extend: "pdf",
                        text: "Print To PDF",
                        title: "Production Schedule<?=date('m-d-Y')?>",
                        filename: "Production Schedule <?=date('Ymd'); ?>",
                        orientation: "landscape",
                        pageSize: "LETTER",
                        className: "text-white"
                    },
                    
                    {
                        extend: "excel",
                        text: "Export to Excel",
                        title: "Production Schedule <?=date('m-d-Y')?>",
                        filename: "Production Schedule <?=date('Ymd')?>",
                        sheetName: "Schedule",
                        className: 'text-white'
                    },
                    
                    {
                        extend:'colvis',
                        className: 'text-white',
                    },   
                    
                    
                    ]
                },
                top2Start:{
                    div:{
                        html: `<input type="checkbox" checked data-toggle="toggle" id="highlight-toggle" name="highlight-toggle"> <label for="highlight-toggle">Toggle Highlight</label>`,
                    }
                },
            },
            columnDefs:[
                {
                    orderable:false, targets: [3,4,5,6,7]
                }
            ],
            createdRow: function(row, data, index){
                wo_base_id = data.workorder_base_id; 
                wo_sub_id = data.workorder_sub_id; 
                seq_no = data.sequence_no; 
                $(row).data('url', `${wo_base_id}/${wo_sub_id}/${seq_no}`); 
                if(data.is_first){
                    $(row).addClass('table-success'); 
                }
            },
            drawCallback:function(){
                highlightedRows = $('.table-success'); 
                if( $('#highlight-toggle').is(':checked')){
                    highlightedRows.each(function(){
                        $(this).addClass('table-success'); 
                    })
                }else{
                    highlightedRows.each(function(){
                        $(this).removeClass('table-success'); 
                    })
                }
            }
        })

        const modal = $('#update-row-modal');

        table.on('draw', function(){
            $('.collection-1').removeClass('btn-secondary').addClass('btn-primary');
            $('.collection-2').removeClass('btn-secondary').addClass('btn-warning');
        })

        table.on('select', function(e, dt, type, indexes){
            if( type === 'row' )
            {
                selectedRow = $(dt.row(indexes).node()); 
                modal.modal('show'); 
                return ; 
            }
        })  

        modal.on('show.bs.modal', function(){
            
            if(selectedRow){
                url = `<?= base_url('production/schedule/mark-complete') ?>`; 
                data = selectedRow.data('url').split('/'); 
                postData = {
                    'wo_base_id' : data[0],
                    'wo_sub_id' : data[1],
                    'seq_no' : data[2]
                }

                op_complete_btn = $('#op-complete-btn'); 

                op_complete_btn.off('click').on('click', function(){
                    $.post(url, postData, function(response){
                        console.log(response); 
                        if(response.success){
                            alert(response.message);
                            modal.modal('hide'); 
                            table.row(selectedRow).deselect(); 
                        }else{
                            alert(response.message); 
                        }
                    })
                })
            }
        })

                // Set up modal event handler once
        modal.on('hidden.bs.modal', function(){
            if(selectedRow) {
                row = table.row(selectedRow);
                row.deselect(); 
                selectedRow = null;
            }
        });

        $('#highlight-toggle').bootstrapToggle();

        $('#highlight-toggle').on('change', function(){
            highlightedRows.each(function(){
                $(this).toggleClass('table-success'); 
            })
        })

})
</script>