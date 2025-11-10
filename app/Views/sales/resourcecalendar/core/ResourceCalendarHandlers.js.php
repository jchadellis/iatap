<script>
    class ResourceCalendarHandlers{
        constructor(parent){
            this.parent = parent; 
            this.isDragging = null; 
            this.dragStartResource = null; 
            this.isMouseDown = false; 
            this.dragStartElement = null;
        }

        onCellClick(element){
            if(this.parent.utilities.hasEvent(element)) return; 
            this.parent.utilities.setCellClass(element, this.parent.options.selectedCellClass);

            if (!this.isDragging) {
                const clickedResource = this.parent.resource;
            }
        }

        onMouseDown(element){
            if(this.parent.utilities.hasEvent(element)) return; 
            this.isMouseDown = true;
            this.selectedCells = 1; 
            this.dragStartResource = element.dataset.resource; 
            this.dragStartElement = element; 
            this.parent.utilities.setCellClass(element, this.parent.options.selectedCellClass);
        }

        onMouseEnter(element) {
            if(this.parent.utilities.hasEvent(element)) return; 
            if (this.isMouseDown && !this.isDragging) {
                this.isDragging = true;
                this.parent.utilities.setCellClass(element, this.parent.options.selectedCellClass);
            }
            
            if (this.isDragging && element.dataset.resource === this.dragStartResource) {
                this.selectedCells++; 
                this.parent.utilities.setCellClass(element, this.parent.options.selectedCellClass);
            }
        }

        onMouseUp(element){
            this.isDragging = false;
            this.isMouseDown = false;
            if(this.parent.utilities.hasEvent(element)) return; 
            this.showNewModal(element); 
        }

        showNewModal(){
            
            const startInput = document.getElementById('start-time');
            const endInput = document.getElementById('end-time'); 
            const modalTitle = document.getElementById('modal-title'); 
            const data = this.parent.utilities.getSelectedData();

            startInput.value = data.first.start; 
            endInput.value = data.last ? data.last.end : data.first.end ; 

            const title = this.parent.resources.find( resource => resource.id == data.resource );
            
            modalTitle.innerHTML = title ? title.name + ' - New Event': 'New Event'; 

            const event = {
                start : data.first.start,
                end :  data.last ? data.last.end : data.first.end,
                resource : data.resource,
                start_cell_id : data.first.id, 
                end_cell_id: data.last ? data.last.id : data.first.id, 
            };

            this.parent.currentEvent = event;             
            this.parent.modal.show();
        }

        showEditModal(event){
            const startInput = document.getElementById('start-time');
            const endInput = document.getElementById('end-time'); 
            const titleInput = document.getElementById('event-title'); 
            const detailsInput = document.getElementById('event-details'); 
            const userNameInput = document.getElementById('event-user'); 
            const modalTitle = document.getElementById('modal-title'); 

            const title = this.parent.resources.find( resource => resource.id == event.resource );

            modalTitle.innerHTML = title ? title.name + ' - Edit Event' : 'Edit Event'; 
                      
            startInput.value = event.start; 
            endInput.value = event.end;
            titleInput.value = event.title; 
            detailsInput.value = event.details;  
            userNameInput.value = event.user_name; 
            
            this.parent.currentEvent = event;  
            this.parent.modal.show();
        }

        async onSubmit(event){
            const url = this.parent.options.saveUrl; 

            const response = await fetch(url, {
                    method: 'POST', 
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(event),
                });
            
            if(!response.ok) throw new Error('Network Error'); 

            return await response.json(); 
        }

        async getEvents(){

            const dateStr = this.parent.utilities.getFormattedDate(this.parent.core.getDate());
            
            const url = this.parent.options.loadUrl+dateStr; 

            const response = await fetch(url); 

            if(!response.ok) throw new Error('Network Error'); 

            return await response.json(); 
        }

        async deleteEvent(eventId){

            const url = this.parent.options.deleteUrl; 

                const response = await fetch(url, {
                    method: 'POST', 
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id: eventId} ),
                });

            if(!response.ok) throw new Error('Network Error'); 
            
            return await response.json(); 
        }
    }
</script>