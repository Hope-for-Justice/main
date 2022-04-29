<?php
/**
 * Template Name: Donorfy webhooks
 *
 * @package Hope_for_Justice_2021
 */

get_header( '', array( 'page_class' => 'site--full') ); ?>

<main id="main" class="site-main donation-thankyou" role="main">

    <div class="full-grid">

        <style type="text/css">
            .email, .title, .button-con {
                grid-column: main; 
                text-align: center;
            }
        </style>

        <h1 class="font-canela title">Donorfy Webhooks</h1>


        <div class="button-con">
            <div id="test" class="button button--red">test</div>
        </div>

    </div><!-- /grid -->

    
</main><!-- #main -->

<?php get_footer(); ?>