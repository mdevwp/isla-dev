import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';

// Добавляем новый вариант уровня заголовка
const extendHeadingBlock = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        if (props.name !== 'core/heading') {
            return <BlockEdit {...props} />;
        }

        const { attributes, setAttributes } = props;
        const { level } = attributes;

        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <SelectControl
                        label="Уровень заголовка"
                        value={level}
                        options={[
                            { label: 'H1', value: 1 },
                            { label: 'H2', value: 2 },
                            { label: 'H3', value: 3 },
                            { label: 'H4', value: 4 },
                            { label: 'H5', value: 5 },
                            { label: 'H6', value: 6 },
                            { label: 'H7', value: 7 }, // Добавляем H7
                        ]}
                        onChange={(newLevel) =>
                            setAttributes({ level: Number(newLevel) })
                        }
                    />
                </InspectorControls>
            </Fragment>
        );
    };
}, 'extendHeadingBlock');

// Применяем фильтр для изменения блока
addFilter(
    'editor.BlockEdit',
    'my-plugin/extend-heading-block',
    extendHeadingBlock
);
