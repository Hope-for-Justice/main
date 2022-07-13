<?php
/**
 * Template Name: Church Partnerships
 *
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full"]); 

?>

<?php while (have_posts()):
    the_post(); ?>

<?php
$thumbnail = "";

// Get the ID of the post_thumbnail (if it exists)
$post_thumbnail_id = get_post_thumbnail_id($post->ID); // if it exists if

if ($post_thumbnail_id) { 

$srcset = wp_get_attachment_image_srcset($post_thumbnail_id, "", false, ""); 
$src = wp_get_attachment_image_src($post_thumbnail_id); 
$sizes = wp_get_attachment_image_sizes($post_thumbnail_id); 

} ?>


<main class="main site-main church-partnerships">
    <div class="full-grid">

        <div class="church-partnerships__hero-img">
            <img src="<?php echo $src[0]; ?>" srcset="<?php echo $srcset; ?>" alt="" />
        </div>



        <div class="church-partnerships__text church-partnerships__hero-text">
            <div class="church-partnerships__title">
                <h3><?php the_field('subtitle')?></h3>
                <h1 class="font-canela"><?php the_title()?></h1>
            </div>
            <?php the_content()?>

        </div>



        <div class="church-partnerships__image"
            style="background-image: url('<?php the_field('second_image')?>');">
        </div>

        <div class="church-partnerships__text-container">
            <h2 class="font-canela"><?php the_field('second_title')?></h2>
            <?php the_field('second_content')?>
            <div class="church-partnerships__see-more church-partnerships__see-more--margin-top">
                <div class="church-partnerships__see-more-button"></div>
                <p>Read more</p>
            </div>
        </div>

        <div class="church-partnerships__image church-partnerships__image--reverse"
            style="background-image: url('<?php the_field('third_image')?>');">
        </div>

        <div class="church-partnerships__text-container church-partnerships__text-container--reverse">
            <h2 class="font-canela"><?php the_field('third_title')?></h2>
            <?php the_field('third_content')?>
            <div class="church-partnerships__see-more church-partnerships__see-more--margin-top">
                <div class="church-partnerships__see-more-button"></div>
                <p>Read more</p>
            </div>
        </div>

        <h2 id="scrollToHere"
            class="church-partnerships__heading church-partnerships__heading--margin-top church-partnerships__heading--larger church-partnerships__heading--center font-canela">
            <?php the_field('fourth_title')?></h2>

        <div class="church-partnerships__flex">
            <div class="church-partnerships__image church-partnerships__image--full"
                style="background-image: url('<?php the_field('fourth_image')?>');">
            </div>
            <div class="church-partnerships__flex-text">
                <h3 class="font-fk church-partnerships__heading church-partnerships__heading--fk"><?php the_field('fifth_title')?></h3>
                <?php the_field('fourth_content')?>
            </div>
        </div>

        <div class="church-partnerships__flex church-partnerships__flex--not-top">
            <div class="church-partnerships__image church-partnerships__image--full"
                style="background-image: url('<?php the_field('fifth_image')?>');">
            </div>
            <div class="church-partnerships__flex-text">
                <h3 class="font-fk church-partnerships__heading church-partnerships__heading--fk"><?php the_field('sixth_title')?></h3>
                <?php the_field('fifth_content')?>
            </div>
        </div>

        <div class="church-partnerships__act"
            style="background-image: url('<?php the_field('sixth_image')?>');">
            <h3 class="font-fk church-partnerships__heading church-partnerships__heading--fk"><?php the_field('seventh_title')?></h3>
            
            <div class="church-partnerships__act-flex">
                <div class="church-partnerships__act-flex-child">
                    <div class="church-partnerships__see-more church-partnerships__see-more--below">
                        <div class="church-partnerships__see-more-button"></div>
                        <h4 class="font-canela"><?php the_field('eighth_title')?></h4>
                    </div>
                    <?php the_field('sixth_content')?>
                </div>

                <div class="church-partnerships__act-flex-child">
                    <div class="church-partnerships__see-more church-partnerships__see-more--below">
                        <div class="church-partnerships__see-more-button"></div>
                        <h4 class="font-canela"><?php the_field('ninth_title')?></h4>
                    </div>
                    <?php the_field('seventh_content')?>
                </div>

                <div class="church-partnerships__act-flex-child">
                    <div class="church-partnerships__see-more church-partnerships__see-more--below">
                        <div class="church-partnerships__see-more-button"></div>
                        <h4 class="font-canela"><?php the_field('tenth_title')?></h4>
                    </div>
                    <?php the_field('eighth_content')?>
                </div>

                <div class="church-partnerships__act-flex-child">
                    <div class="church-partnerships__see-more church-partnerships__see-more--below">
                        <div class="church-partnerships__see-more-button"></div>
                        <h4 class="font-canela"><?php the_field('eleventh_title')?></h4>
                    </div>
                    <?php the_field('ninth_content')?>
                </div>
            </div>
        </div>

        <div data-toggle="modal" data-target="#video-modal" data-src="<?php the_field('video_source'); ?>" class="church-partnerships__video video-trigger">
            <div class="church-partnerships__video-play">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13.488 15.607">
                    <path id="Polygon_37" data-name="Polygon 37"
                        d="M6.073,2.992a2,2,0,0,1,3.462,0l4.336,7.494a2,2,0,0,1-1.731,3H3.468a2,2,0,0,1-1.731-3Z"
                        transform="translate(13.488) rotate(90)" fill="#fff" />
                </svg>
            </div>
            <svg class="church-partnerships__video-svg" id="Group_7270" data-name="Group 7270"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 93.512 124.046">
                <defs>
                    <clipPath id="clip-path">
                        <rect id="Rectangle_1998" data-name="Rectangle 1998" width="93.512" height="124.046"
                            transform="translate(0 0)" fill="none" />
                    </clipPath>
                </defs>
                <g id="Group_7269" data-name="Group 7269" clip-path="url(#clip-path)">
                    <path id="Path_17056" data-name="Path 17056"
                        d="M93.5,24.565a.067.067,0,0,0-.069-.029c-1.747.2-3.8.432-3.8.432a9.63,9.63,0,0,0-7.584-.447,10.272,10.272,0,0,0-5.517,4.573l-.919-.309.651-5.373A9.495,9.495,0,0,0,71.973,14.5L49.189,0c-.483,1.1-3.384,14.782,9.574,21.165,6.439,3.166,7.9,3.872,8.175,4.152a1.16,1.16,0,0,1,.458.707s-12-3.981-15.265-5.111C41.336,17.2,22.487,10.755,13.552,7.783c0,0,3.113,24.092,31.69,34,9.03,3.2,16.365,5.789,16.365,5.789A4.163,4.163,0,0,1,63.932,49.3,3.8,3.8,0,0,1,64,52.815C59.788,60.784,45.16,88.5,44.367,89.993a16.042,16.042,0,0,0,6.029-4.2c1.972-2.263,3.49-4.131,7.013-8.221,4.307-5.006,8.93-10.368,8.93-10.368L67.521,78.93a10.274,10.274,0,0,0,2.75-6.057c.361-3.067,1.445-11.913,1.445-11.913s7.822-9.171,14.464-16.9c6.412-7.419,4.729-15.026,4.542-15.656,0,0,2.222-2.993,2.775-3.755a.075.075,0,0,0,0-.088m-7.275,5a1.6,1.6,0,1,1,.389-2.232,1.6,1.6,0,0,1-.389,2.232"
                        fill="#fff" />
                    <path id="Path_17057" data-name="Path 17057"
                        d="M3.892,53.97v8.9H5.637v-8.9H9.53V75.539H5.637V66.375H3.892v9.164H0V53.97Z" fill="#fff" />
                    <path id="Path_17058" data-name="Path 17058"
                        d="M10.919,63.942c0-7.417,2.015-10.243,5.5-10.243s5.5,2.832,5.5,10.243v1.614c0,7.417-2.015,10.243-5.5,10.243s-5.5-2.832-5.5-10.243Zm4.426,7.116c0,.888.431,1.373,1.073,1.373s1.074-.485,1.074-1.373V58.307c0-.888-.43-1.373-1.074-1.373s-1.073.485-1.073,1.373Z"
                        fill="#fff" />
                    <path id="Path_17059" data-name="Path 17059"
                        d="M27.28,53.97c3.272,0,6.091,2.157,6.091,6.742v.542c0,4.585-2.819,6.742-6.04,6.742v7.549H23.307V53.976H27.28Zm.057,10.779h.27c1.073,0,1.745-.623,1.745-2.157V59.357c0-1.534-.672-2.157-1.745-2.157h-.27Z"
                        fill="#fff" />
                    <path id="Path_17060" data-name="Path 17060"
                        d="M41.609,53.97v3.506H38.388v5.393h2.819v3.506H38.388v5.663h3.221v3.507H34.364V53.976h7.245Z"
                        fill="#fff" />
                    <path id="Path_17061" data-name="Path 17061"
                        d="M0,78.082H7.245v3.506H4.024v5.393H6.7v3.506H4.024v9.164H0Z" fill="#fff" />
                    <path id="Path_17062" data-name="Path 17062"
                        d="M7.7,88.059c0-7.416,2.015-10.242,5.5-10.242s5.5,2.832,5.5,10.242v1.615c0,7.417-2.015,10.243-5.5,10.243S7.7,97.085,7.7,89.674Zm4.426,7.117c0,.888.431,1.373,1.073,1.373s1.074-.485,1.074-1.373V82.425c0-.888-.43-1.373-1.074-1.373s-1.073.485-1.073,1.373Z"
                        fill="#fff" />
                    <path id="Path_17063" data-name="Path 17063"
                        d="M23.945,78.082c3.381,0,5.958,2.37,5.958,6.551A7.1,7.1,0,0,1,27.624,90.3l2.015,9.083v.271H25.747L24.22,91.456h-.4l.19,8.195H19.983V78.082ZM24,88.6h.132c.941,0,1.745-.726,1.745-2.157V83.48c0-1.43-.8-2.157-1.745-2.157H24Z"
                        fill="#fff" />
                    <path id="Path_17064" data-name="Path 17064"
                        d="M7.245,102.2v17.117c0,2.693-1.206,4.585-4.024,4.585A19.468,19.468,0,0,1,0,123.631l.27-3.368H2.257c.78,0,1.1-.352,1.1-1.108V105.7H0v-3.506H7.245Z"
                        fill="#fff" />
                    <path id="Path_17065" data-name="Path 17065"
                        d="M18.485,102.2v16.177c0,3.506-1.877,5.663-4.966,5.663s-4.966-2.157-4.966-5.663V102.2h4.025v17.226c0,.888.293,1.373.941,1.373s.942-.485.942-1.373V102.2Z"
                        fill="#fff" />
                    <path id="Path_17066" data-name="Path 17066"
                        d="M23.164,116.353a3.2,3.2,0,0,1,.161,1.211v2c0,.836.373,1.372.993,1.372.643,0,1.022-.542,1.022-1.482,0-1.724-1.125-3.316-2.308-4.879l-.781-1.027c-1.825-2.4-2.577-3.991-2.577-6.361,0-3.1,1.854-5.253,4.885-5.253,3.088,0,4.776,2.156,4.776,5.582a5.355,5.355,0,0,0,.161,1.563v.271H25.874a3.628,3.628,0,0,1-.161-1.211V106.33c0-.865-.4-1.292-.965-1.292-.591,0-1.045.433-1.045,1.511,0,1.592.833,2.722,2.016,4.233l.8,1.027c1.855,2.347,2.848,4.2,2.848,6.845,0,3.287-1.854,5.392-4.777,5.392-3.272,0-4.936-2.128-4.936-5.9a4.871,4.871,0,0,0-.161-1.511v-.271h3.668Z"
                        fill="#fff" />
                    <path id="Path_17067" data-name="Path 17067"
                        d="M39.33,102.2v3.506H36.649v18.063H32.625V105.706H29.938V102.2Z" fill="#fff" />
                    <rect id="Rectangle_1997" data-name="Rectangle 1997" width="4.024" height="21.569"
                        transform="translate(40.501 102.2)" fill="#fff" />
                    <path id="Path_17068" data-name="Path 17068"
                        d="M51.265,101.935c3.221,0,4.937,2.56,4.937,6.6a6.9,6.9,0,0,0,.132,1.482v.271H52.31a4.473,4.473,0,0,1-.132-1.211v-2.67c0-.755-.321-1.24-.964-1.24s-1.046.485-1.046,1.373v12.751c0,.888.4,1.372,1.046,1.372s.964-.484.964-1.24v-2.669a4.424,4.424,0,0,1,.132-1.212h4.024v.271a6.182,6.182,0,0,0-.132,1.621c0,4.043-1.716,6.6-4.937,6.6-3.49,0-5.528-2.831-5.528-10.242v-1.615c0-7.422,2.038-10.248,5.528-10.248"
                        fill="#fff" />
                    <path id="Path_17069" data-name="Path 17069"
                        d="M64.692,102.2v3.506H61.471V111.1H64.29v3.507H61.471v5.663h3.221v3.507H57.447v-21.57h7.245Z"
                        fill="#fff" />
                </g>
            </svg>
        </div>

        <h2 class="church-partnerships__heading church-partnerships__heading--margin-top church-partnerships__heading--center font-canela"><?php the_field('twelfth_title')?></h2>
        <p class="church-partnerships__text church-partnerships__text--max-width church-partnerships__text--center church-partnerships__text--no-margin">
            <?php the_field('tenth_content')?>
        </p>

        <div class="church-partnerships__button church-partnerships__button--center">
            <a href="<?php the_field('download_all_link')?>" class="button button--grey" download>download all
            </a>
        </div>

        <div class="church-partnerships__cards cards sub-grid">
            <?php
                $select_resources_template = get_field('select_resources_template');
                $args=array(
                'post_type' => 'resources_template',
                'post_status' => 'publish',
                'posts_per_page' => -1,

                
                );
                $query = null;
                $query = new WP_Query($args);
                $resources_template = get_field('select_resources_template');

                // if have posts 
                if( $select_resources_template ) { ?>

                <!-- while there is posts display them -->
                <?php foreach( $resources_template as $rpost ): ?>
                    <?php 
                        if(get_field('choose_between', $rpost->ID) == 'pdf') {
                            $field = get_field('upload_pdf',$rpost->ID); 
                        } elseif(get_field('choose_between', $rpost->ID) == 'link') { 
                            $field = get_field('link',$rpost->ID); 
                        }
                        ?>

                        <div class="cards__card">
                            <a target="_blank" href="<?php echo $field; ?>" download>
                                <div class="cards__content" >
                                    <div class="cards__img-container">
                                        <img src="<?php echo get_the_post_thumbnail_url($rpost->ID); ?>" class="cards__img">
                                    </div>
                                    <div class="cards__info">
                                        <div class="cards__text">
                                            <span class="cards__excerpt">
                                                <?php echo get_the_excerpt($rpost->ID); ?>
                                            </span>
                                            <?php if( ! get_field('no_download', $rpost->ID) ) { ?>	
                                            <img class="resources__download" src="<?php echo get_template_directory_uri().'/assets/img/download.svg'; ?>" alt="">
                                            <?php } ?>		
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                <?php endforeach; } ?>
            </div>


        </div>
</main>



<?php
endwhile;
// end of the loop.
?>

	<!-- 
	-- 
	-- video modal
	-- 
	--> 
	<?php get_template_part(
	    'partials/content',
	    'modal',
	    array(
	        'type' => 'video',
	        'id' => 'video-modal'
	    )
	); ?>

<?php get_footer(); ?>