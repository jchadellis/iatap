<script>
    $(document).ready(function(){
        const ctx1 = document.getElementById('sales-performance-chart'); 
        const ctx2 = document.getElementById('sales-total-chart'); 
        const charts = {};

        const total_sales_data = <?= json_encode($total_sales) ?>;
        const sales_performance = <?= json_encode($sales_performance) ?>;
        
        charts['sales_performance_chart'] = new Chart(ctx1,{
            type: 'pie', 
            responsive: true,
            maintainAspectRatio: false,
            data: {
                labels: sales_performance.labels, 
                datasets: [{
                    data: sales_performance.data, 
                    backgroundColor: ['#42699b', '#7993b5'],
                    //label: sales_data.datasetLabel,
                }]
            },
        }); 
        charts['sales_total_chart'] = new Chart(ctx2,{
            type: 'bar', 
            responsive: true,
            data: {
                datasets: [{

                    data: total_sales_data, 
                    //backgroundColor: ['#42699b', '#7993b5'],
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