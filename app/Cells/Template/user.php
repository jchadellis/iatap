    <div class="vr" ></div>

    <?php if(auth()->loggedIn()) : ?>
    <?php $user = auth()->user(); ?>
    <ul class="navbar-nav ">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user->first_name .' ' . $user->last_name ?> &nbsp;</span>
                <img class="img-profile rounded-circle" src="<?= base_url(ASSETSPATH.'img/undraw_profile.png') ?>" style="width: 25px; height: 25px; "> 
                <?php if($user->inGroup('it')) : ?>
                    <span class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-primary">
                        <?= ($count) ?? '' ?>
                        <span class="visually-hidden">IT Service Tickets</span>
                    </span>   
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= base_url('user/profile') ?>">Profile</a></li>
                
                <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                <?php if($user->inGroup('it')) : ?>
                    <li>
                        <a href="<?= base_url('it') ?>" class="dropdown-item">
                            IT Service Tickets 
                            <span class="badge text-bg-primary">
                            <?= ($count) ?? '' ?>
                            <span class="visually-hidden">IT Service Tickets
                            </span>
                        </a>
                    </span>   
                    </li>
                <?php endif; ?>
            </ul>                                
        </li>
    </ul>
    <?php else : ?>
    <ul class="navbar-nav ">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('login') ?>" role="button" >
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Guest &nbsp; </span>
                <img class="img-profile rounded-circle" src="<?= base_url(ASSETSPATH.'img/undraw_profile.png') ?>" style="width: 25px; height: 25px; ">            
            </a>                            
        </li>
    </ul>
    <?php endif; ?>
