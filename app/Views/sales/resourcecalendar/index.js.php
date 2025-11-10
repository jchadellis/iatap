

<?= view('sales/resourcecalendar/core/ResourceCalendarCore.js.php'); ?>
<?= view('sales/resourcecalendar/core/ResourceCalendarListeners.js.php'); ?>
<?= view('sales/resourcecalendar/core/ResourceCalendarGenerators.js.php'); ?>
<?= view('sales/resourcecalendar/core/ResourceCalendarUtilities.js.php'); ?>
<?= view('sales/resourcecalendar/core/ResourceCalendarHandlers.js.php'); ?>
<?= view('sales/resourcecalendar/core/ResourceCalendar.js.php'); ?>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const calendar = new ResourceCalendar('calendar',{
        resources : [
            {id: 1, name : 'Large Conference Room', borderColor:'#6fabffff'},
            {id: 2, name : 'Small Conference Room', borderColor:'#fb597fff'},
            {id: 3, name : 'Video Conference Room', borderColor:'#f5ab45ff'},
        ],
    });    

    flatpickr('.date-picker', {
        defaultDate: calendar.core.getDate(),
        dateFormat: 'D M d, Y',
        onChange: function(selectedDate, dateStr, instance){
            calendar.core.setDate(selectedDate[0])
        }
    }); 

});

</script>