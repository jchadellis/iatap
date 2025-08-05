
<form action="<?= site_url('leave/requestform') ?>" method='get'>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="alert alert-warning" role="alert">
                        Employees may use this form to complete and print their Leave Request / Absentee Form. To download the form for offline completion, please <a href="<?= base_url('assets/documents/employee/leave_form.pdf') ?>" class="alert-link">click here</a>.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                   <div class="form-floating">
                        <input class="form-control datepicker" name="current_date" type="text" placeholder="Today's Date" data-sb-validations="required" value="<?= date('m-d-Y'); ?>" />
                        <label for="current_date">Today's Date</label>
                        <div class="invalid-feedback" data-sb-feedback="current_date:required">Today's Date is required.</div>
                   </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control datepicker" name="event_date" type="text" placeholder="Date of Event" required/>
                        <label class="form-label" for="event_date">Date of Event</label>
                        <div class="invalid-feedback" >Date of Event is required.</div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control" name="employee_name" type="text" placeholder="First and Last Name" required />
                        <label class="form-label" for="employee_name">Employee's Name</label>
                        <div class="invalid-feedback">Your Name is required.</div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-floating">
                        <input class="form-control" name="badge_number" type="text" placeholder="Badge Number"/>
                        <label class="form-label" for="badge_number">Badge Number</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input class="form-control" name="department" type="text" placeholder="Employees Deparment"  />
                        <label class="form-label" for="department">Department</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="row g-4">
                        <div class="col-3 d-grid">
                            <label for="">Free Day </label>
                            <input type="checkbox" name="checkbox_free_day" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                data-target = '#free-day-collapse'
                                data-alert='#message-container'
                                data-message="Select the day you want to use for your <strong>Free Day</strong>"
                            >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Vacation Day </label>   
                            <input type="checkbox" name="checkbox_vacation_day" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                data-target = '#vacation-day-collapse'
                                data-alert='#message-container'
                                data-message="<p>Enter the <strong>Number of days</strong> you will be using for vacation.</p><p>Enter the <strong>Dates</strong> of your vacation."                          
                            >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Illness (Self) </label>
                            <input type="checkbox" name="checkbox_illness_self" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                            >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Illness (Family) </label>
                            <input type="checkbox" name="checkbox_illness_family" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                            >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Doctor Appt. </label>
                            <input type="checkbox" name="checkbox_doctor" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                            >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Personal </label>
                            <input type="checkbox" name="checkbox_personal" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                            >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Jury Duty </label>
                            <input type="checkbox" name="checkbox_jury_duty" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Bereavement </label>
                            <input type="checkbox" name="checkbox_bereavement" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Late Arrival </label>
                            <input type="checkbox" name="checkbox_arrive_late" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                data-target="#arrive-late-collapse"
                                data-alert='#message-container'
                                data-message="Enter the time you have arrived <strong>Late</strong>"
                                >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Early Leave </label>
                            <input type="checkbox" name="checkbox_leave_early" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                data-target="#leave-early-collapse"
                                data-alert='#message-container'
                                data-message="Enter the time you are leaving <strong>Early</strong>"
                                >
                        </div>
                        <div class="col-3 d-grid">
                            <label for=""> Other </label>
                            <input type="checkbox" name="checkbox_other" value='1' 
                                data-toggle="toggle"  
                                data-on="<i class='bi'></i> Yes" 
                                data-off="<i class='bi'></i> NO"
                                data-onstyle='success'
                                data-offstyle='info'
                                data-size="small"
                                >
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row g-2">
                        <div id="message-container">

                        </div>
                        <div class="col-6 d-none" id="arrive-late-collapse">

                            <div class="form-floating">
                                <input class="form-control timepicker" name="clock_in_late" type="text" placeholder="Arrive Late Time" value="" />
                                <label class="form-label" for="clock_in_late">Arrive Late Time</label>
                            </div>
                        </div>
                        <div class="col-6 d-none" id="leave-early-collapse">
                            <div class="form-floating" >
                                <input class="form-control timepicker" name="clock_out_early" type="text" placeholder="Leave Early Time" value="" />
                                <label class="form-label" for="clock_out_early">Leave Early Time</label>
                            </div>
                        </div>
                        <div class="col-6 d-none" id="free-day-collapse">
                            <div class="form-floating">
                                <input class="form-control datepicker" name="free_day_taken_date" type="text" placeholder="XX-XX-XXXX" value="" />
                                <label class="form-label" for="free_day_taken_date">Date of Free Day</label>
                            </div>
                        </div>
                        <div id="vacation-day-collapse" class="row g-2 d-none">
                            
                            <div class="col-6">
                                <div class="form-floating">
                                    <input class="form-control" name="vacation_length" type="text" placeholder="ex: 5"/>
                                    <label class="form-label" for="vacation_length">Days of Vacation</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="" name="vacation_date_range" id="daterange" class="form-control" placeholder="Dates of Vacation" >
                                    <label for="vacation_date_range">Dates of Vacation</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-floating">
                        <textarea name="comments" id="" class="form-control" placeholder="Enter any additional comments here." ></textarea>
                        <label for="comments" class="form-label">Aditional Comments</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4 d-grid"><button class="btn btn-success" type="submit"><i class="bi bi-printer-fill"></i> Print Leave / Absent Form</button></div>
            </div>

            
        </div>
    </div>
</form>
