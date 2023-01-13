/* Page load scripts */
jQuery(document).ready(function ($) {//cards
    Draggable.create(".drag-cards__inner", {
        allowNativeTouchScrolling: false,
        type: "x",
        bounds: { maxX: 0 }, //keeps it left drag only
        onRelease: function () {
            TweenLite.set(this.target, { zIndex: 0 });
        }
    });
});