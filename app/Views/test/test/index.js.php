<script>
    $(document).ready(function(){
        const ctx1 = document.getElementById('performance-chart'); 
        const ctx2 = document.getElementById('totals-chart'); 
        //const ctx3 = document.getElementById('vendor-performance-chart'); 
        const charts = {};

        const totals_data = <?= json_encode($totals) ?>;
        const performance = <?= json_encode($performance) ?>;
        
        charts['performance_chart'] = new Chart(ctx1,{
            type: 'pie', 
            responsive: true,
            maintainAspectRatio: false,
            data: {
                labels: performance.labels, 
                datasets: [{
                    data: performance.data, 
                    backgroundColor: ['#acce5b', '#dcfa96'],
                    //label: sales_data.datasetLabel,
                }]
            },
        }); 
        charts['total_chart'] = new Chart(ctx2,{
            type: 'bar', 
            responsive: true,
            responsive: true,
            maintainAspectRatio: false,
            data: {
                datasets: [{

                    data: totals_data, 
                    backgroundColor: ['#acce5b'],
                    label: 'By Month',
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // This hides the entire legend, including all dataset labels.
                    }
                }
            }
        }); 

    })
</script>