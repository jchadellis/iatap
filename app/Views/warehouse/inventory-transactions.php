<form action="print-pick-list" method="post">
    <div class="row mb-4 sticky-top"><!-- Added sticky-row class -->
        <div class="col-3">
            <div class="form-floating">
                <input type="text" class="form-control datepicker" placeholder="Select Date" name="transaction_date" id="transaction_date" value="<?= date('Y-m-d') ?>">
                <label for="transaction_date">Transaction Date</label>
            </div>
        </div>
        <div class="col-3">
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="Start Transaction" name="start_transaction" id="start_transaction" disabled>
                <label for="start_transaction">Start Transaction</label>
            </div>
        </div>
        <div class="col-3">
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="Start Transaction" name="end_transaction" id="end_transaction" disabled>
                <label for="end_transaction">End Transaction</label>
            </div>
        </div>
        <div class="col-3 d-grid flex">
            <button id="print_btn" type="button" onclick="getPDF()" class="btn btn-success fs-5" disabled><i class="bi bi-printer-fill"></i>&nbsp;Print List</button>
        </div>
    </div>
    <div class="row mt-2 sticky-top">
        <div class="col-3 ">
            <div class="form-floating">
                <input type="text" class="form-control" name="delivered_to" placeholder="Delivered To">
                <label for="">Delivered To</label>
            </div>
        </div>
        <div class="col">
            <div class="alert-container">
                <div class="alert alert-info p-1 px-3">
                    First, pick a <strong>Transaction Date</strong> <i class="bi bi-calendar-event"></i>. The list below will update.
                    Then, click the <strong>Start Transaction</strong> and <strong>End Transaction</strong> transaction in the range you want.
                    Finally, click <strong>'Print'</strong> <i class="bi bi-printer-fill"></i> to mark them as printed and print the pick list.
                </div>
            </div>
        </div>
    </div>
    <hr class="border border-secondary border-1 opacity-50" >
</form>
<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Trans No.</th>
                    <th>W/O NO.</th>
                    <th>ID</th>
                    <th>Description</th>
                    <th>ISS</th>
                    <th>Location</th>
                    <th>Location QTY</th>
                    <th>Printed</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
