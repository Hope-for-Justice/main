const { createHigherOrderComponent } = wp.compose;

//////////// paragraph block edits ////////////////////

//save
function wrapParagraphBlockInContainer(element, blockType, attributes) {
    // skip if element is undefined
    if (!element) {
        return;
    }

    // only apply to p blocks
    if (blockType.name !== 'core/paragraph') {
        return element;
    }

    // return the element wrapped in a div
    return <div className="better-grid hfj-block block-text core-paragraph">{element}</div>;
}

wp.hooks.addFilter(
    'blocks.getSaveElement',
    'my-plugin/wrap-p-block-in-container',
    wrapParagraphBlockInContainer
);

//edit
const paragraphWithWrapper = createHigherOrderComponent(
    (BlockListBlock) => {
        return (props) => {

            if (props.name !== "core/paragraph") {
                return <BlockListBlock {...props} />;
            }

            return (
                <div className="better-grid hfj-block block-text core-paragraph">
                    <BlockListBlock {...props} className={'block-indent-' + props.attributes.indent} />
                </div>
            );
        };
    },
    'paragraphWithWrapper'
);

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'guten-edits/paragraphWithWrapper',
    paragraphWithWrapper
);

//styles
wp.blocks.registerBlockStyle('core/paragraph', {
    name: 'no-mb',
    label: 'No margin bottom',
});

//////////// end paragraph block edits ////////////////////

//////////// list block edits ////////////////////

//save
function wraplistBlockInContainer(element, blockType, attributes) {
    // skip if element is undefined
    if (!element) {
        return;
    }

    // only apply to p blocks
    if (blockType.name !== 'core/list') {
        return element;
    }

    // return the element wrapped in a div
    return <div className="better-grid hfj-block block-text core-list">{element}</div>;
}

wp.hooks.addFilter(
    'blocks.getSaveElement',
    'my-plugin/wrap-p-block-in-container',
    wraplistBlockInContainer
);

//edit
const listWithWrapper = createHigherOrderComponent(
    (BlockListBlock) => {
        return (props) => {

            if (props.name !== "core/list") {
                return <BlockListBlock {...props} />;
            }

            return (
                <div className="better-grid hfj-block block-text core-list">
                    <BlockListBlock {...props} className={'block-indent-' + props.attributes.indent} />
                </div>
            );
        };
    },
    'listWithWrapper'
);

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'guten-edits/listWithWrapper',
    listWithWrapper
);

//styles
wp.blocks.registerBlockStyle('core/list', {
    name: 'no-mb',
    label: 'No margin bottom',
});

//////////// end list block edits ////////////////////

//////////// pull quote block edits ////////////////////

//save
function wrapPullQuoteBlockInContainer(element, blockType, attributes) {
    // skip if element is undefined
    if (!element) {
        return;
    }

    // only apply to p blocks
    if (blockType.name !== 'core/pullquote') {
        return element;

    }

    // return the element wrapped in a div
    return <div className="better-grid hfj-block block-text core-pull-quote">{element}</div>;
}

wp.hooks.addFilter(
    'blocks.getSaveElement',
    'my-plugin/wrapPullQuoteBlockInContainer',
    wrapPullQuoteBlockInContainer
);

//edit
const pullQuoteWithWrapper = createHigherOrderComponent(
    (BlockListBlock) => {
        return (props) => {

            if (props.name !== "core/pullquote") {
                return <BlockListBlock {...props} />;
            }

            return (
                <div className="better-grid hfj-block block-text core-pull-quote">
                    <BlockListBlock {...props} className={'block-indent-' + props.attributes.indent} />
                </div>
            );
        };
    },
    'pullQuoteWithWrapper'
);

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'guten-edits/pullQuoteWithWrapper',
    pullQuoteWithWrapper
);

//styles


//////////// end pull quote block edits ////////////////////

//////////// heading block edits ////////////////////

//save
function wrapHeadingBlockInContainer(element, blockType, attributes) {
    // skip if element is undefined
    if (!element) {
        return;
    }

    // only apply to heading blocks
    if (blockType.name !== 'core/heading') {
        return element;
    }

    // return the element wrapped in a div
    return <div className="better-grid hfj-block core-heading">{element}</div>;
}

wp.hooks.addFilter(
    'blocks.getSaveElement',
    'my-plugin/wrap-heading-block-in-container',
    wrapHeadingBlockInContainer
);

//edit
const headingWithWrapper = createHigherOrderComponent(
    (BlockListBlock) => {
        return (props) => {

            if (props.name !== "core/heading") {
                return <BlockListBlock {...props} />;
            }

            return (
                <div className="better-grid hfj-block core-heading">
                    <BlockListBlock {...props} className={'block-indent-' + props.attributes.indent} />
                </div>
            );
        };
    },
    'headingWithWrapper'
);

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'guten-edits/headingWithWrapper',
    headingWithWrapper
);

//////////// end heading block edits ////////////////////

//////////// add attributes ////////////////////

/**
 * External Dependencies
 */
import classnames from 'classnames';

/**
 * WordPress Dependencies
 */
const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { Fragment } = wp.element;
const { InspectorAdvancedControls } = wp.editor;
const { ToggleControl } = wp.components;

//restrict to specific block names
const allowedBlocks = ['core/paragraph', 'core/heading', 'core/list', 'core/pullquote'];

/**
 * Add custom attribute for indent
 *
 * @param {Object} settings Settings for the block.
 *
 * @return {Object} settings Modified settings.
 */
function addAttributes(settings) {

    //check if object exists for old Gutenberg version compatibility
    //add allowedBlocks restriction
    if (typeof settings.attributes !== 'undefined' && allowedBlocks.includes(settings.name)) {

        settings.attributes = Object.assign(settings.attributes, {
            indent: {
                type: 'boolean',
                default: false,
            }
        });

    }

    return settings;
}

/**
 * Add mobile visibility controls on Advanced Block Panel.
 *
 * @param {function} BlockEdit Block edit component.
 *
 * @return {function} BlockEdit Modified block edit component.
 */
const withAdvancedControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {

        const {
            name,
            attributes,
            setAttributes,
            isSelected,
        } = props;

        const {
            indent,
        } = attributes;


        return (
            <Fragment>
                <BlockEdit {...props} />
                {isSelected && allowedBlocks.includes(name) &&
                    <InspectorAdvancedControls>
                        <ToggleControl
                            label={__('Indent')}
                            checked={!!indent}
                            onChange={() => setAttributes({ indent: !indent })}
                            help={!!indent ? __('Indented') : __('Not indented')}
                        />
                    </InspectorAdvancedControls>
                }

            </Fragment>
        );
    };
}, 'withAdvancedControls');

/**
 * Add custom element class in save element.
 *
 * @param {Object} extraProps     Block element.
 * @param {Object} blockType      Blocks object.
 * @param {Object} attributes     Blocks attributes.
 *
 * @return {Object} extraProps Modified block element.
 */
function applyExtraClass(extraProps, blockType, attributes) {

    const { indent } = attributes;

    //check if attribute exists for old Gutenberg version compatibility
    //add class 
    //add allowedBlocks restriction
    if (typeof indent !== 'undefined' && indent && allowedBlocks.includes(blockType.name)) {
        extraProps.className = classnames(extraProps.className, 'block-indent');
    }

    return extraProps;
}

//add filters

addFilter(
    'blocks.registerBlockType',
    'editorskit/custom-attributes',
    addAttributes
);

addFilter(
    'editor.BlockEdit',
    'editorskit/custom-advanced-control',
    withAdvancedControls
);

addFilter(
    'blocks.getSaveContent.extraProps',
    'editorskit/applyExtraClass',
    applyExtraClass
);

//styles
wp.blocks.registerBlockStyle('core/heading', [
    {
        name: 'canela',
        label: 'Canela',
        isDefault: true,
    },
    {
        name: 'apercu',
        label: 'Apercu',
    },
    {
        name: 'fk-screamer',
        label: 'FK Screamer',
    }
]);

wp.blocks.registerBlockStyle(
    'core/spacer',
    [
        {
            name: 'custom',
            label: 'Custom',
            isDefault: true,
        },
        {
            name: 'small',
            label: 'S',
        },
        {
            name: 'medium',
            label: 'M',
        },
        {
            name: 'large',
            label: 'L',
        },
        {
            name: 'x-large',
            label: 'XL',
        }
    ]
);