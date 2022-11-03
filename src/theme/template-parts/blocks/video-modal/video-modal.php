<?php if (is_admin()) echo '<p>Invisible block: Video modal</p>' ?>

<div style="display: none;" class="modal modal--video fade" id="video-modal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal__dialog modal__dialog--video">
        <div class="modal__content modal__content--video video-container">
            <iframe class="video" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

            <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--video">&times;<span class="accessibility">Close</span></a>

        </div>
    </div>
</div>