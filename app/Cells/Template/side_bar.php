<a href="/" class="d-flex align-items-center mb-1 mx-auto text-white text-decoration-none text-middle">
  <img src="<?= base_url(ASSETSPATH.'/img/iatap_logo.svg')?>" alt="" style="height: 75px;" >
</a>
<hr>

<ul class="nav nav-pills flex-column mb-auto">
<?php
  $router = service('router');
  $controllerParts = explode("\\", $router->controllerName());
  $currentControllerName = $controllerParts[3];
?>

<?php foreach ($pages as $page): ?>
    <?php
      $currentController = ($page->controller === 'Index') ? $page->directory : $page->controller;
      $isCurrent = (strtolower( (string)$currentControllerName ) === strtolower( (string)$currentController) ) ? 'active' : '';
    ?>

    <?php foreach ($page->access_level as $group): ?>
        <?php
        $canView = false;

          if ($user->inGroup($group) || $user->inGroup('super') ) {
            
              $canView = true;
          }
        ?>
        <?php if ($canView): ?>
            <li class="nav-item">
                <!-- <a href="<?= ($page->url !== 'null') ? $page->url : site_url($page->uri) ?>" -->
                <a href="<?= site_url($page->uri) ?? '' ?>"
                  class="nav-link px-2 <?= $isCurrent ?>">
                    <i class="<?= $page->icon ?> me-3"></i><?= $page->name ?>
                </a>
            </li>
            <?php break; // prevent duplicate rendering ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>

</ul>
