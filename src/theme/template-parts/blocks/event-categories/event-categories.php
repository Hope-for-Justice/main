<?php
// Load values and assign defaults.
//$title = get_field('title') ?: 'Add a title';

?>




<div class="better-grid">
    <div class="event-categories">
        <div class="event-categories__text">Event categories:</div>
        <div class="event-categories__categories">
            <?php
            $terms = get_the_terms(get_the_ID(), 'event_categories');
            if ($terms) {
                foreach ($terms as $term) { ?>
                    <a href="<?php echo get_term_link($term->term_id, 'event_categories'); ?>" class="event-categories__category">
                        <div class="event-categories__category-text">
                            <?php echo $term->name; ?>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.918 63.452">
                            <path id="Path_17238" data-name="Path 17238" d="M1313.474,74.637a6.173,6.173,0,0,1-4.378-1.814L1283.562,47.29a6.192,6.192,0,0,1,8.757-8.756l21.155,21.156,21.156-21.156a6.192,6.192,0,0,1,8.757,8.756l-25.534,25.534A6.173,6.173,0,0,1,1313.474,74.637Z" transform="translate(-36.72 1345.201) rotate(-90)" fill="#212322" />
                        </svg>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

</div>
</div>




<!-- display categories with links to the category page -->