<script>
    class ResourceCalendar{
        constructor(container, options = {} ){
            const defaultOptions = {
                resources : [
                    { id: 1, name: 'Resource 1', borderColor:'', },
                    { id: 2, name: 'Resource 2', borderColor:'',}, 
                ], 
                startHour : 5, 
                endHour : 17,
                view: 'Day',
                buttons: '',
                dateField : 'display-date', 
                selectedCellClass: 'selected', 
                hasEventClass: 'has-event', 
                formId: 'event-form',
                cellHeight: '3em',
                saveUrl: '<?= base_url('sales/resource-calendar/save') ?>',
                loadUrl: '<?= base_url('sales/resource-calendar/events/') ?>', 
                deleteUrl : '<?= base_url('sales/resource-calendar/delete') ?>', 
            }

            
            this.container = document.getElementById(container.replace('#', '')); 
            this.options = {...defaultOptions, ...options}; 
            this.startTime = 0;
            this.endTime = 0;
            this.events = [];

            this.resources = this.options.resources; 

            let date = new Date(); 
            date.setHours(0,0,0,0);
            this.currentDate = new Date(date); 

            this.modalEl = null; 
            this.modal = null; 
            this.selectedCells = 0; 
            this.currentEvent = null; 

            //document.documentElement.style.setProperty("--num-columns", this.options.resources.length);
            this.core = new ResourceCalendarCore(this); 
            this.listeners = new ResourceCalenderListeners(this);
            this.utilities = new ResourceCalendarUtilities(this); 
            this.handlers = new ResourceCalendarHandlers(this); 
            this.generator = new ResourceCalendarGenerators(this); 

            this.startCalendar();
            this.listeners.init(); 
        }

        startCalendar(){
            if (!this.container) {
                console.error('Calendar container not found');
                return;
            }
            
            // Create the calendar grid
            this.container.className = 'calendar';
            if(this.options.view === 'Day'){
                this.container.innerHTML = this.generator.dayView();
                let row = this.generator.buttons(); 
                this.container.parentNode.insertBefore(row, this.container); 
            }

            let modal = this.generator.modal(); 
            this.listeners.addModalListener(modal); 
            this.core.loadEvents().then(result => {
                this.listeners.addCellListeners(); 
            })     
        }

    }
</script>