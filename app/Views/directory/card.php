
<?php foreach($contacts as $contact ): ?>
    <div class="card shadow-sm border-gray" style="width:40rem; border-radius: 0 !important; ">
        <div class="card-body">
            <div class="row">
                <div class="col-1 text-center">
                        <i class="bi bi-person-vcard-fill fs-2"></i>
                </div>
                <div class="col-4 border-start ms-2">
                    <div class="col fw-bold text-primary"><?= $contact->fname . '  ' . $contact->lname ?></div>
                    <div class="col"><span class="fw-bold">Extension:</span> <?= $contact->extension ?></div>
                </div>
                <div class="col-4 border-start ms-2">
                    <div class="col"><span class="fw-bold">Departement:</span> : <span class="text-secondary"><?= $contact->department ?></span></div>
                    <div class="col"><span class="fw-bold">Location:</span>: <?= $contact->building ?></div>
                </div>
                <div class="col">
                    Button
                </div>
            </div>
        </div>
    </div>
<?php  endforeach; ?>
