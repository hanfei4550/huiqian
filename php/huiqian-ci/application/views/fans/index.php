<?php foreach ($fansItems as $fans_item): ?>
    <h3><?php echo $fans_item['nick']; ?></h3>
    <div class="main">
        <?php echo $fans_item['head_portraint']; ?>
    </div>
<?php endforeach; ?>