<?php
/**
 * Template Name: Block template
 *
 * @package Hope_for_Justice_2021
 */

get_header("",["page_class" =>
"site--full"]); 

?>






<main class="main site-main block-template">

    <?php while (have_posts()): the_post(); 
     the_content(); 
    endwhile;?>

</main>

<!-- <div class="better-grid">

        <!-- content for wyswig?-->

<!-- <h3 class="font-canela full-width mb-24 h4-to-mob-l">What is Anti-Slavery Day?</h3>

        <p class="full-width space-bottom">Anti-Slavery Day is an opportunity to raise awareness of the fact over 40
            million people in the world today, and an estimated 136,000 people in the UK, are trapped in conditions of
            modern slavery. But it doesn’t have to be this way.
            <br><br>Anti-Slavery Day is a time to encourage governments, businesses, friends, family and colleagues to
            do what they can to prevent human trafficking and protect victims of modern-day slavery.
        </p>

        <div class="half">
            <h3 class="font-canela full-width mb-24 h4-to-mob-l">When is Anti-Slavery Day?</h3>
            <p class="space-bottom">Anti-Slavery Day takes place every year on the 18th October. At Hope for Justice, we
                will be hosting a whole week of events and campaigns (17th – 23rd October) which individuals and
                organisations can take part in.</p>
        </div>

        <div class="half">
            <h3 class="font-canela full-width mb-24 h4-to-mob-l">Get involved in Anti-Slavery Day!
            </h3>
            <p class="space-bottom">Whether you’re new to the issue of modern slavery or a seasoned activist, we have
                planned plenty of ways for organisations and individuals to get involved in Anti-Slavery Day.</p>
        </div>

        <div class="cta-card">

        </div> -->

<!-- end content -->
<!--</div> -->


<?php get_footer(); ?>