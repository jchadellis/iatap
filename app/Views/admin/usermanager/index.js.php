<script>
    // User Manager DataTable Module
    const UserManager = {
        table: null,
        selectedRow: null,
        
        // Configuration constants
        config: {
            urls: {
                data: '<?= base_url('sadmin/user-manager/data') ?>',
                new: '<?= base_url('sadmin/user-manager/new') ?>',
                add: '<?= base_url('sadmin/user-manager/add') ?>',
                edit: '<?= base_url('sadmin/user-manager/edit') ?>',
                save: '<?= base_url('sadmin/user-manager/save') ?>',
                email: '<?= base_url('sadmin/user-manager/email') ?>'
            },
            modals: {
                new: '#new-user-modal',
                edit: '#edit-user-modal'
            }
        },

        // Initialize the module
        init() {
            this.setupDataTableDefaults();
            this.initDataTable();
            this.bindEvents();
        },

        // Setup DataTable button defaults
        setupDataTableDefaults() {
            $.extend(true, $.fn.dataTable.Buttons.defaults, {
                dom: {
                    button: {
                        className: 'btn btn-primary'
                    }
                }
            });
        },

        // Initialize DataTable
        initDataTable() {
            this.table = new DataTable('.table', {
                select: true,
                lengthMenu: [25, 50, 100, 200, { label: 'All', value: -1 }],
                ajax: {
                    url: this.config.urls.data,
                    dataSrc: 'data'
                },
                pageLength: 25,
                responsive: true,
                order: [[0, 'asc'], [1, 'asc']],
                language: {
                    buttons: {
                        colvis: `<i class="bi bi-eye-slash"></i>&nbsp;Show/Hide Columns`,
                        pageLength: '<i class="bi bi-binoculars"></i>&nbsp;Show %d rows',
                        excel: `<i class="bi bi-file-earmark-excel"></i>&nbsp;Export to Excel`,
                        pdf: `<i class="bi bi-file-earmark-pdf"></i>&nbsp;Export to PDF`
                    }
                },
                columns: [
                    {
                        data: 'row_order',
                        title: 'Row Order',
                        visible: false
                    },
                    {
                        data: null,
                        title: 'Name',
                        render: (data) => `${data.first_name} ${data.last_name}`
                    },
                    {
                        data: 'last_name',
                        title: 'Last Name',
                        visible: false
                    },
                    {
                        data: 'username',
                        title: 'Username'
                    },
                    {
                        data: 'email',
                        title: 'Email Address'
                    }
                ],
                columnDefs: [
                    {
                        targets: [0],
                        className: 'dt-center',
                        orderable: true,
                        render: (data) => data || '-'
                    }
                ],
                layout: {
                    topStart: {
                        buttons: [
                            'pageLength',
                            {
                                text: '<i class="bi bi-plus-square"></i>&nbsp;Add User',
                                action: () => this.handleAddUser(),
                                className: 'btn-success'
                            }
                        ]
                    }
                },
                createdRow: (row, data) => {
                    $(row).data('id', data.id);
                }
            });
        },

        // Bind event handlers
        bindEvents() {
            this.table.off('select').on('select', (e, dt, type, indexes) => {
                if (type === 'row') {
                    this.handleRowSelect(dt, indexes);
                }
            });

            this.table.on('deselect', (e, dt, type, indexes) => {
                if (type === 'row') {
                    // Do something when table row is deselected.
                }
            });

            $('.edit-btn').on('click', () => {
                $(this.config.modals.edit).modal('show');
            });

            $(this.config.modals.edit).on('hidden.bs.modal', () => {
                this.handleModalClose();
            });

            $(this.config.modals.new).on('hidden.bs.modal', () => {
                this.handleModalClose();
            });
        },

        // Handle add user button click
        async handleAddUser() {
            const modal = $(this.config.modals.new);
            modal.modal('show');
            
            try {
                const response = await this.makeRequest(this.config.urls.new, '');
                if (response.success) {
                    modal.find('.modal-content').html(response.data);
                    this.setupForm(modal, 'add');
                }
            } catch (error) {
                this.showError('Error loading form', error.message);
            }
        },

        // Handle row selection
        async handleRowSelect(dt, indexes) {
            const row = dt.row(indexes[0]).node();
            const modal = $(this.config.modals.edit);
            modal.modal('show');
            this.selectedRow = $(dt.row(indexes).node());
            
            const data = { id: $(row).data('id') };
            
            try {
                const response = await this.makeRequest(this.config.urls.edit, data);
                if (response.success) {
                    modal.find('.modal-content').html(response.data);
                    this.setupForm(modal, 'save', response);
                } else {
                    this.showError(response.title, response.message);
                }
            } catch (error) {
                this.showError('Error loading user data', error.message);
                modal.modal('hide'); 
            }
        },

        // Setup form with common functionality
        setupForm(modal, action, userData = null) {
            const saveBtn = $('.save-btn');
            const form = modal.find('form');
            this.form = form; 
            
            form.dirtyForms();
            
            form.on('dirty.dirtyforms', () => saveBtn.prop('disabled', false));
            form.on('clean.dirtyforms', () => saveBtn.prop('disabled', true));
            
            saveBtn.on('click', (e) => {
                e.preventDefault();
                this.handleFormSave(form, action, modal);
            });
            
            $('.gen-pw').on('click', () => {
                this.generateAndSetPassword(userData);
            });
        },

        // Handle form save
        async handleFormSave(form, action, modal) {
            const url = this.config.urls[action];
            const data = form.serialize();
            
            try {
                const response = await this.makeRequest(url, data);
                
                form.dirtyForms('setClean');
                modal.modal('hide');
                
                if (response.success) {
                    if (action === 'add') {
                        await this.handleAddSuccess(response);
                    } else {
                        await this.handleEditSuccess(response);
                    }
                } else {
                    this.showError(response.title, response.message);
                }
            } catch (error) {
                this.showError('Error saving user', error.message);
            }
        },

        // Handle successful add operation
        async handleAddSuccess(response) {
            const result = await Swal.fire({
                title: response.title,
                text: response.message,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Email Password',
                cancelButtonText: 'Close'
            });
            
            if (result.isConfirmed) {
                await this.sendPasswordEmail(response.id, response.password);
            }
            
            this.table.row.add(response.user).draw();
            $(this.table.row(':first').node()).addClass('table-success');
        },

        // Handle successful edit operation
        async handleEditSuccess(response) {
            if (response.email) {
                const result = await Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Email Password',
                    cancelButtonText: 'Cancel'
                });
                
                if (result.isConfirmed) {
                    await this.sendPasswordEmail(response.id, response.password);
                }
            } else {
                this.showSuccess(response.title, response.message);
            }
        },

        // Send password email
        async sendPasswordEmail(id, password) {
            try {
                const response = await this.makeRequest(this.config.urls.email, { id, password });
                const alertType = response.success ? 'success' : 'warning';
                
                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: alertType
                });
            } catch (error) {
                this.showError('Error sending email', error.message);
            }
        },

        // Generate password and set in form
        generateAndSetPassword(userData = null) {
            const password = this.generatePassword(userData);
            const pwField = $('#password');
            
            pwField.val(password).text(password).trigger('input').trigger('change');
            $('form').find('#user\\[password\\]').val(password);
        },

        // Generate password based on user data
        generatePassword(userData = null) {
            const chars = '!@#$%^&*';
            let fName, lName;
            
            if (userData) {
                fName = userData.first_name.toLowerCase();
                lName = userData.last_name.toLowerCase();
            } else {
                fName = $("input[name=first_name]").val().toLowerCase();
                lName = $("input[name=last_name]").val().toLowerCase();
            }
            
            let password = '';
            for (let i = 0; i < 4; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            
            return fName.substring(0, 3) + lName.substring(0, 3) + password;
        },

        // Handle modal close
        handleModalClose() {
            if (this.selectedRow) {
                const row = this.table.row(this.selectedRow);
                row.deselect();
                this.selectedRow = null;
            }
           this.form.dirtyForms('setClean');
        },

        // Utility function for AJAX requests
        makeRequest(url, data) {
            return new Promise((resolve, reject) => {
                $.post(url, data)
                    .done(resolve)
                    .fail((xhr, status, error) => reject(new Error(error)));
            });
        },

        // Show success message
        showSuccess(title, message) {
            Swal.fire({
                title,
                text: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },

        // Show error message
        showError(title, message) {
            Swal.fire({
                title,
                text: message,
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    };

    // Initialize when document is ready
    $(document).ready(() => {
        UserManager.init();
    });

</script>