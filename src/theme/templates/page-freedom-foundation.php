<?php

/**
 * Template Name: FreedomFoundation
 *
 * @package Hope_for_Justice_2021
 */

get_header("", [
	"page_class" =>
		"site--full campaign-page freedom-foundation campaign-page-hide-donate",
	"icons" => "white",
]);

if ($GLOBALS["userInfo"] && in_array($GLOBALS["userInfo"], $GLOBALS["usa"])) {
	$country = "USA";
} else {
	$country = "UK";
}
?>

<main id="main" class="site-main ff-main" role="main" data-country="<?php echo $country; ?>">

    <div class="ff-bright-gradient"></div>


    <div class="ff-content">

        <div class="ff-header">

            <div class="better-grid">

                <div class="ff-header__left">
                    <div class="ff-header__small-title ff-gsap-group-1">GIVE DIRECTLY</div>
                    <div class="ff-header__svg ff-gsap-group-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 495 170.933">
                            <defs>
                                <clipPath id="clip-path">
                                    <rect id="Rectangle_3766" data-name="Rectangle 3766" width="495" height="170.933" fill="#fff" />
                                </clipPath>
                            </defs>
                            <g id="Group_7435" data-name="Group 7435" transform="translate(0 0)">
                                <path id="Path_17152" data-name="Path 17152" d="M0,.481V82.171H15.17V47.161H44.58V33.155H15.17V14.483H51.7v-14Z" transform="translate(0 0.454)" fill="#fff" />
                                <g id="Group_7434" data-name="Group 7434" transform="translate(0 0)">
                                    <g id="Group_7433" data-name="Group 7433" clip-path="url(#clip-path)">
                                        <path id="Path_17153" data-name="Path 17153" d="M58.414,25a33.249,33.249,0,0,1,8.008-11.031,23.375,23.375,0,0,0-8.984-2.208c-6.65,0-13.186,3.618-17.389,10.5V12.694H25.579V71.512h14.47V50.621C40.049,31.6,47.4,24.714,55.8,24.714a12.335,12.335,0,0,1,2.61.284" transform="translate(24.175 11.115)" fill="#fff" />
                                        <path id="Path_17154" data-name="Path 17154" d="M98.944,46.77h-40.5c.35,6.536,4.9,13.3,13.888,13.3,6.652,0,10.735-3.034,14.236-9.1L98.244,55.29C93.692,65.677,85.756,72.446,71.52,72.446c-20.19,0-28.241-16.456-28.241-30.344S51.33,11.76,71.52,11.76c19.6,0,27.424,16.222,27.424,29.058ZM58.8,35.333H84.124c-1.286-5.835-4.9-11.2-12.6-11.2-7.353,0-11.671,5.6-12.721,11.2" transform="translate(40.904 11.115)" fill="#fff" />
                                        <path id="Path_17155" data-name="Path 17155" d="M129.786,46.77h-40.5c.35,6.536,4.9,13.3,13.888,13.3,6.652,0,10.735-3.034,14.236-9.1l11.671,4.318C124.532,65.677,116.6,72.446,102.36,72.446c-20.19,0-28.241-16.456-28.241-30.344S82.17,11.76,102.36,11.76c19.6,0,27.426,16.222,27.426,29.058ZM89.639,35.333h25.325c-1.286-5.835-4.9-11.2-12.6-11.2-7.353,0-11.671,5.6-12.721,11.2" transform="translate(70.051 11.115)" fill="#fff" />
                                        <path id="Path_17156" data-name="Path 17156" d="M131.978,22.875c5.954,0,11.671,3.034,14.24,6.3V0h14.47V82.626h-14.47V76.558c-1.634,3.034-7,7-14.24,7-17.737,0-26.839-12.252-26.839-30.342s9.1-30.344,26.839-30.344m1.986,48.315c7.584,0,13.538-6.3,13.538-17.971s-5.954-17.973-13.538-17.973-13.655,6.3-13.655,17.973,6.069,17.971,13.655,17.971" transform="translate(99.368 0)" fill="#fff" />
                                        <path id="Path_17157" data-name="Path 17157" d="M165.8,11.76c18.907,0,29.875,13.3,29.875,30.344S184.712,72.446,165.8,72.446,135.93,59.143,135.93,42.1,146.9,11.76,165.8,11.76m0,48.315c9.337,0,14.705-8.286,14.705-17.971S175.142,24.131,165.8,24.131,151.1,32.415,151.1,42.1s5.369,17.971,14.705,17.971" transform="translate(128.469 11.115)" fill="#fff" />
                                        <path id="Path_17158" data-name="Path 17158" d="M202.809,71.512V32.3c0-5.952-2.918-8.169-7.236-8.169-7.119,0-12.721,8.284-12.721,25.79V71.512h-14.47V12.7h14.47v9.451c4.318-6.536,9.337-10.387,16.922-10.387,7.236,0,13.888,3.62,16.454,12.138,4.2-7.586,10.739-12.138,17.975-12.138,10.969,0,17.5,6.769,17.5,18.09V71.512H237.235V32.3c0-5.952-2.918-8.169-7.236-8.169-7,0-12.721,7.936-12.721,24.506V71.512Z" transform="translate(159.14 11.115)" fill="#fff" />
                                        <path id="Path_17159" data-name="Path 17159" d="M51.7,45.4v14H15.172V78.075h29.41v14H15.172v35.01H0V45.4Z" transform="translate(0 42.908)" fill="#fff" />
                                        <path id="Path_17160" data-name="Path 17160" d="M54.957,56.678c18.906,0,29.875,13.3,29.875,30.344s-10.968,30.342-29.875,30.342-29.875-13.3-29.875-30.342S36.05,56.678,54.957,56.678m0,48.315c9.337,0,14.705-8.286,14.705-17.971S64.294,69.049,54.957,69.049,40.252,77.333,40.252,87.022s5.369,17.971,14.705,17.971" transform="translate(23.705 53.567)" fill="#fff" />
                                        <path id="Path_17161" data-name="Path 17161" d="M93.949,115.975v-9.451c-4.32,6.184-10.62,10.385-18.206,10.385-10.5,0-18.088-5.952-18.088-17.739V57.159h14.47V94.853c0,7,3.5,9.685,8.4,9.685,7,0,13.421-8.4,13.421-23.925V57.159h14.47v58.816Z" transform="translate(54.49 54.022)" fill="#fff" />
                                        <path id="Path_17162" data-name="Path 17162" d="M139.216,73.017c1.867-9.687,10.387-16.339,22.406-16.339,14,0,24.742,5.835,24.742,24.623V116.43h-11.9l-1.517-7.469c-4.085,5.018-9.687,8.4-18.088,8.4-10.037,0-17.856-6.185-17.856-17.854s10.268-19.259,25.09-19.259h9.8V77.685c0-6.536-4.9-8.636-10.27-8.636-4.083,0-8.286,1.284-10.152,6.769Zm19.021,31.976c6.652,0,13.655-4.552,13.655-12.136V91.688h-9.687c-6.185,0-10.037,2.334-10.037,7.588a5.667,5.667,0,0,0,6.069,5.717" transform="translate(129.479 53.567)" fill="#fff" />
                                        <rect id="Rectangle_3765" data-name="Rectangle 3765" width="14.47" height="58.816" transform="translate(361.95 111.183)" fill="#fff" />
                                        <path id="Path_17163" data-name="Path 17163" d="M225.636,56.678c18.907,0,29.875,13.3,29.875,30.344s-10.969,30.342-29.875,30.342-29.875-13.3-29.875-30.342,10.968-30.344,29.875-30.344m0,48.315c9.337,0,14.705-8.286,14.705-17.971s-5.368-17.973-14.705-17.973-14.705,8.284-14.705,17.973,5.369,17.971,14.705,17.971" transform="translate(185.016 53.567)" fill="#fff" />
                                        <path id="Path_17164" data-name="Path 17164" d="M242.856,57.613v9.451c4.318-6.184,10.62-10.385,18.206-10.385,10.5,0,18.088,5.95,18.088,17.737v42.012H264.68V78.735c0-7-3.5-9.687-8.4-9.687-7,0-13.421,8.4-13.421,23.925v23.456h-14.47V57.613Z" transform="translate(215.85 53.568)" fill="#fff" />
                                        <path id="Path_17165" data-name="Path 17165" d="M146.218,45.47v28.1c-2.569-3.268-8.286-6.3-14.24-6.3-17.737,0-26.839,12.254-26.839,30.344s9.1,30.342,26.839,30.342c7.238,0,12.606-3.968,14.24-7v6.069h14.47V45.47Zm-12.254,70.115c-7.586,0-13.655-6.3-13.655-17.971s6.069-17.973,13.655-17.973,13.538,6.3,13.538,17.973-5.954,17.971-13.538,17.971" transform="translate(99.368 42.975)" fill="#fff" />
                                        <path id="Path_17166" data-name="Path 17166" d="M201.11,112.694l-.535-1.842a11.077,11.077,0,0,1-5.6,1.4c-4.9,0-7.7-2.334-7.7-9.57V77.242h15.522V64.873H187.271V49H172.8V64.873h-9.1V77.242h9.1v25.674c0,14.588,8.286,21.707,21.591,21.707a22.213,22.213,0,0,0,9.57-2.1Z" transform="translate(154.713 46.31)" fill="#fff" />
                                        <path id="Path_17167" data-name="Path 17167" d="M99.249,56.679a20.313,20.313,0,0,0-12.5,4.376V73.01a10.236,10.236,0,0,1,7.712-3.962c4.9,0,8.4,2.684,8.4,9.689v37.694h14.472V74.416c0-11.785-7.586-17.737-18.088-17.737" transform="translate(81.99 53.568)" fill="#fff" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <p class="ff-header__text ff-gsap-group-1">When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact.</p>
                    <div class="ff-header__links ff-gsap-group-1">
                        <a href="#" id="seeAppeals" class="button">See urgent appeals</a>
                        <a id="getInTouch" href="#" class="button button--plain">
                            <span class="button__text">Get in touch</span>
                            <span style="white-space: pre;" class="ff-button__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>
                        </a>
                    </div>

                    <div class="ff-line ff-gsap-group-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="555" height="1" viewBox="0 0 555 1">
                            <line id="Line_84" data-name="Line 84" x2="555" transform="translate(0 0.5)" fill="none" stroke="#fff" stroke-width="1" stroke-dasharray="10" opacity="0.299" />
                        </svg>
                    </div>
                </div>

            </div><!-- /grid -->

            <div class="ff-header__photos">
                <div class="ff-header__photos-prevent ff-chip ff-gsap-group-3">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.059 18.059">
                        <path id="ban-solid" d="M12.952,14.549,3.51,5.107a6.771,6.771,0,0,0,9.442,9.442Zm1.6-1.6A6.771,6.771,0,0,0,5.107,3.51ZM0,9.029a9.029,9.029,0,1,1,9.029,9.029A9.029,9.029,0,0,1,0,9.029Z" fill="#fff" />
                    </svg>

                    <span>Prevent exploitation</span>
                </div>
                <div class="ff-header__photos-support ff-chip ff-gsap-group-3">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.93 13.488">
                        <path id="handshake-angle-solid" d="M24.454,14.527v.09l1.9-1.9a1.527,1.527,0,0,0,0-2.162L24.225,8.423a1.527,1.527,0,0,0-2.162,0L20.969,9.518a2.061,2.061,0,0,0-.227-.014H17.685a1.966,1.966,0,0,0-1.954,1.747H15.72v3.275a1.092,1.092,0,1,0,2.184,0v-2.4h4.367a2.183,2.183,0,0,1,2.184,2.184ZM18.777,13v1.529a1.965,1.965,0,1,1-3.931,0V11.289a2.617,2.617,0,0,0-2.074,1.862l-.45,1.572-2,2a1.527,1.527,0,0,0,0,2.162l2.132,2.132a1.527,1.527,0,0,0,2.162,0l1.029-1.029.074,0h4.367a1.311,1.311,0,0,0,1.31-1.31,1.358,1.358,0,0,0-.074-.437H21.4a1.309,1.309,0,0,0,.95-2.211,1.529,1.529,0,0,0,1.234-1.5v-.011A1.528,1.528,0,0,0,22.052,13H18.777Z" transform="translate(-9.875 -7.975)" fill="#fff" />
                    </svg>

                    <span>Support survivors</span>
                </div>
                <div class="ff-header__photos-reform ff-chip ff-gsap-group-3">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.592 12.59">
                        <path id="landmark-solid" d="M5.918.1A.792.792,0,0,1,6.7.1l4.225,2.412.106.042V2.58l1.178.674a.787.787,0,0,1-.389,1.471H.8A.787.787,0,0,1,.412,3.253L1.587,2.58V2.557L1.7,2.518ZM1.587,5.508H3.161V10.23h.984V5.508H5.719V10.23H6.9V5.508H8.473V10.23h.984V5.508H11.03v4.827a.428.428,0,0,1,.044.027l1.18.787a.786.786,0,0,1-.438,1.441H.8a.786.786,0,0,1-.435-1.441l1.18-.787.044-.027V5.508Z" transform="translate(-0.014)" fill="#fff" />
                    </svg>
                    <span>Reform society</span>
                </div>
                <div class="ff-header__photos-hug ff-gsap-group-2">
                    <img src="https://hopeforjustice.org/wp-content/uploads/2024/03/Reintegration-Ethiopia-July-2021-professional-10-1-nosp.jpg" alt="">
                </div>

                <div class="ff-header__photos-boy ff-gsap-group-2">
                    <img src="https://hopeforjustice.org/wp-content/uploads/2024/03/boy-thinking-aged-9-12-nosp.jpg" alt="">
                </div>
                <div class="ff-header__photos-police ff-gsap-group-2">
                    <img src="https://hopeforjustice.org/wp-content/uploads/2024/03/police-law-enforcement-training-classroom-learning-women-policewomen-police-officers-AdobeStock_235998685-nosp.jpg" alt="">
                </div>
            </div>
        </div><!-- /ff-header -->

        <div class="ff-appeals">
            <div class="better-grid">
                <h2 class="ff-appeals__title ff-gsap-group-4">
                    Urgent Appeals
                </h2>
                <p class="ff-appeals__text ff-gsap-group-4">
                    These are the six highest priority projects lacking funding right now. Can you partner with us by giving in one of these priority areas? Your support will change lives for victims and survivors of human trafficking, while helping to prevent it from happening in the first place.
                </p>
            </div>
            <div class="better-grid ff-appeals__grid">
                <div 
                data-image="https://hopeforjustice.org/wp-content/uploads/2024/04/ff-imsa-nosp.jpg" 
                data-title="Independent advocacy for survivors of modern slavery" 
                data-description="When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact."  
                data-widget="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "4b6e6610-a4f2-ee11-a81c-002248a02917";
                } else {
                	echo "c8a030a4-a1f2-ee11-a81c-000d3ab72843";
                } ?>" 
                data-pdf="https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-Independent-Modern-Slavery-Advocates.pdf" 
                class="ff-appeals__grid-item ff-gsap-group-4">
                    <div class="ff-appeals__image" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/ff-imsa-nosp.jpg');"></div>
                    <div class="ff-appeals__gradient"></div>
                    <div class="ff-appeals__content">
                        <div class="ff-chip">UK, NATIONWIDE</div>
                        <div class="ff-appeals__red-chip">Urgent appeal</div>
                        <h3>
                            Advocacy for survivors of modern slavery<span>&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>

                        </h3>

                    </div>
                </div>

                <div                
                data-image="https://hopeforjustice.org/wp-content/uploads/2024/04/uganda-lighthouse-nosp.jpg" 
                data-title="Aftercare for child survivors of human trafficking" 
                data-description="When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact."  
                data-widget="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "06721c13-a5f2-ee11-a81c-002248a47c9e";
                } else {
                	echo "833a27c9-a2f2-ee11-a81c-000d3ab72843";
                } ?>"
                data-pdf="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-U.S.-Uganda-Lighthouse.pdf";
                } else {
                	echo "https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-UK-Uganda-Lighthouse.pdf";
                } ?>"
                class="ff-appeals__grid-item ff-gsap-group-4">
                    <div class="ff-appeals__image" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/uganda-lighthouse-nosp.jpg');"></div>
                    <div class="ff-appeals__gradient"></div>
                    <div class="ff-appeals__content">
                        <div class="ff-chip">UGANDA, KAMPALA</div>
                        <div class="ff-appeals__red-chip">Urgent appeal</div>
                        <h3>
                            Aftercare for child survivors of human trafficking<span>&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>

                        </h3>

                    </div>
                </div>

                

                <div
                data-image="https://hopeforjustice.org/wp-content/uploads/2024/04/congress-2-nosp.jpg" 
                data-title="Policy and legislation to transform the response to trafficking" 
                data-description="When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact." 
                data-widget="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "f33fb3d0-a4f2-ee11-a81c-000d3ab699c2";
                } else {
                	echo "0fd6b57b-a2f2-ee11-a81c-000d3ab72843";
                } ?>"
                data-pdf="https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-U.S.-policy-and-advocacy.pdf"
                class="ff-appeals__grid-item ff-gsap-group-4">
                    <div class="ff-appeals__image" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/congress-2-nosp.jpg');"></div>
                    <div class="ff-appeals__gradient"></div>
                    <div class="ff-appeals__content">
                        <div class="ff-chip">USA, NATIONWIDE</div>
                        <div class="ff-appeals__red-chip">Urgent appeal</div>
                        <h3>
                            Policy and legislation to transform the response to trafficking<span>&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>

                        </h3>

                    </div>
                </div>

                <div
                data-image="https://hopeforjustice.org/wp-content/uploads/2024/04/ff-outreach-nosp.jpg" 
                data-title="Outreach and protection for vulnerable youth" 
                data-description="When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact." 
                data-widget="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "4331d5a7-a4f2-ee11-a81c-002248a02917";
                } else {
                	echo "1b04092d-a2f2-ee11-a81c-002248a02917";
                } ?>"
                data-pdf="https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-Outreach-victims-advocacy-and-training-in-Middle-Tennessee.pdf" 
                class="ff-appeals__grid-item ff-gsap-group-4">
                    <div class="ff-appeals__image" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/ff-outreach-nosp.jpg');"></div>
                    <div class="ff-appeals__gradient"></div>
                    <div class="ff-appeals__content">
                        <div class="ff-chip">USA, MIDDLE TENNESSEE</div>
                        <div class="ff-appeals__red-chip">Urgent appeal</div>
                        <h3>
                            Outreach and protection for vulnerable youth<span>&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>

                        </h3>

                    </div>
            </div>

            <div
                data-image="https://hopeforjustice.org/wp-content/uploads/2024/04/ff-sodo-nosp.jpg" 
                data-title="Safe shelter and care for children at our Lighthouse" 
                data-description="When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact." 
                data-widget="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "55c680d7-a3f2-ee11-a81c-002248a02917";
                } else {
                	echo "8b547a54-a1f2-ee11-a81c-000d3ab699c2";
                } ?>"
                data-pdf="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-U.S.-Ethiopia-Lighthouse.pdf";
                } else {
                	echo "https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-UK-Ethiopia-Lighthouse.pdf";
                } ?>"
                class="ff-appeals__grid-item ff-gsap-group-4">
                    <div class="ff-appeals__image" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/ff-sodo-nosp.jpg');"></div>
                    <div class="ff-appeals__gradient"></div>
                    <div class="ff-appeals__content">
                        <div class="ff-chip">ETHIOPIA, NATIONWIDE</div>
                        <div class="ff-appeals__red-chip">Urgent appeal</div>
                        <h3>
                            Safe shelter and care for children at our Lighthouse <span>&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>

                        </h3>

                    </div>
                </div>

                <div
                data-image="https://hopeforjustice.org/wp-content/uploads/2024/04/ff-interview-nosp.jpg" 
                data-title="Victim identification and ongoing support" 
                data-description="When you fund a project through Hope for Justice’s Freedom Foundation, you know your generosity is going directly where you want it and will have an immediate impact." 
                data-widget="<?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "40e9b55e-a4f2-ee11-a81c-000d3ab699c2";
                } else {
                	echo "031a77e8-a1f2-ee11-a81c-000d3ab72843";
                } ?>"
                data-pdf="https://hopeforjustice.org/wp-content/uploads/2024/04/Hope-for-Justice-Freedom-Foundation-Victim-identification-and-support-in-the-Midwest.pdf"
                class="ff-appeals__grid-item ff-gsap-group-4">
                    <div class="ff-appeals__image" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/ff-interview-nosp.jpg');"></div>
                    <div class="ff-appeals__gradient"></div>
                    <div class="ff-appeals__content">
                        <div class="ff-chip">USA, MIDWEST</div>
                        <div class="ff-appeals__red-chip">Urgent appeal</div>
                        <h3>
                            Victim identification and ongoing support<span>&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                            	"/assets/img/link-arrow.svg"; ?>"></span>

                        </h3>

                    </div>
                </div>
            </div>

        </div>

        <div class="ff-updates">
            <div class="better-grid">
                <h2 class="ff-updates__title ff-gsap-group-5">
                    Tailored updates
                </h2>
                <p class="ff-updates__text ff-gsap-group-5">
                    You will receive updates on the impact of your gift and the progress of your chosen project. You or your organization will also receive a public thank you on this website as a project investor (or you may remain anonymous if you prefer). Most importantly, you will have made an amazing contribution to the cause of ending modern-day slavery and human trafficking.
                </p>
            </div>
        </div>

        <div class="ff-contact">
            <div class="better-grid">
                <div class="ff-contact__image ff-gsap-group-6" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2024/04/ff-addis-nosp.jpg');"></div>
                <div class="ff-contact__form ff-blur ff-gsap-group-6">
                    <h2>Get in touch</h2>
                    <p>
                        Any questions about the Freedom Foundation or any of the projects above? Or maybe you want to give via a different method to those shown above? Leave your message below and one of our friendly team will contact you shortly.
                    </p>
                    <div class="ff-contact__form-container">
                        <?php echo do_shortcode(
                        	'[gravityform id="58" title="false"]'
                        ); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>


</main>

<div class="ff-popup">
    <div class="ff-popup__backdrop ff-blur">
    </div>
    <div class="ff-popup__scroll-container">
        <div class="ff-popup__content">
            <div class="ff-popup__close">
                <svg xmlns="http://www.w3.org/2000/svg" width="12.414" height="12.414" viewBox="0 0 12.414 12.414">
                    <line id="Line_499" data-name="Line 499" x1="11" y2="11" transform="translate(0.707 0.707)" fill="none" stroke="#1e201f" stroke-width="2" />
                    <line id="Line_500" data-name="Line 500" x1="11" y1="11" transform="translate(0.707 0.707)" fill="none" stroke="#1e201f" stroke-width="2" />
                </svg>
            </div>
            <div class="ff-popup__circle"></div>
            <h3 class="ff-popup__title"></h3>

            <p class="ff-popup__desc">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut</p>
            <a href="#" target="_blank" class="button ff-popup__pdf-button">Project details (PDF)</a>
            <div class="ff-popup__donate <?php if ($country === "USA") {
            	echo "ff-popup__donate--us";
            } ?>">
                <label for="amount">Enter an amount to donate</label>
                <input id="donateAmount" type="number" name="amount" id="amount" value="5000">
                <p id="errors" class="ff-popup__errors"></p>
            </div>
            
            <div class="ff-popup__donate-btn" id="ff-donate">Donate to this appeal</div>
            <div class="ff-popup__line"></div>
            <div class="ff-popup__footer">
                <p>The minimum contribution via the Freedom Foundation is <?php if (
                	$GLOBALS["userInfo"] &&
                	in_array($GLOBALS["userInfo"], $GLOBALS["usa"])
                ) {
                	echo "$";
                } else {
                	echo "£";
                } ?>1,000. To give a smaller amount head to <a href="https://hfj.org/donate">hfj.org/donate</a>. Any donations received above this project’s budget will be relocated to other Hope for Justice projects and costs around the world in the service of our mission to end modern-day slavery. </p>
            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
