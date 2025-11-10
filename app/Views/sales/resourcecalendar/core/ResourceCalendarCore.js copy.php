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
            this.load();  
        }

        incrementDate( days = 1 ){
            let date = this.parent.currentDate; 
            let plusDays = date.setDate(date.getDate() + days ); 
            this.setDate(plusDays);         
        }

        decrementDate( days = 1 ){
            let date = this.parent.currentDate; 
            let minusDays = date.setDate(date.getDate() - days ); 
            this.setDate(minusDays);           
        }

        async saveUpdateEvent(){

            if( !this.parent.currentEvent ) return; 

            const titleInput = document.getElementById('event-title'); 
            const detailsInput = document.getElementById('event-details');
            const form = document.getElementById('event-form'); 
            const seconds = this.parent.utilities.timeToSeconds(this.parent.currentEvent.start); 

            const event = {
                //eventId : eventId,
                title: titleInput.value, 
                details: detailsInput.value, 
                resource: this.parent.currentEvent.resource, 
                start_cell_id: this.parent.currentEvent.start_cell_id, 
                end_cell_id: this.parent.currentEvent.end_cell_id,
                date: this.parent.currentDate.toDateString(),
                start: this.parent.currentEvent.start, 
                end: this.parent.currentEvent.end, 
            }     


            try{
                const result = await this.parent.handlers.onSubmit(event); 

                if( result.success )
                {
                    console.log(result.data); 

                    const eventEl = document.getElementById(result.data.event_id); 

                    if(eventEl){
                        eventEl.remove(); 
                    }

                    this.addEvent(result.data);
                    this.parent.modal.hide(); 
                    form.reset(); 
                    const events = this.parent.events; 
                    const eventExists = events.some( checkEvent => checkEvent.id === event.id ); 
                    if(eventExists) return; 
                    this.parent.events.push(event); 

                }else{
                    console.error('Server error', response); 
                }
            }catch(error){
                console.error('Submission Failed', error); 
            }
            
        }

        addEvent(event) {

            const str = event.start_cell_id.split('rc-cell-'); 
           
            const eventId = 'event-' + event.resource + '-' + str[1] + '-' + event.id ; 
            const startCell = document.getElementById(event.start_cell_id); 
            const endCell = document.getElementById(event.end_cell_id); 
            if (!startCell) return;

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
            this.parent.listeners.setEventsListeners(); 
            event.cells = event_cells; 
        }

        async deleteEvent(element){
            let eventDiv = element.closest('.event'); 
            this.event_el_id = eventDiv.getAttribute('id'); 
            const event = this.parent.events.find(event => event.event_id === this.event_el_id); 
            const event_id = event.id; 
            console.log(event);

            try {
                const result = await this.parent.handlers.deleteEvent(event_id); 

                if(result.success){

                    eventDiv.remove(); 

                    if (!event) {
                        console.error('Event not found:', this.event_el_id);
                        return;
                    }

                    const cells = event.cells; 

                    // Remove event from events array to prevent memory leaks
                    const eventIndex = this.parent.events.findIndex(event => event.eventId === this.event_el_id);
                    if (eventIndex > -1) {
                        this.parent.events.splice(eventIndex, 1);
                    }

                    setTimeout(() => {
                        this.parent.utilities.removeHasEventClass(cells);
                    }, 500);

                }
            }catch(error){
                console.error('Deleting Event Failed', error); 
                return; 
            }

        }

        editEvent(button){

            const eventEl = button.closest('.event'); 
            const eventId = eventEl.getAttribute('id'); 
            const event = this.parent.events.find(event =>   event.event_id === eventId    ); 
            const startInput = document.getElementById('start-time');
            const endInput = document.getElementById('end-time'); 
            const titleInput = document.getElementById('event-title'); 
            const detailsInput = document.getElementById('event-details'); 

            startInput.value = event.start; 
            endInput.value = event.end; 
            titleInput.value = event.title; 
            detailsInput.value = event.details;

            this.parent.currentEvent = event; 

            console.log(event); 

            // /console.table(event); 
            this.parent.modal.show();
        }

        async load(){

            try{
                const result = await this.parent.handlers.getEvents(); 
                if(result){
                    const currentEvents = this.parent.events; 

                    if(currentEvents){
                        currentEvents.forEach(event => {
                            const element = document.getElementById(event.event_id); 
                            if(element)
                            {
                                element.remove(); 
                            }
                        })
                    }
                    result.forEach((event)=>{
                        this.addEvent(event); 
                        
                        const events = this.parent.events; 
                        const eventExists = events.some( checkEvent => checkEvent.id === event.id ); 
                        if(eventExists) return; 
                        this.parent.events.push(event); 
                    }) 
                    return result; 
                }
            }catch(error){
                console.error('Getting Events Failed', error); 
                return;
            }

            
        }

        update(){    
        }        
    }
</script>