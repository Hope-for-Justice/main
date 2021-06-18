<?php
// modal.php template.
 
// Set defaults.
$args = wp_parse_args(
    $args,
    array(
        'type' => 'basic',
        'id' => 'modal'
    )
);
?>


<?php if ( ( $args['type'] ) == "basic") { ?>
    
    <!--
    --
    --  basic
    --
    --> 
    <div class="modal fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog">
                <div class="modal__content">
                    <p class="modal__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt deserunt veritatis tempore alias quasi totam consectetur enim, at ea obcaecati velit pariatur amet distinctio culpa perferendis saepe suscipit illo! Pariatur.</p>
                    <a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a>
                </div>
         </div>
    </div>

<?php } else if ( ( $args['type'] ) == "reference") { ?>
    
    <!--
    --
    --  reference
    --
    --> 
    <div class="modal fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog">
                <div class="modal__content modal__content--yellow">
                    <p class="modal__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--yellow">&times;<span class="accessibility">Close</span></a>
                </div>
         </div>
    </div>



<?php } else if ( ( $args['type'] ) == "video") { ?>
    
    <!--
    --
    --  video
    --
    -->
    <div class="modal modal--video fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog modal__dialog--video">
                <div class="modal__content modal__content--video video-container">
                    <iframe class="video" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

                    <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--video">&times;<span class="accessibility">Close</span></a>

                </div>
         </div>
    </div>

<?php } ?>