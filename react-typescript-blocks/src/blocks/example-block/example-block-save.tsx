import { useBlockProps } from '@wordpress/block-editor';
import type { BlockSaveProps } from '@wordpress/blocks';

interface Attributes {
    content: string;
}

const Save: React.FC<BlockSaveProps<Attributes>> = ({ attributes }) => {
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
            <p>{attributes.content}</p>
        </div>
    );
};

export default Save;
