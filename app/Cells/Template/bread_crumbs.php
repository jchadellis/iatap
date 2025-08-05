
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-breadcrumb">
        <?php if(is_array($breadcrumbs)) : ?>
        <?php foreach( $breadcrumbs as $item ) : ?>       
        <li class="breadcrumb-item <?= ( $item['is_active'] ) ? 'active' : '' ?>" >
            <?php if(!$item['is_active']) : ?>
                <a class="text-decoration-none text-accent2" href="<?= site_url($item['url']) ?>"><?= $item['name'] ?></a>
            <?php else : ?>
                <?= $item['name'] ?>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
    </ol>
</nav>