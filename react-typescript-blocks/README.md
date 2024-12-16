# SyncSystem - React/TypeScript WP Gutenberg Blocks

## Overview
This project implements custom Gutenberg blocks using React and TypeScript for a headless WordPress setup. The blocks are part of a larger monorepo structure that includes a headless WordPress backend and SlimPHP frontend.

## Prerequisites
- Node.js (LTS version)
- npm or yarn
- PHP 8.1+
- Composer 2.2+
- WordPress 6.7+
- MySQL 8.0+

## Project Structure
```plaintext
syncsystem-wp-platform-v1/
├── backend-wp-6/              # WordPress headless CMS
│   └── wp-content/
│       └── themes/
│           └── syncsystem-wp-headless/
│               ├── build/     # Compiled blocks
│               ├── style.css
│               ├── index.php
│               └── functions.php
│
└── react-typescript-blocks/   # Gutenberg blocks source
    ├── src/
    │   ├── blocks/
    │   │   └── example-block/
    │   │       ├── example-block.ts
    │   │       ├── example-block-edit.tsx
    │   │       ├── example-block-save.tsx
    │   │       └── example-block-style.scss
    │   └── index.ts
    ├── webpack.config.js
    ├── tsconfig.json
    └── package.json
```

## Installation & Setup

### Theme Setup
Create required theme files in `backend-wp-6/wp-content/themes/syncsystem-wp-headless/`:

#### style.css
```css
/*
Theme Name: SyncSystem WP Headless
Theme URI: http://localhost:8080
Description: Headless WordPress theme for SyncSystem Platform
Version: 1.0.0
Author: Your Name
Author URI: http://localhost:8080
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: syncsystem-wp-headless
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 8.1
*/
```

#### functions.php
```php
<?php
if (!defined('ABSPATH')) {
    exit;
}

function syncsystem_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'syncsystem-blocks',
        get_template_directory_uri() . '/build/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor')
    );
}
add_action('enqueue_block_editor_assets', 'syncsystem_enqueue_block_editor_assets');
```

### 3. React/TypeScript Setup
```bash
cd react-typescript-blocks
npm init -y
npm install --save-dev --prefix . @wordpress/scripts @wordpress/blocks @wordpress/block-editor @wordpress/components @wordpress/i18n typescript @types/wordpress__blocks @types/wordpress__block-editor @types/wordpress__components
```

## Development

### Starting Development Server
```bash
# Terminal 1 - WordPress Server
cd backend-wp-6
composer run --timeout=0 -- wp server --host=localhost --port=8080

# Terminal 2 - Blocks Development
cd react-typescript-blocks
npm run watch
```

### Building for Production
```bash
cd react-typescript-blocks
npm run build
```

## Common Issues & Troubleshooting

### 1. Node Modules Installation
If npm installs packages in the root directory instead of react-typescript-blocks:
```bash
npm install --save-dev --prefix . [packages]
```
The `--prefix .` flag ensures installation in the current directory.

### 2. WordPress Server Timeout
If the WP server command times out, add to composer.json:
```json
{
    "config": {
        "process-timeout": 0
    }
}
```
<!-- TODO: move this to the wp workspace -->

### 3. PowerShell Execution Policy
If encountering PowerShell execution policy errors, either:
- Use Git Bash or Command Prompt
- Or run in PowerShell as administrator:
```powershell
Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned
```

### 4. Missing Build Directory
If the build directory doesn't exist in the theme folder, create it manually:
```bash
mkdir -p ../backend-wp-6/wp-content/themes/syncsystem-wp-headless/build
```

### 5. Block Not Appearing
If your block doesn't appear in Gutenberg:
1. Check browser console for errors
2. Verify build files exist in theme's build directory
3. Ensure proper block registration in your TypeScript files
4. Check if the script is properly enqueued in functions.php

## API Access
Blocks content can be accessed via:

### REST API
```
http://localhost:8080/wp-json/wp/v2/posts
```

### GraphQL
```
http://localhost:8080/graphql
```

Example query:
```graphql
{
  posts {
    nodes {
      title
      content
    }
  }
}
```

<!-- 
Notes:
npm install --save-dev --prefix . @wordpress/scripts @wordpress/blocks @wordpress/block-editor @wordpress/components @wordpress/i18n typescript @types/wordpress__blocks @types/wordpress__block-editor @types/wordpress__components

Force delete (windows): Using PowerShell:
Remove-Item -Recurse -Force node_modules 
-->
