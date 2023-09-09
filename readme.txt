=== Vaaky Highlighter ===
Contributors: raunak01
Donate link: https://www.webhat.in/
Tags: syntax highlighter, gutenberg, blocks, snippets, highlight.js, highlighter, php, js, sourcecode, code
Requires at least: 5.0
Tested up to: 6.3.1
Requires PHP: 5.6
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple yet elegant syntax or code highlighter based on highlight.js. It allows you to add engaging snippet code blocks.

== Description ==

Vaaky Highlighter is a free, easy-to-use, syntax highlighting tool for WordPress. Highlighting is powered by the [Highlight.js](https://github.com/highlightjs/highlight.js) javaScript syntax highlighter with language auto-detection and zero dependencies.

Using it will be as straightforward as adding a replacement Vaaky Highlighter Sourcecode block (Gutenberg) and insert the code that you wish to highlight: Vaaky Highlighter takes care of the rest!

**Here is the [demo page](https://www.webhat.in/?page_id=626&utm_source=wordpress.org&utm_medium=readme.txt&utm_campaign=link&utm_id=vaaky_highlighter&utm_term=Theme+Demo) of all the supported themes.**

== Installation ==

= Minimum Requirements =

* PHP 5.6 or greater is recommended
* WordPress 5.0 or greater is recommended

= Automatic installation =

Automatic installation is that the best choice -- WordPress can handle the file transfer, and you won’t have to be compelled to leave your browser.

1. Go to "Plugins" in your WordPress dashboard
1. Click on "Add New"
1. Type "Vaaky Highlighter" in the search field
1. Click “Search Plugins.”
1. Once you’ve found us,  you can view details about it such as the point release, rating, and description. Most importantly, of course, you can install it by clicking "Install" and WordPress will take it from there.
1. Click on Activate

= Manual installation =

1. Download the plugin archive
1. Go to "Plugins" in your WordPress dashboard
1. Click on "Add New"
1. Upload Vaaky Highlighter archive
1. Activate the plugin

Having issue? Check the WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).

=== Usage ==
1. Add a Vaaky Highlighter block within your content
1. Write your code
1. Select the language (optional)
1. Save the post/page and check your in frontend

== Supported languages ==
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
- HTML
- XML
- Handlebars
- JSON
- Java
- JavaScript
- Markdown
- Nginx
- Objective C
- PHP
- Plaintext
- PostgreSQL & PL/pgSQL
- PowerShell
- Python
- R
- Ruby
- Rust
- SCSS
- SQL/MySQL
- Shell
- Twig
- TypeScript
- YAML/YML

== Frequently Asked Questions ==

= What library does this plugin use?

It uses [Highlight.js](https://github.com/highlightjs/highlight.js)

= What is the theme it supports =

Currently, it supports 25 themes out of which 16 are the dark theme which includes Monokai (Sublime), Visual Studio, GitHub Dark, Android Studio, etc. and 9 are the light themes which include Github, StackOverflow, Google Code, etc.

= How an add a language that is not supported by you but supported by highlightjs =

In that case, do not select any language from dropdown, highlightjs will auto-detect the language. If it still didn't work you can request for a [feature request](https://github.com/finallyRaunak/vaaky-highlighter/issues)

= Does it has line number =

No

= Does it support Classic Editor? If yes then how to add the code snippet? =

Yes, it will work in WordPress Classic Editor. You have to add it in the form of shortcode, like this `[vaakyHighlighterCode lang="php"] Write your code here.[/vaakyHighlighterCode]`.
If you know the abbreviation of the language then you can provide in `lang` attribute like php or js or cpp else ignore the attribute all together plugin will auto-detect the language and will highlight based on that.

== Screenshots ==

1. Plugin Settings Page
2. Visual Studio 2015 Theme: JavaScript Snippet
3. Visual Studio 2015 Theme: PHP Snippet
4. Visual Studio 2015 Theme: YAML Snippet
5. Sublime (Monokai) Theme: JavaScript Snippet
6. Sublime (Monokai) Theme: YAML Snippet
7. Sublime (Monokai) Theme: PHP Snippet with Scrollbar
8. Sublime (Monokai) Theme: PHP Snippet with Line Wrap

== Changelog ==

= 1.0.5 2023-09-09 =
* Fix - Notice: Trying to access array offset on value of type bool
* Tested and updated WordPress compatibility with new version

= 1.0.4 2023-05-05 =
* Tested and updated WordPress compatibility with new version

= 1.0.3 2022-10-26 =
* Tested and updated WordPress compatibility with new version

= 1.0.2 2022-03-20 =
* Updated Website URL
* Tested and updated WordPress compatibility with new version

= 1.0.1 2021-10-15 =
* Fix - Console warning like "Could not find the language <lang name>, did you forget to load/include a language module?".
* Fix - False warning of unescaped HTML code blocks.
* Feature - Added support for YAML/YML.
* Dev - Added demo link from where user can check all the supported theme & their look and feel.
* Fix - cmd typo with dos in ./Admin/js/gutenberg.js.
* Fix - Fatal error which was occurring in specific version of PHP.

= 1.0.0 2021-10-05 =
* First public release
* Includes Highlight.js 11.2.0

[See the changelog for all versions](https://github.com/finallyRaunak/vaaky-highlighter/blob/main/CHANGELOG.md).

== Upgrade Notice ==

There isn't any upgrade notice at this point.