<script>
    $(document).ready(function(){
        $.extend(true, $.fn.dataTable.Buttons.defaults, {
            dom: {
                button: {
                    className: 'btn btn-primary' // new default
                }
            }
        });

        const table = new DataTable('.table',{
            scrollX: '100%',
            scrollCollapse: true,
            pageLength: 100, 
            autoWidth: false,
            pageMenu: [ 50, 100, 200, 250, { label: 'All', value : -1} ],
            ajax: {
                url : `<?= base_url('sales/ede/report/data') ?>`,
                dataSrc : 'data', 
            },
            columns: [
                {
                    data: 'order_clin',
                    title: 'ORDER CLIN', 
                    visible: false,
                },
                {
                    data: 'order_no_mod', 
                    title: 'ORDER NUMBER & MOD', 
                },
                {
                    data: 'requisition_no', 
                    title: 'REQUISITION NR', 
                    visible: false,
                },
                {
                    data: 'nsn_no', 
                    title : 'NSN', 
                    visible: false, 
                },
                {
                    data : 'order_qty', 
                    title: 'QTY', 
                },
                {
                    data: 'unit_price', 
                    title: 'UNIT $', 
                    render:  $.fn.dataTable.render.number( ',', '.', 2 )
                },
                {
                    data: 'order_date', 
                    title: 'ORDER_DATE', 
                },
                {
                    data: 'due_date', 
                    title: 'DUE DATE', 
                },
                {
                    data: 'recovery_date', 
                    title: 'RECOVERY DATE', 
                },
                {
                    data: 'ship_date', 
                    title : 'SHIP DATE', 
                }, 
                {
                    data: 'deliver_loc', 
                    title: 'DELIVERY LOC.', 
                    visible: false, 
                },
                {
                    data: 'tracking_no', 
                    title: 'TRACKING NUMBER', 
                    visible : false, 
                },
                {
                    data: 'comments', 
                    title : 'COMMENTS', 
                    visible: false,

                },
                {
                    data: 'noun', 
                    title: 'NOUN', 
                    visible: false,
                },
                {
                    data: 'part_no', 
                    title: 'P/N', 
                },
                {
                    data: 'vendor_name', 
                    title : 'VENDOR NAME', 
                },
                {
                    data: 'vendor_cage_code', 
                    title: 'CAGE', 
                    visible: false,
                },
                {
                    data: 'vendor_bus_size', 
                    title: 'SIZE', 
                    visible: false, 
                },
                {
                    data: 'qty_shipped', 
                    title : 'QTY SHIP', 
                },
                {
                    data: 'config_control_data', 
                    title : 'CONFIGURATION CONTROL DATA',
                    visible: false, 
                },
                {
                    data: 'quality_control_data', 
                    title: 'QUALITY CONTROL DATA',
                    visible: false, 
                },
                {
                    data: 'risk_assessment_complete',
                    title: 'RISK ASSESSMENT COMPLETED',
                    visible: false, 
                },
                {
                    data: 'on_time_delivery', 
                    title: 'ON TIME DELIVERY',
                    visible: false, 
                },
                {
                    data: 'mitig_strat_a', 
                    title: 'MITIG. STRAT.',
                    visible: false,
                },
                {
                    data: 'risk_rating_after_mit_a', 
                    title: 'RISK RATING AFTER MIT.',
                    visible: false,
                },
                {
                    data: 'finacial_impact', 
                    title: 'FINACIAL IMPACT',
                    visible: false, 
                },
                {
                    data: 'mitig_strat_b', 
                    title: 'MITIG. STRAT.',
                    visible: false,
                },
                {
                    data: 'risk_rating_after_mit_b', 
                    title: 'RISK RATING AFTER MIT.',
                    visible: false,
                },
                {
                    data: 'labor_capacity', 
                    title: 'LABOR CAPACITY',
                    visible: false, 
                },
                {
                    data: 'mitig_strat_c', 
                    title: 'MITIG. STRAT.',
                    visible: false,
                },
                {
                    data: 'risk_rating_after_mit_c', 
                    title: 'RISK RATING AFTER MIT.',
                    visible: false,
                },
                {
                    data: 'facility_capacity', 
                    title : 'FACILITY CAPACITY',
                    visible: false, 
                },
                {
                    data: 'mitig_strat_d', 
                    title: 'MITIG. STRAT.',
                    visible: false,
                },
                {
                    data: 'risk_rating_after_mit_d', 
                    title: 'RISK RATING AFTER MIT.',
                    visible: false,
                },
                {
                    data: 'supplier', 
                    title: 'SUPPLIER',
                    visible: false, 
                },
                {
                    data: 'mitig_strat_e', 
                    title: 'MITIG. STRAT.',
                    visible: false,
                },
                {
                    data: 'risk_rating_after_mit_e', 
                    title: 'RISK RATING AFTER MIT.',
                    visible: false,
                },
                {
                    data: 'product_liability', 
                    title: 'PRODUCT LIABILITY',
                    visible: false, 
                },
                {
                    data: 'mitig_strat_f', 
                    title: 'MITIG. STRAT.',
                    visible: false,
                },
                {
                    data: 'risk_rating_after_mit_f', 
                    title: 'RISK RATING AFTER MIT.',
                    visible: false,
                },
            ],
            columnDefs:[
                { width: '100px', targets: [4,]},
                { width: '150px', targets: [18]},
                { width: '175px', targets: [0, 3, 5, 6, 7, 8, 9, 25, 28, 34,] },
                { width: '250px', targets: [1, 2, 20, 22, 24, 26, 27, 30, 31, 33, 36, 37, 39]},
                { width: '300px', targets: [10, 19, 14, 21, 32]},
                { width: '450px', targets: [12, 13, 15, 35]},
                { width: '500px', targets: [29]},
                { width: '650px', targets: [11, 23, 38]},
            ],
            layout: {
                topStart:{
                    buttons:[
                        'pageLength', 
                        'colvis',
                        {
                            text: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`, 
                            action: function (e, dt, node, config )
                            {
                                window.open('<?= base_url('sales/ede/report/spreadsheet')?>', '_blank'); 
                            } 
                        }
                    ]
                }
            },
            language:{
                buttons:{
                    pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                    colvis: `<i class="bi bi-eye-slash"></i>&nbsp;Hide / Show Columns`
                }
            },
        }); 
// Set font to Arial and size to 12
    var styles = xlsx.xl['styles.xml'];
    
    // Add Arial font and size 12 to the font list
    var fontCount = $('fonts', styles).attr('count');
    var newFontCount = parseInt(fontCount) + 1;
    $('fonts', styles).attr('count', newFontCount);
    
    $('fonts', styles).append(
        '<font>' +
        '<sz val="12"/>' +
        '<name val="Arial"/>' +
        '</font>'
    );
    
    // Update cell styles to use the new font
    var cellXfsCount = $('cellXfs', styles).attr('count');
    var newCellXfsCount = parseInt(cellXfsCount) + 1;
    $('cellXfs', styles).attr('count', newCellXfsCount);
    
    $('cellXfs', styles).append(
        '<xf numFmtId="0" fontId="' + fontCount + '" fillId="0" borderId="0" xfId="0" applyFont="1"/>'
    );
    
    // Apply the new style to all cells
    $('row c', sheet).attr('s', cellXfsCount);

    })
</script>