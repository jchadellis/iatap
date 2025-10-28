<script>
document.addEventListener("DOMContentLoaded", (event) => {
    
    const ctx1 = document.getElementById('sales-chart');
    const ctx2 = document.getElementById('engineering-chart');
    const ctx3 = document.getElementById('vendor-chart');
    const ctx4 = document.getElementById('counts-chart'); 
    const shipmentCount = document.getElementById('shipment-count'); 
    const rmaCount = document.getElementById('rma-count'); 
    const ncpCount = document.getElementById('ncp-count'); 
    const auditCount = document.getElementById('audit-count'); 
    const dateRangeFields = document.querySelectorAll('.date-range'); 


    const sales_data = <?= json_encode( $data['charts'][0] ) ?>;
    const engineering_data = <?= json_encode( $data['charts'][1] ) ?>; 
    const vendor_data = <?= json_encode($data['charts'][2]) ?>; 
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
                Object.values(result.data.charts).forEach((data)=>{
                    handleUpdateChart(charts[data.chart], data.data, data.labels);
                })
                shipmentCount.innerHTML  = result.data.counts[0].data[0]; 
                rmaCount.innerHTML = result.data.counts[0].data[1]; 
                ncpCount.innerHTML = result.data.counts[0].data[2]; 
                auditCount.innerHTML = result.data.counts[0].data[3];
                dateRangeFields.forEach((field) =>{
                    field.innerHTML = result.data.date_range; 
                })
            }else{
                Swal.fire(result); 
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

    charts['salesChart'] = new Chart(ctx1, {
        type: 'pie', 
        data: {
            labels: sales_data.labels, 
            datasets: [{
                data: sales_data.data, 
                backgroundColor: ['#42699b', '#7993b5'],
                //label: sales_data.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                title: {
                    display: false,
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
                backgroundColor: ['#471396', '#9c75d5ff'],
                //label: engineering_data.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                title: {
                    display: false,
                    text: 'Engineering Performance' 
                },
            }
        }
    });

    charts['vendorChart'] = new Chart(ctx3, {
        type: 'pie', 
        data: {
            labels: vendor_data.labels, 
            datasets: [{
                data: vendor_data.data, 
                backgroundColor: ['#acce5b', '#dcfa96'],
                //label: vendor_data.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                title: {
                    display: false,
                    text: 'Vendor Performance' 
                },
            }
        }
    });

    $('.datepicker').flatpickr({
        mode: 'range',
        weekNumbers: true,
    }); 

});
</script>