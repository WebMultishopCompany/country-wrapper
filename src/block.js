const { registerBlockType } = wp.blocks;
const { InspectorControls, InnerBlocks } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;
const { __ } = wp.i18n;

registerBlockType('cw/country-wrapper', {
    title: __('Country Wrapper', 'country-wrapper-block'),
    category: 'common',
    attributes: {
        region: {
            type: 'string',
    default: 'global'
        }
    },
    edit: (props) => {
        const { attributes: { region }, setAttributes } = props;

        return (
            <div>
                <InspectorControls>
                    <PanelBody title={ __('Settings', 'country-wrapper-block') }>
                        <SelectControl
                        label={ __('Region', 'country-wrapper-block') }
                        value={ region }
                        options={ [
                            { label: __('Latvia', 'country-wrapper-block'), value: 'lv' },
                            { label: __('CIS Countries', 'country-wrapper-block'), value: 'cis' },
                            { label: __('Global', 'country-wrapper-block'), value: 'global' },
                        ] }
                        onChange={ (newRegion) => setAttributes({ region: newRegion }) }
                        />
                    </PanelBody>
                </InspectorControls>
                <div className="cw-country-wrapper">
                    <InnerBlocks />
                </div>
            </div>
        );
    },
    save: () => {
        return (
            <div className="cw-country-wrapper">
                <InnerBlocks.Content />
            </div>
        );
    }
});
