

<div class="row mb-4">
    <div class="col-6 mx-auto">
        <form action="<?= site_url('directory/search')?>" id="searchForm" method="post">
            <div class="input-group">
                <input class="form-control" type="text" name="search" placeholder="Search, First Name / Last Name" id="searchInput" style="border-bottom-color: rgb(222, 226, 230)" >
            </div>
        </form>
    </div>
</div>
<div class="d-flex flex-wrap justify-content-center gap-3 "  id="contacts" >
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
                    <div class="col-5 border-start ms-2">
                        <div class="col"><span class="fw-bold">Departement:</span> : <span class="text-secondary"><?= $contact->department ?></span></div>
                        <div class="col"><span class="fw-bold">Location:</span>: <?= $contact->building ?></div>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <a href="contact-edit/<?= $contact->id ?>" class="btn btn-link"><i class="bi bi-pencil text-dark fs-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php  endforeach; ?>
</div>


