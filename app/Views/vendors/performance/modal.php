
<div class="modal-body">
    <?php $data ?? null ?>
    <?php if($data) : ?>
        <table class="table">
            <tr>
                <th>Vendor ID:</th>
                <td><?= $data->vendor_id ?></td>
                <th>Vendor Name:</th>
                <td colspan="3"><?= $data->name ?></td>
            </tr>
            <tr>
                <th>Street Address:</th>
                <td colspan="3"><?= $data->street_1 ?></td>
            </tr>
            <?php if($data->street_2) : ?>
            <tr>
                <th>Street Address:</th>
                <td colspan="5"><?= $data->street_2 ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>City</th>
                <td><?= $data->city ?></td>
                <th>State</th>
                <td><?= $data->state ?></td>
                <th>Zip</th>
                <td><?= $data->zip ?></td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td><?= $data->phone ?></td>
                <th>Email:</th>
                <td colspan="3"><?= $data->email ?></td>
            </tr>
            <tr>
                <th>Date Opened</th>
                <td><?= $data->open_date ?></td>
                <th>Last Updated</th>
                <td><?= $data->modify_date ?></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th>NCP</th>
                <td><?= $data->ncp ?? 0 ?></td>
                <th>JCP Expiration </th>
                <td><?= $data->jcp_expiration ?? '' ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>
                    Performance Period:
                </th>
                <td colspan="5" ><?= (new DateTime($data->start_date))->format('m-d-Y') ?> - <?= (new DateTime($data->end_date))->format('m-d-Y') ?> </td>
            </tr>
            <tr>
                <th>On Time:</th>
                <td colspan="5">
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $data->on_time_percentage ?>" aria-valuemin="0" aria-valuemax="100" style="height:20px">
                        <div class="progress-bar" style="width: <?= $data->on_time_percentage ?>%"><?= $data->on_time_percentage ?>%</div>
                    </div>
                </td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?= $data->id ?>">
            <div class="row mb-2">
                <div class="col-6">
                    <div class="form-floating">
                        <?php $user = auth()->user() ?? null ?>
                        <input type="text" class="form-control" name="email_from" placeholder="" value="<?= $user->email ?? '' ?>">
                        <label for="email_from">Email From</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="email_to" placeholder="" value="<?= strtolower($data->email) ?>">
                        <label for="email_from">Email To:</label>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-info">
                        Selecting a PO below will append that PO# to the subject when sending.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="subject" placeholder="" value="ATAP INC. - PO: ">
                        <label for="email_from">Subject:</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <select name="purchase_order" id="" class="form-select">
                            <option value="">Select</option>
                            <?php $pos = $data->pos[0] ?? [] ?>
                            <?php foreach($pos as $key => $value ) : ?>
                            <option value="<?= $value ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="purchase_order">Purchase Order</label>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <div id="message">
                        <p><strong>Hello,</strong></p>

                        <p>
                        Please see the attached Purchase Order and confirm receipt and ship date. If we are not able to receive by the requested date please provide the lead time!
                        </p>

                        <p >
                        Thanks so much!
                        </p>

                        <p>
                            <strong>WE ENCOURAGE ALL OUR VENDORS TO MEET A 90% ON TIME DELIVERY TARGET.</strong><br>
                            <strong>AS OF <?= date('m-d-Y'); ?> YOUR ON TIME DELIVERY PERCENTAGE IS <?= $data->on_time_percentage ?>%.</strong>
                        </p>

                        <?= $user->email_signature ?? '' ?>
                        <!-- <p><strong>Jeremy Ellis</strong> <i>Purchasing Specialist</i></p>
                        <p>ATAP,Inc.<br>Phone:256-362-2221 x 157<br>Fax: 256-362-2220</p>
                        <p style="font-size:12px">
                            Please visit us at www.atap.com for online quoting and ordering.
                            Export of information contained herein, which includes, in some circumstances, 
                            release to foreign nationals within the United States, 
                            without first obtaining approval or license from the Department of State for items controlled by the International Traffic in Arms Regulations (ITAR), 
                            or the Department of Commerce for items controlled by the Export Administration Regulations (EAR), 
                            may constitute a violation of law.
                        </p> -->
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <input type="file" name="file" id="" class="form-control" placholder="">
                </div>
            </div>
    <?php endif; ?>
</div>
</form>

<script>
    $(document).ready(function(){

    })
</script>
