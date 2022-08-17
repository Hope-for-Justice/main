<?php
// content-full-header.php template.
 
// args
$args = wp_parse_args($args);
?>

<div class="full-header space-bottom <?php echo $args['class'] ?>">
   
    <div class="full-header__image">
        <img src="<?php echo $args['src'][0]; ?>" srcset="<?php echo $args['srcset']; ?>" alt="" />
    </div>

    <?php if ($args['has-gradient']) { ?>
        <div class="full-header__gradient"></div>
    <?php } ?>
    
    <div class="better-grid full-header__grid">
        <h1 class="full-header__title h1-to-mob-l h1-to-tab large-title-to-desk super-title"><?php echo $args['title']; ?></h1>
        <p class="full-header__description large p--to-mob-l"><?php echo $args['description']; ?></p>
    </div>



</div>