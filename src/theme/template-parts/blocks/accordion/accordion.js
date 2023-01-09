(function ($) {

    /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */
    var initializeAccordion = function ($block) {

        $($block).children('.accordion-block__accordion').click(function () {
            $(this).find('.accordion-block__content').toggleClass('accordion-block__content--open');
            $(this).find('.accordion-block__arrow').toggleClass('accordion-block__arrow--open');
            console.log('toggled');
        });
    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        $('.accordion-block').each(function () {
            initializeAccordion($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    // if (window.acf) {
    //     window.acf.addAction('render_block_preview/type=accordion', initializeAccordion);
    // }

})(jQuery);