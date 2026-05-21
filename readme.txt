=== Vaaky Highlighter - Syntax Highlighter for Gutenberg ===
Contributors: raunak01
Donate link: https://www.webhat.in/
Tags: syntax highlighter, highlight.js, code blocks, gutenberg, snippets
Requires at least: 6.5
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lightweight syntax highlighter plugin for WordPress Gutenberg powered by Highlight.js. Add beautiful, fast, and responsive code blocks with ease.

== Description ==

Vaaky Highlighter is a lightweight **syntax highlighter plugin for WordPress Gutenberg**.
It allows you to add clean, readable, and visually appealing **code blocks and code snippets** with automatic language detection.

Syntax highlighting is powered by **Highlight.js**, a fast and dependency-free JavaScript library that supports multiple programming languages and themes.

Vaaky Highlighter is ideal for **developers, bloggers, technical writers, and documentation sites** who want elegant syntax-highlighted code without unnecessary bloat.

Using it is simple: add the **Vaaky Highlighter Sourcecode block** in Gutenberg, paste your code, and publish — the plugin handles everything automatically.

**View the live demo of all supported themes:**
[Demo Page](https://www.webhat.in/?page_id=626&utm_source=wordpress.org&utm_medium=readme.txt&utm_campaign=link&utm_id=vaaky_highlighter&utm_term=Theme+Demo)

== Installation ==

= Minimum Requirements =

* WordPress 6.0 or higher
* PHP 5.6 or higher

= Automatic Installation =

1. Go to **Plugins → Add New** in your WordPress dashboard
2. Search for **Vaaky Highlighter**
3. Click **Install Now**
4. Activate the plugin

= Manual Installation =

1. Download the plugin ZIP file
2. Go to **Plugins → Add New**
3. Click **Upload Plugin**
4. Upload the ZIP file and activate

For help, see the official WordPress guide:
https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation

== Usage ==

1. Add the **Vaaky Highlighter** block in the Gutenberg editor
2. Paste or write your code
3. Select a language (optional)
4. Save and view your page on the frontend

== Supported Languages ==

- Apache
- Bash
- C
- C#
- C++
- CSS
- DNS Zone file
- DOS
- Django
- Dockerfile
- Go
- HTML / XML
- Handlebars
- JSON
- Java
- JavaScript
- Markdown
- Nginx
- Objective-C
- PHP
- Plaintext
- PostgreSQL & PL/pgSQL
- PowerShell
- Python
- R
- Ruby
- Rust
- SCSS
- SQL / MySQL
- Shell
- Twig
- TypeScript
- YAML / YML

== Frequently Asked Questions ==

= Does Vaaky Highlighter work with Gutenberg? =

Yes. Vaaky Highlighter is built specifically for the Gutenberg block editor and integrates seamlessly as a custom code block.

= Which syntax highlighting library does this plugin use? =

Vaaky Highlighter uses **Highlight.js** with automatic language detection.

= What themes are supported? =

The plugin supports **30 syntax highlighting themes**, including:

Dark themes:
Monokai (Sublime), Visual Studio 2015, GitHub Dark, Android Studio, Tokyo Night Dark, Rose Pine, Nord

Light themes:
GitHub, StackOverflow Light, Google Code, Tokyo Night Light, Rose Pine Dawn

= How can I highlight a language that is not listed? =

Leave the language selection empty. Highlight.js will automatically detect the language.
If detection fails, you can request support via GitHub:
https://github.com/finallyRaunak/vaaky-highlighter/issues

= Does the plugin support line numbers? =

No, line numbers are not supported at this time.

= Does Vaaky Highlighter work with the Classic Editor? =

Yes. You can use the shortcode:

`[vaakyHighlighterCode lang="php"]Your code here[/vaakyHighlighterCode]`

The `lang` attribute is optional. If omitted, the language will be auto-detected.

== Screenshots ==

1. Gutenberg syntax highlighter block
2. Visual Studio 2015 theme - JavaScript code snippet
3. Visual Studio 2015 theme - PHP code snippet
4. Visual Studio 2015 theme - YAML code snippet
5. Monokai (Sublime) theme - JavaScript code snippet
6. Monokai (Sublime) theme - YAML code snippet
7. Monokai (Sublime) theme - PHP snippet with scrollbar
8. Monokai (Sublime) theme - PHP snippet with line wrapping

== Changelog ==

= 1.1.0 - 2026-01-10 =
* Updated WordPress compatibility to 6.9
* Upgraded Highlight.js from v11.2.0 to v11.11.1
* Added support for 24 additional languages
* Added new themes: Tokyo Night, Rose Pine, Nord
* Updated all existing themes
* Fixed WordPress.org compatibility warnings

= 1.0.6 - 2024-01-01 =
* Fixed deprecated settings notice
* Tested with latest WordPress version

[See the changelog for all versions](https://github.com/finallyRaunak/vaaky-highlighter/blob/main/CHANGELOG.md).

== Upgrade Notice ==

No special upgrade steps are required.