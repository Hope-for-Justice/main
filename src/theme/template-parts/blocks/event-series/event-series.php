<?php

/**
 * event series
 *
 */

// Load values and assign defaults.
$margin_bottom_mobile = get_field('margin_bottom_mobile') ?: '40px';
$margin_bottom_desktop = get_field('margin_bottom_desktop') ?: '80px';
$event_category = get_field('event_category');
$big_card_image = get_field('big_card_image') ?: '309';
?>



<?php $the_query = new WP_Query(
    array(
        'post_type' => 'events',
        'orderby' => 'date',
        'posts_per_page' => 4,
        'tax_query' => array(
            array(
                'taxonomy' => 'event_categories',
                'terms'    => $event_category,
            ),
        ),
    ),
); ?>


<?php if ($the_query->have_posts()) : ?>
    <div class="better-grid hfj-block event-series" style="--margin-bottom-mobile:<?php echo $margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $margin_bottom_desktop ?>;">

        <div class="event-series__big-card" style="background-image:url('<?php echo $big_card_image ?>');">
            <div class="event-series__big-card-gradient"></div>
            <h4 class="block-title event-series__big-card-title"><?php echo get_term($event_category)->name ?> Events</h4>
            <p class="block-text event-series__big-card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
            <a href="<?php echo get_term_link($event_category) ?>" class="button">See all events</a>
        </div>
        <div class="event-series__events">
            <!-- 
                <div>
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <div>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
             -->
        </div>

    </div>

<?php else : ?>
    <p>Select an event category to get started</p>
<?php endif; ?>