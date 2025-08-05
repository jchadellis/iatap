<script>
    $(document).ready(function(){
        var options = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    align: 'center'
                },
            },
            layout:{
                autoPadding: true
            }
        };
        const performanceData = <?= json_encode($performanceData); ?>;
        const ticketData = <?= json_encode($ticketData); ?>;
        

        if( performanceData.hasData ){
            const itPerformanceChart = new Chart('performanceChart',{
                type: 'pie',
                data: {
                    labels: performanceData.labels,
                    datasets:[{
                        data: performanceData.data,
                        backgroundColor: performanceData.backgroundColor,
                    }]
                }, 
                options: options
            });
        }else {
            // Display no data message
            document.getElementById('performanceChart').style.display = 'none';
            document.querySelector('#performanceChart').parentElement.innerHTML = 
                '<div class="text-center text-muted p-4"><i class="fas fa-chart-pie fa-2x mb-2"></i><br>' + performanceData.message + '</div>';
        }

        var options = {
            maintainAspectRatio: false,
            plugins: {
                legend:{
                    display:false,
                }
            },
            scales: {
                y: {
                    stacked: true,
                    grid: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        };

        const woodshopServiceTicketChart = new Chart('serviceTicketChart', {
            type: 'bar',
            options: options,
            data: {
                labels: ticketData.labels, 
                datasets: [{
                    label: '',
                    data: ticketData.data, 
                    backgroundColor: ticketData.backgroundColor, 
                }]
            }
        })
    });
</script>