import { useBlockProps } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import type { BlockEditProps } from '@wordpress/blocks';

interface Attributes {
    content: string;
}

const Edit: React.FC<BlockEditProps<Attributes>> = ({ attributes, setAttributes }) => {
    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <TextControl
                label="Block Content"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
            />
        </div>
    );
};

export default Edit;
