<script>
    const ctx1 = document.getElementById('sales-chart');
    const sales_data = <?= json_encode( $salesData[0] ) ?>;
    const charts = {};
    const autocolors = window['chartjs-plugin-autocolors'];


    Chart.register(autocolors);


    charts['salesChart'] = new Chart(ctx1, {
        type: 'pie', 
        data: {
            labels: sales_data.labels, 
            datasets: [{
                data: sales_data.data, 
                //backgroundColor: [onTimeColor,lateColor ],
                label: sales_data.datasetLabel,
            }]
        },
        options: {
            onClick: (event, activeElements) => {
               window.location.href = "<?= base_url('sales/performance/') ?>";
            },
            legend: {display : false},
            plugins: {
                autocolors:{
                    mode:'data',
                    offset:1,
                },
                title: {
                    display: true,
                    text: 'Sales Performance Last 90 Days' 
                },
            }
        }
    });
</script>