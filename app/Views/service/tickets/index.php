<div class="row mb-1">
    <div class="col">
        <div class="alert alert-info">
            <p class="text-center p-0 m-0">
                To get started, simply click the <i class="bi bi-plus-square"></i>&nbsp;New Request Ticket button.This will open up the ticket editor where you can enter all the details of your request.
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <table class="table table-bordered table-striped" id="table">
        
        </table>
    </div>
</div>

<?= view('service/tickets/new-ticket-modal') ?>

<div class="modal" tabindex="-1" id="service-ticket-modal">
    <form action="" id="service-ticket-modal-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content-modal">
                <div class="modal-header">
                    <h5 class="modal-title">Request Ticket Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"> <i class="bi bi-x-square"></i> &nbsp;Exit</button>
                    <?php if($userCanClose) : ?>
                        <button type="button" id="close-ticket-btn" class="btn btn-warning"><i class="bi bi-check-square"></i>&nbsp;Close Ticket</button> 
                    <?php else: ?>
                        <button type="button" id="close-ticket-btn" class="btn btn-warning" disabled><i class="bi bi-check-square" ></i>&nbsp;Close Ticket</button> 
                    <?php endif; ?>
                    <?php if($userCanUpdate) : ?>  
                        <button type="button" id="update-ticket-btn"  class="btn btn-primary" ><i class="bi bi-arrow-up-circle"></i>&nbsp;Update</button>
                    <?php else: ?>
                        <button type="button" id="update-ticket-btn"  class="btn btn-primary" disabled><i class="bi bi-arrow-up-circle"></i>&nbsp;Update</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>
