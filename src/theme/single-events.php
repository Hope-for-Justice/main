<?php

/**
 * The template for displaying an event
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main">

    <?php while (have_posts()) : the_post();

        //custom fields
        $range_of_dates = get_field('range_of_dates');
        $event_date_start = get_field('event_date_start');
        $event_date_end = get_field('event_date_end');
        $event_time = get_field('event_time');
        $event_type = get_field('event_type');
        $event_location = get_field('event_location');
        $link = get_field('link');

        //modify date formats
        $start_date_mod = date("M j", strtotime($event_date_start));
        $end_date_mod = date("M j", strtotime($event_date_end));

    ?>

        <h1><?php the_title(); ?></h1>

        <!-- display event dates -->
        <?php if ($range_of_dates) { ?>
            <p>
                Event date: <?php echo $start_date_mod ?> - <?php echo $end_date_mod ?>
            </p>
        <?php } else { ?>
            <p>
                Event date: <?php echo $end_date_mod ?>
                <?php if ($event_time) echo $event_time ?>
            </p>
        <?php } ?>

        <!-- display event location -->
        <?php if ($event_type == 'online') { ?>
            <p>
                Online: <?php echo $event_location ?>
            </p>
        <?php } else { ?>
            <p>
                Offline: <?php echo $event_location ?>
            </p>
        <?php } ?>


        <!-- display categories with links to the category page -->
        <?php if ($terms) {
            foreach ($terms as $term) { ?>
                <p>
                    <a href="<?php echo get_term_link($term->term_id, 'event_categories'); ?>">
                        <?php echo $term->name; ?>
                    </a>
                </p>
            <?php } ?>
        <?php } ?>



        <p><?php the_content(); ?></p>

        <?php if ($link) { ?>
            <a target="_blank" href="<?php echo $link ?>" class="button">Sign up</a>
        <?php } ?>





    <?php endwhile; ?>

</main><!-- #main -->


<?php
get_footer();
