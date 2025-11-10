<script>
    class ResourceCalenderListeners{

        constructor(parent) {
            this.parent = parent;
        }

        init(){
           this.addListeners(); 
        }

        addListeners(){

            const leftBtn = document.getElementById('btn-left'); 
            const rightBtn = document.getElementById('btn-right'); 
            const todayBtn = document.getElementById('btn-today'); 
            
            if(leftBtn){
                leftBtn.addEventListener('click', ()=>{
                    this.parent.core.decrementDate(); 
                });
            }

            if(rightBtn){
                rightBtn.addEventListener('click', ()=>{
                    this.parent.core.incrementDate(); 
                });
            }

            if(todayBtn){
                todayBtn.addEventListener('click', ()=>{
                    this.parent.core.setToday(); 
                });
            }

            const scheduleBtn = document.getElementById('schedule-btn');
            if(scheduleBtn){
                scheduleBtn.addEventListener('click', ()=>{
                    this.parent.core.saveUpdateEvent(); 
                })
            }
        }

        addCellListeners(){
            // Only select cells that don't have events and don't already have listeners
            const cells = document.querySelectorAll('.cell:not(.has-event):not(.has-listeners)'); 

            cells.forEach((cell)=>{
                cell.addEventListener('click', (e) =>{
                    e.preventDefault(); 
                    this.parent.handlers.onCellClick(cell); 
                });

                cell.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    this.parent.handlers.onMouseDown(cell);
                });

                cell.addEventListener('mouseenter', (e) => {
                    this.parent.handlers.onMouseEnter(cell);
                });

                cell.addEventListener('mouseup', (e) => {
                    this.parent.handlers.onMouseUp(cell);
                });

                // Mark this cell as having listeners
                cell.classList.add('has-listeners');
            });
            
        }

        removeCellEventListeners(){
            let cells = this.parent.container.querySelectorAll('.has-event');

            if(cells){
                cells.forEach((cell)=>{
                    // Clone the cell to remove all event listeners
                    const newCell = cell.cloneNode(true);
                    cell.parentNode.replaceChild(newCell, cell);
                    
                    // Remove both classes
                    //newCell.classList.remove('has-event');
                    newCell.classList.remove('has-listeners');
                })
            }
        }
        
        setEventsListeners() {
            const container = this.parent.container;

            // Remove any existing container listener first
            container.removeEventListener('click', this._eventHandler);

            // Define the handler and store it so it can be removed later
            this._eventHandler = (e) => {
                const deleteBtn = e.target.closest('.event-delete-btn');
                const editBtn = e.target.closest('.event-edit-btn');

                if (deleteBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    this.parent.core.deleteEvent(deleteBtn);
                }

                if (editBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    this.parent.core.editEvent(editBtn);
                }
            };

            container.addEventListener('click', this._eventHandler);
        }

        addModalListener(modal){
            if(modal){
                modal.addEventListener('hidden.bs.modal',()=>{
                    this.parent.utilities.clearSelected(); 
                    this.parent.utilities.clearCurrentEvent(); 
                    this.parent.utilities.clearForm(); 
                })
            }
        }
    }
</script>