<pre>
    <ul>
    <?php foreach ($files as $file): ?>
        <li>
            <?= esc($file) ?>
            <a href="<?= site_url('download/' . rawurlencode($file)) ?>" download>Download</a>
        </li>
    <?php endforeach; ?>
    </ul>
</pre>