
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto  text-white text-decoration-none text-middle">
      <i class="bi bi-ethernet fs-2 me-2"></i>
      <span class="fs-4">&nbsp;Connect Portal</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
            <?php foreach($sidebar_pages as $page) : ?>
                <?php if($page->is_default == 't') : ?>
                    <li class="nav-item">
                        <?php $active = (CURRENT_CONTROLLER == rtrim( $page->directory ) ) ? 'active' : '' ?>
                        <?php $directory = rtrim(strtolower($page->directory)); $controller = rtrim(strtolower($page->controller)); $method =  ( $page->method == 'index' ) ? rtrim(strtolower($page->method)) : '' ; ?> 
                        <a href="<?= $this->helper->base_url("$directory/$controller/$method") ?> " class="nav-link <?= $active ?> p-2">
                            <i class="fa-solid <?= $page->icon ?>"></i>&nbsp; <?= $page->name; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach;?>
            <?php foreach($sidebar_pages as $page) : ?>
                <?php if($page->access_level == $this->session->get_access_level() && $page->is_parent == 't') : ?>
                    <li class="nav-item">
                        <?php $active = (CURRENT_CONTROLLER == rtrim( $page->directory ) ) ? 'active' : '' ?>
                        <?php $directory = rtrim(strtolower($page->directory)); $controller = rtrim(strtolower($page->controller)); $method =  ( $page->method == 'index' ) ? rtrim(strtolower($page->method)) : '' ; ?> 
                        <a href="<?= $this->helper->base_url("$directory/$controller/$method") ?> " class="nav-link <?= $active ?> p-2">
                            <i class="fa-solid <?= $page->icon ?>"></i>&nbsp; <?= $page->name; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach;?>
        <?php else: ?>
            <?php foreach($sidebar_pages as $page) : ?>
                <?php if($page->is_default == 't') : ?>
                    <li class="nav-item">
                        <?php $active = (CURRENT_CONTROLLER == rtrim( $page->directory ) ) ? 'active' : '' ?>
                        <?php $directory = rtrim(strtolower($page->directory)); $controller = rtrim(strtolower($page->controller)); $method =  ( $page->method == 'index' ) ? rtrim(strtolower($page->method)) : '' ; ?> 
                        <a href="<?= $this->helper->base_url("$directory/$controller/$method") ?> " class="nav-link <?= $active ?> p-2">
                            <i class="fa-solid <?= $page->icon ?>"></i>&nbsp; <?= $page->name; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>


<!--footer class="footer">&copy; 2025 Your Company</footer-->