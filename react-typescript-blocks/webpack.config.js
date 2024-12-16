const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
    ...defaultConfig,
    output: {
        path: path.resolve(__dirname, '../backend-wp-6/wp-content/themes/syncsystem-wp-headless/build'),
        filename: 'index.js'
    }
};
