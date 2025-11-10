<script>
    class ResourceCalendarUtilities{
        constructor(parent){
            this.parent = parent; 
        }

        init(){

        }

        removeSelectedCells(){
            const selector = '.' + this.parent.options.selectedCellClass; 
            const elements = this.parent.container.querySelectorAll(selector); 
            elements.forEach((element) => {
                element.classList.remove(this.parent.options.selctedCellClass);
            });
        }

        removeHasEventClass(){
            const cells = document.querySelectorAll('.' + this.parent.options.hasEventClass);
            cells.forEach((cell)=>{
                cell.classList.remove(this.parent.options.hasEventClass); 
            });
        }

        removeCellClass(element, className){
            element.classList.remove(className); 
        }

        setCellClass(element, className)
        {
            element.classList.add(className); 
        }

        hasEvent(element){
            return element.classList.contains(this.parent.options.hasEventClass); 
        }

        
        getFormattedTime(hour, mins ){
            const time = new Date(); 
            time.setHours(hour, mins, 0, 0); 
            const displayTime = time.toLocaleTimeString('en-US', {
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });

            return displayTime; 
        }

        getFormattedDate(date)
        {
            const year = date.getFullYear(); 
            const month = String(date.getMonth() + 1).padStart(2,'0'); 
            const day = String(date.getDate()).padStart(2,'0'); 
            return `${year}-${month}-${day}`;
        }

        timeToSeconds(timeString) {
            const date = new Date(`2000/01/01 ${timeString}`); // Use an arbitrary date to create a valid Date object
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const seconds = date.getSeconds();
            return (hours * 3600) + (minutes * 60) + seconds;
        }

        timeToString(string)
        {
            var time = string.split('AM'); 
            time = time[0].split(':');
            var timeStr = time.join(''); 
            return timeStr.trim(); 
        }
        
        clearSelected(){
            const selected = this.getSelected(); 

            if(selected){
                selected.forEach((element) => {
                    element.classList.remove('selected'); 
                })
            }
        }

        getSelected(){
            const selectedCells = this.parent.container.querySelectorAll('.selected'); 
            return selectedCells; 
        }

        getSelectedData(){
            const selected = this.getSelected(); 

            if(selected.length > 1){
                const first = selected[0]; 
                const last = selected[selected.length - 1]; 
                const elements =  { 
                    first : { start: first.dataset.startTime, end: first.dataset.endTime, id: first.getAttribute('id') }, 
                    last : { start: last.dataset.startTime, end: last.dataset.endTime, id: last.getAttribute('id') }, 
                    resource: first.dataset.resource, 
                } ;  
                return elements; 
            }
            
            const element = selected[0];
            const elements =  { 
                first : { start: element.dataset.startTime, end: element.dataset.endTime, id: element.getAttribute('id') }, 
                last : null,
                resource: element.dataset.resource,
            }
            return elements; 
        }

        clearCurrentEvent(){
            this.parent.currentEvent = {}; 
        }

        clearForm(){
            const form = document.getElementById(this.parent.options.formId); 
            if(!form) return; 
            form.reset(); 
        }
    }
</script>