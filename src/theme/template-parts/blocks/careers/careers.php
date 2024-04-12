<?php

$emptyCezanne = false;
$hideCezanne = get_field("hide_cezanne") ?: false;
$get_records = wp_remote_get(
	"https://cezanneondemand.intervieweb.it/annunci.php?lang=en&LAC=hopeforjustice&d=hopeforjustice.org&k=c27d0f6eb2ff4684a4861d58933b8957&CodP=&nbsp;&format=json_en&utype=0"
);
// when empty show message
if ($get_records["body"] == "[]") {
	$emptyCezanne = true;
}
?>

<div class="better-grid careers-block">
    <?php if (!$hideCezanne) { ?>
        <?php foreach (json_decode($get_records["body"]) as $body) { ?>
        <?php if (strpos($body->project_label, "SFA") === false) { ?>

            <div class="careers-block__card">
                <a class="careers-block__inner" href="<?php echo $body->url; ?>">
                    <!-- Card title -->
                    <h3 class="careers-block__title">
                        <?php echo $body->title; ?>
                    </h3>

                    <!-- location -->
                    <div class="careers-block__location">
                        <img src="<?php echo get_template_directory_uri() .
                        	"/assets/img/balloon.svg"; ?>" />
                        <p>
                            <?php echo $body->location; ?>,&nbsp;<?php echo $body->nation; ?>
                        </p>
                    </div>
                </a>
            </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <?php if (have_rows("non_cezanne")):
    	while (have_rows("non_cezanne")):
    		the_row(); ?>

            <div class="careers-block__card">
                <a class="careers-block__inner" href="<?php echo get_sub_field(
                	"link"
                ); ?>">
                    <!-- Card title -->
                    <h3 class="careers-block__title">
                        <?php echo get_sub_field("title"); ?>
                    </h3>
                    <?php if (get_sub_field("description")) { ?>
                        <div class="careers-block__description">
                            <p><?php echo get_sub_field("description"); ?></p>
                        </div>
                    <?php } ?>

                    <!-- location -->
                    <div class="careers-block__location">
                        <img src="<?php echo get_template_directory_uri() .
                        	"/assets/img/balloon.svg"; ?>" />
                        <p>
                            <?php echo get_sub_field("location"); ?>
                        </p>
                    </div>
                </a>
            </div>

        <?php
    	endwhile;
    else:
    	$emptyNonCezanne = true;

    	if ($emptyNonCezanne == true && $emptyCezanne == true): ?>
            <h2 style="text-align: center; grid-column: col2 / col12; opacity:0.5;" class="font-canela">No Vacancies</h2>

    <?php endif;
    endif; ?>


</div><!-- /careers-block -->