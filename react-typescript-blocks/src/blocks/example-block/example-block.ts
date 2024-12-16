import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './example-block-edit';
import Save from './example-block-save';

registerBlockType('syncsystem/example-block', {
    title: __('Example Block', 'syncsystem'),
    description: __('A sample block using TypeScript', 'syncsystem'),
    category: 'common',
    icon: 'smiley',
    supports: {
        html: false
    },
    attributes: {
        content: {
            type: 'string',
            default: ''
        }
    },
    edit: Edit,
    save: Save,
});
