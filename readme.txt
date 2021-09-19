=== Vaaky Highlighter ===
Contributors: raunak01
Donate link: https://www.webhat.in/
Tags: syntax highlighter, gutenberg, blocks, snippets, highlight.js, highlighter, php, js, sourcecode, code
Requires at least: 5.0
Tested up to: 5.7.2
Requires PHP: 5.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple yet elegant syntax or code highlighter based on highlight.js. It allows you to add engaging snippet code blocks.

== Description ==

Vaaky Highlighter is a free, easy-to-use, syntax highlighting tool for WordPress. Highlighting is powered by the [Highlight.js](https://github.com/highlightjs/highlight.js) javaScript syntax highlighter with language auto-detection and zero dependencies.

Using it will be as straightforward as adding a replacement Vaaky Highlighter Sourcecode block (Gutenberg) and insert the code that you wish to highlight: Vaaky Highlighter takes care of the rest!

== Installation ==

= Minimum Requirements =

* PHP 7.2 or greater is recommended
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
- Erlang
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

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0.0 2021-06-22 =
* First public release
* Includes Highlight.js 12.2.0

[See the changelog for all versions](https://github.com/finallyRaunak/vaaky-highlighter/blob/main/CHANGELOG.md).

== Upgrade Notice ==

There isn't any upgrade notice at this point.