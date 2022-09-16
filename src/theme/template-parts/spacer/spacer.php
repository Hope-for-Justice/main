<?php
$mobile = get_field('mobile') ?: '40px';
$tablet = get_field('tablet') ?: '40px';
$desktop = get_field('desktop') ?: '80px';
?>

<div class="spacer" style="--mobile: <?php echo $mobile ?>; --tablet: <?php echo $tablet ?>;  --desktop: <?php echo $desktop ?>;"></div>