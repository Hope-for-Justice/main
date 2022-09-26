<?php
$mobile = get_field('mobile') ?: '40px';
$tablet = get_field('tablet') ?: '40px';
$desktop = get_field('desktop') ?: '80px';
?>

<div class="better-grid spacer-block" style="--mobile: <?php echo $mobile ?>; --tablet: <?php echo $tablet ?>;  --desktop: <?php echo $desktop ?>;  <?php if (is_admin()) echo 'background-color:#fafafa'; ?>">
    <?php if (is_admin()) echo 'Spacer'; ?>
</div>