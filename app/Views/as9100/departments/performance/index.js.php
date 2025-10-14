<script>
$(document).ready(function(){
    const ctx1 = document.getElementById('engineeringChart');
    const engineeringData = <?= json_encode($engineering_data) ?>;
    const resetBtn = document.getElementById('reset-btn'); 

    resetBtn.addEventListener('click', function(){
        window.location.href = "<?= base_url('as9100/engineering-performance') ?>"; 
    });


    new Chart(ctx1, {
        type: 'bar', 
        data: {
            labels: engineeringData.labels, 
            datasets: [{
                data: engineeringData.data, 
                backgroundColor: engineeringData.backgroundColor,
                label: engineeringData.datasetLabel,
            }]
        },
        options: {
            legend: {display : false},
            plugins: {
                title: {
                    display: true,
                    text: 'Engineering Performance' 
                }
            }
        }
    });

    $('.datepicker').flatpickr(); 


})        
</script>