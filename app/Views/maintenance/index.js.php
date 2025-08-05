<script>
    $(document).ready(function(){
        //maintenanceData = [12,5,8]; 
        //woodshopData = [ 10,9,8];
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
        const maintenanceData = <?= json_encode($maintenanceData); ?>;
        const woodshopData = <?= json_encode($woodshopData); ?>; 
        const maintenanceTickets = <?= json_encode($maintenanceTickets); ?>;
        const woodshopTickets = <?= json_encode($woodshopTickets); ?>;
        
        const maintenancePerformanceChart = new Chart('maintenancePerformanceChart',{
            type: 'pie',
            data: {
                labels: maintenanceData.labels,
                datasets:[{
                    data: maintenanceData.data,
                    backgroundColor: maintenanceData.backgroundColor,
                }]
            }, 
            options: options
        });

        if( woodshopData.hasData ){
            const woodshopPerformanceChart = new Chart('woodshopPerformanceChart',{
                type: 'pie',
                data: {
                    labels: woodshopData.labels,
                    datasets:[{
                        data: woodshopData.data,
                        backgroundColor: woodshopData.backgroundColor,
                    }]
                }, 
                options: options
            });
        }else {
            // Display no data message
            document.getElementById('woodshopPerformanceChart').style.display = 'none';
            document.querySelector('#woodshopPerformanceChart').parentElement.innerHTML = 
                '<div class="text-center text-muted p-4"><i class="fas fa-chart-pie fa-2x mb-2"></i><br>' + woodshopData.message + '</div>';
        }



        var data = {
            labels: ["May", "June", "July"],
            datasets: [{
                label: "Service Tickets",
                backgroundColor: ["#AADEA7", "#64C2A6", "#2D87BB"],
                //borderColor: "rgba(255,99,132,1)",
                borderWidth: 2,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
                data: [65, 59, 20],
            }]
        };

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

        const maintenanceServiceTicketChart = new Chart('maintenanceServiceTicketChart', {
            type: 'bar',
            options: options,
            data: {
                labels: maintenanceTickets.labels, 
                datasets: [{
                    label: '',
                    data: maintenanceTickets.data, 
                    backgroundColor: maintenanceTickets.backgroundColor, 
                }]
            }
        })

        const woodshopServiceTicketChart = new Chart('woodshopServiceTicketChart', {
            type: 'bar',
            options: options,
            data: {
                labels: woodshopTickets.labels, 
                datasets: [{
                    label: '',
                    data: woodshopTickets.data, 
                    backgroundColor: woodshopTickets.backgroundColor, 
                }]
            }
        })
    });
</script>