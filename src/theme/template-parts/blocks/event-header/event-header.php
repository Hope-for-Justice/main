<?php
// Load values and assign defaults.
//$title = get_field('title') ?: 'Add a title';

?>

<?php

//custom fields
$range_of_dates = get_field('range_of_dates', get_the_ID());
$event_date_start = get_field('event_date_start', get_the_ID());
$event_date_end = get_field('event_date_end', get_the_ID());
$event_time = get_field('event_time', get_the_ID());
$event_type = get_field('event_type', get_the_ID());
$event_location = get_field('event_location', get_the_ID());
//$link = get_field('link', get_the_ID());

//modify date formats
$start_date_mod = date("M j", strtotime($event_date_start));
$end_date_mod = date("M j", strtotime($event_date_end));

?>

<div class="event-header">
    <div class="better-grid">
        <h2 class="font-canela event-header__title block-title"><?php the_title(); ?></h2>

        <div class="event-header__info">
            <!-- display event dates -->
            <div class="event-header__time">
                <img class="event-header__clock" src="<?php echo get_template_directory_uri() . '/assets/img/clock.svg' ?>">
                <?php if ($range_of_dates) { ?>

                    <p><?php echo $start_date_mod ?> - <?php echo $end_date_mod ?></p>

                <?php } else { ?>
                    <p>
                        <?php echo $end_date_mod ?>
                    </p>
                <?php } ?>
            </div>

            <!-- display event location -->
            <div class="event-header__location">
                <?php if ($event_type == 'online') { ?>
                    <img class="event-header__globe" src="<?php echo get_template_directory_uri() . '/assets/img/globe.svg' ?>">
                    <p>
                        <?php echo $event_location ?>
                    </p>
                <?php } else { ?>
                    <img class="event-header__balloon" src="<?php echo get_template_directory_uri() . '/assets/img/balloon.svg' ?>">
                    <p>
                        <?php echo $event_location ?>
                    </p>
                <?php } ?>
            </div>
        </div>

    </div>
</div>




<!-- display categories with links to the category page -->
<?php
//$terms = get_the_terms(get_the_ID(), 'event_categories');
if ($terms) {
    foreach ($terms as $term) { ?>
        <p>
            <a href="<?php echo get_term_link($term->term_id, 'event_categories'); ?>">
                <?php echo $term->name; ?>
            </a>
        </p>
    <?php } ?>
<?php } ?>