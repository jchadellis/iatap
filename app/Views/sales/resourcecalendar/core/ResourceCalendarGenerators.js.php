<script>
    class ResourceCalendarGenerators{
        constructor(parent){
            this.parent = parent; 
        }

        dayView() {
            let timeColumnWidth = 8; 

            let html = `<div class="d-flex flex-column w-100">`; 

            let header = `<div class="d-flex flex-row w-100"><div class="bg-primary flex-fill text-center text-white p-1 border" style="width:${timeColumnWidth}%;">Time</div>`;

            let percentage = Math.round((100 - timeColumnWidth ) / this.parent.options.resources.length); 

            for( let i = 0; i < this.parent.options.resources.length; i++ ){
                let title = this.parent.options.resources[i].name; 
                header += `<div class="text-center p-1 border" style="width:${percentage}%;">${title}</div>`; 
            }

            header += '</div>';

            html += header; 

            let columns = `<div class="d-flex flex-row">`;
            let timeColumn = `<div class="d-flex flex-column h-100" style="width:${timeColumnWidth}%;">`; 

            for (let hour = this.parent.options.startHour; hour <= this.parent.options.endHour; hour++) {
                let fullHour = this.parent.utilities.getFormattedTime(hour, 0);
                let halfHour = this.parent.utilities.getFormattedTime(hour, 30); 
                let nextHour = this.parent.utilities.getFormattedTime(hour+1, 0);
                timeColumn += `<div class="bg-light text-dark p-1 border d-flex justify-content-center align-items-center w-100" style="height: ${this.parent.options.cellHeight};"><p class="text-center m-0">${fullHour}</p></div>`;
                timeColumn += `<div class="bg-light text-dark p-1 border d-flex justify-content-center align-items-center w-100" style="height: ${this.parent.options.cellHeight};"><p class="text-center m-0">${halfHour}</p></div>`;
            }
            timeColumn += '</div>'; 

            columns += timeColumn; 

            let resourceColumns = ''; 
            for (let resource = 0; resource < this.parent.options.resources.length ; resource++) {
                let column = `<div class="d-flex flex-column" style="width:${percentage}%; position: relative;">`; 
                for (let hour = this.parent.options.startHour; hour <= this.parent.options.endHour; hour++) {
                    let fullHour = this.parent.utilities.getFormattedTime(hour, 0);
                    let halfHour = this.parent.utilities.getFormattedTime(hour, 30); 
                    let nextHour = this.parent.utilities.getFormattedTime(hour+1, 0);

                    let id = `rc-cell-${resource + 1}${hour}00`;
                    column += `<div id="${id}" class="border cell h-100" data-resource="${resource + 1}" data-id="" data-start-time="${fullHour}" data-end-time="${halfHour}"  position: relative;"></div>`;
                    
                    id = `rc-cell-${resource + 1}${hour}30`;
                    column += `<div id="${id}"  class="border cell h-100" data-resource="${resource + 1}" data-id="" data-start-time="${halfHour}" data-end-time="${nextHour}"  position: relative;"></div>`;
                }     
                column += `</div>`;
                resourceColumns += column; 
            }
            columns += resourceColumns;
            html += columns; 
            html += '</div>';
            return html;
        }

        buttons(){
            const parentrow = document.createElement('div'); 
            parentrow.classList.add('row', 'd-flex', 'justify-content-center', 'align-items-center', 'mb-3','w-50', 'mx-auto'); 
            let  buttons = `<div class="col-1" id="btn-left"><button class="btn btn-primary"><i class="bi bi-chevron-left"></i></button></div>   
                            <div class="col-4 text-center">
                                <div class="input-group">
                                    <button class="btn bg-info"><i class="bi bi-calendar2-range" id="btn-today"></i></button>
                                    <input type="text" class="form-control text-center date-picker" id="display-date" value="${this.parent.currentDate.toDateString()}">
                                </div>
                            </div>
                            <div class="col-1"><button class="btn btn-primary float-end" id="btn-right"><i class="bi bi-chevron-right"></i></button></div>`; 

            parentrow.innerHTML = buttons; 
            return parentrow; 
        }

        event(event){

            let borderColor = '#ffaeaeff'; 

            this.parent.options.resources.forEach((resource) =>{
                if(resource.id == event.resource){
                    borderColor = resource.borderColor; 
                }
            });

            let html =  `<div class="card h-100">
                                <div class="card-body p-0 border-start border-5 rounded-1 overflow-hidden" style="border-color: ${borderColor} !important;">
                                    <div class="m-2" style="height:2em">    
                                        <div class="d-flex justify-content-between align-items-center h-100 w-100">
                                            <h6 class="card-title m-0 flex-fill">${event.title}</h6>
                                            <div class="">
                                                <button class="btn event-edit-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                                <button class="btn event-delete-btn" data-parent="${event.event_id}"><i class="bi bi-x-square"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-text m-2">${event.details}</p>
                                    <div class="d-flex justify-content-end">
                                        <small class="text-end me-2">Created by - ${event.user_name}</small>
                                    </div>
                                </div>
                            </div>`;
            return html; 
        }

        modal(resource){
            let modal = document.createElement('div'); 
            modal.classList.add('modal'); 
            let modal_body = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="${this.parent.options.formId}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-title"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="resource">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="text" class="text-center fw-bold w-100">Start Time</label>
                                            <input class="form-control text-center" type="text" name="start" disabled id="start-time">
                                        </div>
                                        <div class="col-6">
                                            <label for="text" class="text-center fw-bold w-100">End Time</label>
                                            <input class="form-control text-center" type="text" name="end" disabled id="end-time">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <label for="text" class="fw-bold w-100">Event Label</label>
                                            <input class="form-control text-center" type="text" name="title" id="event-title">
                                        </div>
                                        <div class="col-4">
                                            <label for="details" class="fw-bold w-100">Created By</label>
                                            <input class="form-control text-center" type="text" name="" id="event-user" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="details" class="fw-bold w-100">Short Description</label>
                                            <textarea class="form-control" type="text" name="details" id="event-details"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>&nbsp;Close</button>
                                    <button type="button" class="btn btn-primary" id="schedule-btn"><i class="bi bi-floppy-fill"></i>&nbsp;Save</button>
                                </div>
                            </form>
                        </div>
                    </div>`;

            modal.innerHTML = modal_body; 
            document.body.appendChild(modal);
            this.parent.modal = new bootstrap.Modal(modal); 
            return modal; 
        }

    }
</script>