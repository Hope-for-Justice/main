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

<?php } else if ( ( $args['type'] ) == "splash") { ?>
    
    <!--
    --
    --  splash
    --
    -->
    <div class="modal modal--splash fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog modal__dialog--splash">
                <div class="modal__content modal__content--splash">
                    <h3>Our new brand</h3>
                    <h2 class="font-fk modal__title modal__title--splash">New look<br> <span class="text-red">Same mission</span></h2>
                    <p class="modal__text modal__text--splash">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi possimus, provident ea ipsam temporibus consequuntur quidem.</p>
                    <a href="#" data-dismiss="modal" class="button button--red">
                        <div class="button__inner">
                            <div class="button__text bold">Continue<br>to website</div>
                        </div>
                    </a>
                    <a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a>

                </div>
         </div>
    </div>

<?php } else if ( ( $args['type'] ) == "payment-once") { ?>
    
    <!--
    --
    --  payment once
    --
    -->
    <div class="modal modal--payment fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog modal__dialog--payment">
                <div class="modal__content modal__content--payment">
                    <?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>

                        <!-- usa form -->
                        <div id="usaForm"><?php echo do_shortcode("[give_form id=\"328\"]"); ?></div>

                    <?php } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['norway'])){ ?>

                        <!-- norway form -->
                        <div id="norwayForm"><?php echo do_shortcode("[give_form id=\"332\"]"); ?></div>
                        
                    <?php } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['aus'])){ ?> 
                        
                        <!-- aus form -->
                        <div id="ausForm"><?php echo do_shortcode("[give_form id=\"333\"]"); ?></div>

                    <?php } else { ?>

                        <!-- uk form --> 
                        <div id="ukForm"><?php echo do_shortcode("[give_form id=\"314\"]"); ?></div>

                    <?php } ?> 
                    <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--payment">&times;<span class="accessibility">Close</span></a>

                </div>
         </div>
    </div>

<?php } else if ( ( $args['type'] ) == "payment-regular") { ?>

    <!--
    --
    --  payment regular
    --
    -->
    <div class="modal modal--payment fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog modal__dialog--payment">
                <div class="modal__content modal__content--payment">
                    <?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['uk'])){ ?>

                        <!-- uk form reg -->
                        <?php echo do_shortcode("[give_form id=\"334\"]"); ?>

                    <?php } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['norway'])){ ?>

                        <!-- norway form redirect to solidus -->
                        
                    <?php } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['aus'])){ ?> 
                        
                        <!-- aus form -->
                        <?php echo do_shortcode("[give_form id=\"336\"]"); ?>

                    <?php } else { ?>

                        <!-- usa form --> 
                        <?php echo do_shortcode("[give_form id=\"335\"]"); ?> 

                    <?php } ?> 
                    <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--payment">&times;<span class="accessibility">Close</span></a>

                </div>
         </div>
    </div>
<?php } else if ( ( $args['type'] ) == "country") { ?>
    
    <!--
    --
    --  reference
    --
    --> 
    <div class="modal fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal__dialog">
                <div class="modal__content">
                    <h2 class="modal__title modal__title--country">Lorem ipsum dolor</h2>
                    <p class="modal__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a>
                </div>
         </div>
    </div>

<?php } else if ( ( $args['type'] ) == "get-help") { ?>

    <!--
    --
    --  get - help
    --
    -->
    <div class="modal get-help-modal fade" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-hidden="false">
        <a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a>
          <div class="modal__dialog get-help-modal__dialog">
                <div class="modal__content modal__content--yellow get-help-modal__content">

                        <?php echo do_shortcode("[gravityform id=\"33\" title=\"false\" ajax=\"true\" description=\"true\"]"); ?>

                    

                </div>
         </div>
    </div>

<?php } ?>