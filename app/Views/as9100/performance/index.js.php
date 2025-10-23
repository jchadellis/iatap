<script>
document.addEventListener("DOMContentLoaded", (event) => {
    
    const ctx1 = document.getElementById('sales-chart');
    const ctx2 = document.getElementById('engineering-chart');
    const ctx3 = document.getElementById('vendor-chart');
    const ctx4 = document.getElementById('counts-chart'); 

    const autocolors = window['chartjs-plugin-autocolors'];

    const sales_data = <?= json_encode( $data[0] ) ?>;
    const engineering_data = <?= json_encode( $data[1] ) ?>; 
    const vendor_data = <?= json_encode($data[0]) ?>; 
    const counts_data = <?= json_encode($data[3][0]) ?>; 
    var start_date = null;
    var end_date = null;

    const dateForm = document.getElementById('date-form'); 
    const charts = {};

    dateForm.addEventListener('submit', function(e){
        e.preventDefault();
        const payload = Object.fromEntries(new FormData(dateForm));
        start_date = payload.start;
        end_date = payload.end;
        Swal.fire({
            'title' : 'Fetching', 
            'text' : 'Please wait... loading new data', 
            'icon' : 'success', 
            didOpen: ()=>{
                Swal.showLoading(); 
            }
        })
        fetch('<?= base_url('as9100/performance-charts/data') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then((result)=>{
            Swal.close();
            if( result.success)
            {
                Object.values(result.data).forEach((data)=>{
                    handleUpdateChart(charts[data.chart], data.data, data.labels);
                })
            }

            return;          
        });
    })

 
    function handleUpdateChart(chart, data, labels)
    {
        chart.data.datasets[0].data = data;
        chart.data.labels = labels;
        chart.update();
    }

    const lateColor = '#ff4c4c';
    const onTimeColor = '#00c853';
    const shipmentColor = '#74b9ff';
    const rmaColor = '#fdcb6e';
    const ncpColor = '#a29bfe';
    const auditColor = '#55efc4'; 
 
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
            legend: {display : false},
            plugins: {
                autocolors:{
                    mode:'data',
                    offset:1,
                },
                title: {
                    display: true,
                    text: 'Sales Performance' 
                },
            }
        }
    });

    charts['engineeringChart'] = new Chart(ctx2, {
        type: 'pie', 
        data: {
            labels: engineering_data.labels, 
            datasets: [{
                data: engineering_data.data, 
                label: engineering_data.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                autocolors:{
                    mode:'data',
                    offset:2,
                },
                title: {
                    display: true,
                    text: 'Engineering Performance' 
                }
            }
        }
    });

    charts['vendorChart'] = new Chart(ctx3, {
        type: 'pie', 
        data: {
            labels: vendor_data.labels, 
            datasets: [{
                data: vendor_data.data, 
                label: vendor_data.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                autocolors:{
                    mode:'data',
                    offset:3,
                },
                title: {
                    display: true,
                    text: 'Vendor Performance' 
                }
            }
        }
    });

    charts['countsChart'] = new Chart(ctx4, {
        type: 'pie', 
        data: {
            labels: counts_data.labels, 
            datasets: [{
                data: counts_data.data, 
                label: counts_data.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                autocolors:{
                    mode:'data',
                    offset:4,
                },
                title: {
                    display: true,
                    text: 'Other' 
                }
            }
        }
    });

    $('.datepicker').flatpickr(); 

});
</script>