<div class="row">
    <div class="col-12 m-2">
        <div class="row">
            <div class="col-6 border pb-3">
                <div class="row">
                    <div class="col">
                        <h6 class="h6 border-bottom border-primary p-2">Name / Addess</h6>
                        <div class="row m-1">
                            <div class="col-6">
                                <span class="text-accent2">Name: </span> <?= ucwords(strtolower($customer->name)) ?>
                            </div>
                            <div class="col-6">
                                <span class="text-accent2">Customer Since:</span> <?= ( new \DateTime($customer->open_date ))->format('M d, Y') ?>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-12">
                                <span class="text-accent2">Address: </span>
                            </div>
                            <div class="col-12"><?= $customer->addr_1 ?></div>
                            <?php if( $customer->addr_2 ) : ?>
                            <div class="col-12">
                                <?= $customer->addr_2 ?>
                            </div>
                            <?php endif; ?>
                            <div class="col-6">
                                <span class="text-accent2">City</span>
                            </div>
                            <div class="col-3">
                                <span class="text-accent2">State</span>
                            </div>
                            <div class="col-3">
                                <span class="text-accent2">Zip</span>
                            </div>
                            <div class="col-6">
                                <?= ucwords( strtolower( $customer->city )) ?>
                            </div>
                            <div class="col-3">
                                <?= $customer->state ?>
                            </div>
                            <div class="col-3">
                                <?= $customer->zipcode ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6 class="h6 border-bottom border-primary p-2">Contact Information</h6>
                        <div class="row m-1">
                            <div class="col-12">
                                <span class="text-accent2">Name: </span> <?= ucwords( strtolower( $customer->contact_first_name . ' '. $customer->contact_last_name )) ?>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6"><span class="text-accent2">Salutation: </span> <?= ucwords( strtolower( $customer->contact_salutation )) ?></div>
                                    <div class="col-6"><span class="text-accent2">Position: </span> <?= ucwords( strtolower( $customer->contact_position )) ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 border-top m-1">
                            <div class="col-6">
                                <div class="row mt-2">
                                    <div class="col-12"><span class="text-accent2">Phone: </span> <?= $customer->contact_phone ?></div>
                                    <div class="col-12"><span class="text-accent2">Fax: </span> <?= $customer->contact_fax ?></div>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <span class="text-accent2">Email: </span> <?= strtolower( $customer->contact_email ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-6">
                <?= view('components/small-card', ['data' => $cards]); ?>
            </div>
        </div>
    </div>
</div>
