# Vaaky Highlighter - Changelog

### 1.2.0 &#8594; 2026-05-21

- Added - Line numbers toggle per block + global default
- Added - Floating copy-to-clipboard button on every code block
- Added - Optional filename label (rendered as a tab above the code)
- Added - Word-wrap toggle per block + global default
- Added - Visual theme picker in settings page (replaces dropdown)
- Added - Dismissible wp.org review notice (shown 7 days after activation)
- Added - PHP 7.4 activation guard with admin notice
- Changed - Migrated build toolchain to `@wordpress/scripts` (webpack 5, modern babel)
- Changed - Block now registered via `block.json` (apiVersion 3)
- Changed - Minimum PHP: 5.6 → 7.4
- Changed - Minimum WordPress: 6.0 → 6.5
- Changed - Author metadata updated to `techunfiltered.dev`
- Changed - Twitter link replaced with X (`@__RaunakGupta`)
- Changed - Go language slug normalized from `golang` to `go` (existing `golang` content was already broken; new value enables proper highlighting)
- Removed - Facebook social link in admin sidebar
- Removed - `webpack.config.js` (covered by `@wordpress/scripts` defaults)
- Removed - `Admin/js/gutenberg.js` (replaced by `build/index.js`)
- Removed - Dead code: `SettingsBase::whoAmI()` and `Settings::inputApperanceCallback()`
- Security - Fixed reflected XSS in admin sidebar where `$_SERVER['HTTP_HOST']` was echoed unescaped into two UTM parameters
- Security - Added `rel="noopener noreferrer"` to all external links in admin sidebar

### 1.1.0 &#8594; 2026-01-10

- Changed - Updated WordPress compatibility to 6.9
- Changed - Upgraded Highlight.js from v11.2.0 to v11.11.1
- Changed - Added support for 24 additional languages (Bash, C, C#, C++, CSS, Go, HTML/XML, JSON, Java, JavaScript, Markdown, Objective C, PHP, Plaintext, Python, R, Ruby, Rust, SCSS, SQL/MySQL, Shell, TypeScript, YAML)
- Changed - Added 6 new themes: Tokyo Night Dark/Light, Rose Pine (3 variants), Nord
- Changed - Updated all 24 existing themes to v11.11.1
- Fix - WordPress.org compatibility warning for recent WordPress versions

### 1.0.6 &#8594; 2024-01-01

- Fix - declare $settingOptionGroup in Settings.php to silence deprecated message [6457d69](https://github.com/finallyRaunak/vaaky-highlighter/commit/6457d698f091e2c8cbdf76896004875a561f988c)
- Tested and updated WordPress compatibility with new version

### 1.0.5 &#8594; 2023-09-09

- Fix - Notice: Trying to access array offset on value of type bool
- Tested and updated WordPress compatibility with new version

### 1.0.4 &#8594; 2023-05-05

- Tested and updated WordPress compatibility with new version

### 1.0.3 &#8594; 2022-10-26

- Tested and updated WordPress compatibility with new version

### 1.0.2 &#8594; 2022-03-20

- Updated Website URL
- Tested and updated WordPress compatibility with new version

### 1.0.1 &#8594; 2021-10-15

- Fix - Console warning like "Could not find the language <lang name>, did you forget to load/include a language module?".
- Fix - False warning of unescaped HTML code blocks.
- Feature - Added support for YAML/YML.
- Dev - Added demo link from where user can check all the supported theme & their look and feel.
- Fix - cmd typo with dos in ./Admin/js/gutenberg.js.
- Fix - Fatal error which was occurring in specific version of PHP.

### 1.0.0 &#8594; 2021-10-05

- First public release
- Includes Highlight.js 11.2.0