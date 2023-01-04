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
    var initializeDropdown = function ($block) {

        $($block).click(function () {
            $(this).find('.dropdown-block__content').toggleClass('dropdown-block__content--open');
            $(this).find('.dropdown-block__arrow').toggleClass('dropdown-block__arrow--open');
            console.log('toggled');
        });
    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        $('.dropdown-block').each(function () {
            initializeDropdown($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=dropdown', initializeDropdown);
    }

})(jQuery);