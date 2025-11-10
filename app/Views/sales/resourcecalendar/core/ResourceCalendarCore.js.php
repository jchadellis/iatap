<script>
    class ResourceCalendarCore{
        constructor(parent){
            this.parent = parent; 
        }

        getDate(){
            return new Date(this.parent.currentDate); 
        }

        setDate(date){
            this.parent.currentDate = new Date(date);
            const dateField = document.getElementById(this.parent.options.dateField); 
            if(dateField){
                dateField.value = this.parent.currentDate.toDateString(); 
            }
            this.loadEvents().then(()=>{
                this.parent.listeners.addCellListeners(); 
            });  
        }

        setToday(){
            const date = new Date(); 
            this.setDate(date);
        }

        incrementDate( days = 1 ){
            const date = this.parent.currentDate; 
            const plusDays = date.setDate(date.getDate() + days ); 
            this.setDate(plusDays);         
        }

        decrementDate( days = 1 ){
            const today = new Date(); 
            const date = this.parent.currentDate;
            
            if( date.setHours(0,0,0,0) <= today.setHours(0,0,0,0) ) return; 
            
            const minusDays = date.setDate( date.getDate() - days ); 
            this.setDate(minusDays);           
        }

        async loadEvents(){

            //Remove any existing event elements
            if( this.parent.events.length > 0 ){
               const events = this.parent.events;
               events.forEach(event => { 
                    const element = document.getElementById(event.event_id); 
                    element.remove(); 
               }) 
            }

            //Reset events array; 
            this.parent.events = [];
            this.parent.utilities.removeHasEventClass(); 

            //Fetch new events; 
            try{
                const result = await this.parent.handlers.getEvents(); 
                if( result.success ) {

                    result.data.forEach(event => {
                        this.parent.events.push( this.drawEvent(event) );
                    })
                }
            }catch(error){
                console.error('Error getting event data', error); 
            }
        }

        drawEvent(event) {

            const str = event.start_cell_id.split('rc-cell-'); 
           
            //Set the event name
            const eventId = 'event-' + event.resource + '-' + str[1] + '-' + event.id ; 

            //Set the start and ending cells. 
            const startCell = document.getElementById(event.start_cell_id); 
            const endCell = document.getElementById(event.end_cell_id); 

            if (!startCell) return;

            //Check if the event is within the current date. 
            let eventDate = new Date(event.date);
            eventDate = new Date(eventDate.getTime() + eventDate.getTimezoneOffset() * 60000);

            let currentDate = new Date(this.parent.currentDate);
            currentDate.setHours(0,0,0,0);
            eventDate.setHours(0,0,0,0);

            if (currentDate.getTime() !== eventDate.getTime()) return;


            // Create event element
            const eventDiv = document.createElement('div');
            eventDiv.classList.add('event');
            eventDiv.setAttribute('id', eventId);
            event.event_id = eventId; 

            let eventHTML = this.parent.generator.event(event); 

            eventDiv.innerHTML = eventHTML; 

            this.parent.utilities.removeCellClass(startCell, 'has-listeners');
            this.parent.utilities.setCellClass(startCell, this.parent.options.hasEventClass); 

            let event_cells = [startCell];
  
            if ( endCell !== startCell) {

                // Multi-cell event - calculate height based on number of cells
                const startCellRect = startCell.getBoundingClientRect();
                const endCellRect = endCell.getBoundingClientRect();
                const height = endCellRect.bottom - startCellRect.top - 6; // 4px for margins
                
                eventDiv.style.height = `${height}px`;
                startCell.style.position = 'relative';
                startCell.appendChild(eventDiv);

                let current = startCell.nextSibling; 
                event_cells.push(current); 
                this.parent.utilities.removeCellClass(current, 'has-listeners');
                this.parent.utilities.setCellClass(current, this.parent.options.hasEventClass);
                while( current != endCell ){
                    current = current.nextSibling; 
                    event_cells.push(current); 
                    this.parent.utilities.removeCellClass(current, 'has-listeners');
                    this.parent.utilities.setCellClass(current, this.parent.options.hasEventClass);
                }
                
                if (endCell) {
                    this.parent.utilities.removeCellClass(current, 'has-listeners');
                    this.parent.utilities.setCellClass(endCell, this.parent.options.hasEventClass);
                    event_cells.push(endCell); 
                }

            } else {
                startCell.style.position = 'relative';
                startCell.appendChild(eventDiv);
            }

            event.event_id = eventId; 
            event.cells = event_cells; 
            this.parent.listeners.setEventsListeners(); 
            return event; 
        }

        async deleteEvent(button){
            const event = this.parent.events.find(event => event.event_id === button.dataset.parent ); 

            const result = await swal.fire({
                title: 'Warning!', 
                text: 'Are you sure you want to delete this event?', 
                icon: 'warning', 
                showCancelButton: true, 
            });

            if(result.isConfirmed){
                try{
                    const response = await this.parent.handlers.deleteEvent(event.id);
                    
                    this.loadEvents().then(()=>{
                        this.parent.listeners.addCellListeners(); 
                    });
                }catch(error){
                    console.error('Error deleting event', error); 
                }
            }
        }

        editEvent(button){
            const parent = button.closest('.event');
 
            if(parent){
                const event = this.parent.events.find( event => event.event_id === parent.id ); 

                if( event ) {
                    this.parent.handlers.showEditModal(event); 
                }
            }
        }

        async saveUpdateEvent(){
            const event = this.parent.currentEvent; 

            if(!event) return; 

            const titleInput = document.getElementById('event-title'); 
            const detailsInput = document.getElementById('event-details');

            event.title = titleInput.value; 
            event.details = detailsInput.value; 
            event.date = event.date ? event.date : this.parent.currentDate.toDateString(); 

            try{
                const result = await this.parent.handlers.onSubmit(event);

                if(result.success){
                    swal.fire({
                        title: 'Event Saved', 
                        text: 'The event was successfully updated', 
                        icon: 'success', 
                    }).then(()=>{
                         this.parent.modal.hide(); 
                         this.loadEvents().then(()=>{
                            this.parent.listeners.addCellListeners(); 
                         }); 
                    });
                }
            }catch(error){
                console.error('Error saving event', error); 
            }

        }
      
    }
</script>