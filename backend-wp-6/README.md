# Backend WP

## Development

### Prerequisites

Before setting up the WordPress backend, ensure you have the following installed:

#### PHP
- PHP 8.1 or higher
- Required PHP extensions:
  - `curl` - for making HTTP requests
  - `dom` - for HTML/XML handling
  - `exif` - for image metadata
  - `fileinfo` - for file type detection
  - `hash` - for data hashing
  - `json` - for JSON encoding/decoding
  - `mbstring` - for multibyte string handling
  - `mysqli` - for MySQL database connection
  - `openssl` - for cryptography
  - `pcre` - for regular expressions
  - `xml` - for XML parsing
  - `zip` - for ZIP file handling
  - `gd` or `imagick` - for image processing (at least one required)

  Optional but recommended:
  - `intl` - for internationalization
  - `sodium` - for enhanced encryption
  - `bcmath` - for arbitrary precision mathematics

  To check installed extensions:
  ```bash
  # Windows (PowerShell)
  php -m

  # MacOS/Linux
  php -m | grep -i extension_name

#### Composer
- Latest stable version of Composer

#### MySQL
##### Windows
1. Download MySQL Installer from https://dev.mysql.com/downloads/installer/
2. During installation:
   - Choose "Custom" installation
   - **Important:** Expand nested items in the component selection
   - Select:
     - MySQL Server
     - MySQL Shell
   - Complete the installation wizard
   - Note: Keep track of your root password during setup
3. Add MySQL to System PATH:
   - Open System Properties (Windows + R, type `sysdm.cpl`)
   - Go to Advanced tab → Environment Variables
   - Under System Variables, find "Path"
   - Add: `C:\Program Files\MySQL\MySQL Server 8.0\bin`
4. Verify MySQL service is running:
   - Open Services (Windows + R, type `services.msc`)
   - Find "MySQL80"
   - Or run `mysql -v` in the terminal
   - Ensure status is "Running"

##### MacOS
1. Install using Homebrew:
```bash
brew install mysql
```
2. Start MySQL service:
```bash
brew services start mysql
```

### Setup

1. Download WordPress core:
```bash
# Windows
vendor\bin\wp core download
# MacOS/Linux
vendor/bin/wp core download
```

2. Create WordPress configuration:
```bash
# Windows
vendor\bin\wp config create --dbname=your_db_name --dbuser=your_db_user --dbpass=your_db_password --dbhost=localhost
# MacOS/Linux
vendor/bin/wp config create --dbname=your_db_name --dbuser=your_db_user --dbpass=your_db_password --dbhost=localhost
```

3. Create database:
```bash
composer run -- wp db create
```

4. Install WordPress:
```bash
composer run -- wp core install --url=http://localhost:8080 --title="Headless WordPress" --admin_user=your_admin --admin_password=your_password --admin_email=your@email.com
```

5. Configure permalinks (required for REST API):
```bash
composer run -- wp rewrite structure '/%postname%/'
composer run -- wp rewrite flush
```

6. Start development server (inside WP directory):
```bash
php -S localhost:8080
```

7. Verify installation:
- Visit WordPress admin panel: `http://localhost:8080/wp-admin`
- Log in with your admin credentials
- Test REST API endpoint:
  ```bash
  # Using cURL
  curl -H "Accept: application/json" http://localhost:8080/wp-json/

  # Or using browser
  # Install ModHeader extension and add:
  # Header name: Accept
  # Header value: application/json
  ```
  Then visit: `http://localhost:8080/wp-json/`

### API Access
The WordPress REST API endpoints can be accessed in several ways:

1. Using cURL:
```bash
# Get all posts
curl -H "Accept: application/json" http://localhost:8080/wp-json/wp/v2/posts

# Get specific post
curl -H "Accept: application/json" http://localhost:8080/wp-json/wp/v2/posts/1
```

2. Using browser:
- Install ModHeader extension
- Add header: `Accept: application/json`
- Visit API endpoints in browser

3. Force JSON response by adding `.json`:
```
http://localhost:8080/wp-json/wp/v2/posts.json
```

Common endpoints:
- Posts: `/wp-json/wp/v2/posts`
- Pages: `/wp-json/wp/v2/pages`
- Media: `/wp-json/wp/v2/media`
- Categories: `/wp-json/wp/v2/categories`
- Tags: `/wp-json/wp/v2/tags`

### WP-CLI Custom Commands

#### Creating a Basic Command

1. Create the commands directory structure (if not exists):
```bash
mkdir -p src/cli/Commands
```

2. Create a new command file in `src/cli/Commands/Poc1Command.php`:
```php
<?php
namespace SyncSystem\CLI\Commands;
use WP_CLI;

/**
 * Example command for proof of concept.
 */
class Poc1Command {
    /**
     * Says hello to the specified user.
     *
     * ## OPTIONS
     *
     * <name>
     * : The name of the user
     *
     * [--greeting=<greeting>]
     * : Custom greeting to use
     * ---
     * default: Hello
     * ---
     *
     * ## EXAMPLES
     *
     *     # Basic usage
     *     $ wp poc1 hello John
     *     Hello, John!
     *
     *     # Custom greeting
     *     $ wp poc1 hello John --greeting="Hi"
     *     Hi, John!
     */
    public function hello($args, $assoc_args) {
        $name = $args[0];
        $greeting = $assoc_args['greeting'] ?? 'Hello';
        WP_CLI::success("$greeting, $name!");
    }
}

WP_CLI::add_command('poc1', 'SyncSystem\CLI\Commands\Poc1Command');
```

3. Create the mu-plugins directory (if not exists):
```bash
mkdir -p wp-content/mu-plugins
```

4. Create a loader file in `wp-content/mu-plugins/cli-commands.php`:
```php
<?php
/**
 * Plugin Name: CLI Commands Loader
 * Description: Loads custom WP-CLI commands
 */

if (defined('WP_CLI') && WP_CLI) {
    require_once dirname(dirname(__DIR__)) . '/src/cli/Commands/Poc1Command.php';
}
```

5. Ensure your `wp-cli.yml` is configured:
```yaml
path: .
```

#### Testing the Command

Run the command using:
```bash
composer run -- wp poc1 hello YourName
```

With custom greeting:
```bash
composer run -- wp poc1 hello YourName --greeting="Hi"
```

#### Command Structure Breakdown

1. **Namespace**: Commands are organized under `SyncSystem\CLI\Commands`

2. **Documentation Blocks**:
   - Main class documentation describes the command group
   - Method documentation includes:
     - Description
     - Options
     - Examples

3. **Parameters**:
   - `$args`: Array of positional arguments
   - `$assoc_args`: Array of associative arguments (--flag=value)

4. **Registration**:
   - Commands are registered using `WP_CLI::add_command()`
   - Must-Use plugin ensures commands are always available

5. **Loading**:
   - Commands are loaded automatically via mu-plugins
   - mu-plugins (Must-Use plugins) cannot be disabled in wp-admin

#### Best Practices

1. **Naming**:
   - Use descriptive command names
   - Follow WordPress coding standards
   - Keep namespace consistent

2. **Documentation**:
   - Always include detailed DocBlocks
   - Provide clear examples
   - Document all parameters

3. **Error Handling**:
   - Use `WP_CLI::error()` for failures
   - Use `WP_CLI::success()` for success messages
   - Include meaningful error messages

4. **Testing**:
   - Test with various inputs
   - Include edge cases
   - Test with and without optional parameters
