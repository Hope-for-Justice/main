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
    var initializeBlockDropdown = function ($block) {

        $('.block-card--dropdown').click(function () {
            $(this).toggleClass('block-card--dropdown-active');
            console.log('toggled');
        });
    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        $('.block-card--dropdown').click(function () {
            $(this).toggleClass('block-card--dropdown-active');
            console.log('toggled');
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=cards-quarter', initializeBlockDropdown);
    }

})(jQuery);
