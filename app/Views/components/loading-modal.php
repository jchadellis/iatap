<script>
    function showLoadingModal( id = 'dynamicModal',  title = 'Loading', message = 'Please wait...') {
    // Remove existing modal if it exists


        const existing = document.getElementById(id);

        if (existing) existing.remove();


        const modalHTML = `
            <div class="modal fade" id="${id}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content text-center p-4">
                        <div class="modal-body">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 class="modal-title">${title}</h5>
                            <p>${message}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Show modal
        const modalEl = document.getElementById(id);
        const bsModal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });

        // Optional: Automatically remove modal element after it's fully hidden
        modalEl.addEventListener('hidden.bs.modal', function onHiddenCleanup() {
            modalEl.remove(); // Remove from DOM
        });

        bsModal.show();

        // Return reference to modal in case you want to hide or destroy it later
        return bsModal;

    }
</script>