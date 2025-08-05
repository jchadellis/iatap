<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-5">
        <div class="card col-12 col-md-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-5"><?= lang('Auth.register') ?></h5>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>
                     <!-- First Name -->
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="floatingfirstNameInput" name="first_name"   placeholder="<?= lang('Auth.firstName') ?>" value="<?= old('first_name') ?>" required>
                        <label for="floatingfirstNameInput"><?= lang('Auth.firstName') ?></label>
                    </div>
                    <!-- Last Name -->
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="floatinglastNameInput" name="last_name" placeholder="<?= lang('Auth.lastName') ?>" value="<?= old('last_name') ?>" required>
                        <label for="floatinglastNameInput"><?= lang('Auth.lastName') ?></label>
                    </div>
                   <!-- Last Name -->
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="floatingDoBInput" name="date_of_birth" placeholder="<?= lang('Auth.dob') ?>" value="<?= old('date_of_birth') ?>" required>
                        <label for="floatingDoBInput"><?= lang('Auth.dob') ?></label>
                    </div>
                    <!-- Address -->
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingStreetInput" name="street" placeholder="<?= lang('Auth.street') ?>" value="<?= old('street') ?>" required>
                                <label for="floatingStreetnput"><?= lang('Auth.street') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingStateInput" name="city" placeholder="<?= lang('Auth.city') ?>" value="<?= old('city') ?>" required>
                                <label for="floatingCityInput"><?= lang('Auth.city') ?></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingStateInput" name="state" placeholder="<?= lang('Auth.state') ?>" value="<?= old('state') ?>" required>
                                <label for="floatingStateInput"><?= lang('Auth.state') ?></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingStateInput" name="zip" placeholder="<?= lang('Auth.zip') ?>" value="<?= old('zip') ?>" required>
                                <label for="floatingZipInput"><?= lang('Auth.zip') ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <!-- Primary Phone -->
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingPhone1Input" name="primary_number" inputmode="tel" placeholder="<?= lang('Auth.phone1') ?>" value="<?= old('primary_number') ?>" required>
                                <label for="floatingPhone1Input"><?= lang('Auth.phone1') ?></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Primary Phone -->
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingPhone2Input" name="secondary_number" inputmode="tel" placeholder="<?= lang('Auth.phone2') ?>" value="<?= old('secondary_number') ?>" required>
                                <label for="floatingPhone2Input"><?= lang('Auth.phone2') ?></label>
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                        <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                    </div>

                    <!-- Username -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                        <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                        <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                    </div>

                    <!-- Password (Again) -->
                    <div class="form-floating mb-5">
                        <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                        <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                    </div>

                    <div class="d-grid col-12 col-md-8 mx-auto m-3">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                    </div>

                    <!-- <p class="text-center"><?= lang('Auth.haveAccount') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p> -->

                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
