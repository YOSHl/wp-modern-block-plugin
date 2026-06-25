# wp-modern-block-plugin

A WordPress plugin that adds a Table of Contents block to the Gutenberg editor. Headings in the post are detected automatically, and the TOC updates live as you write.

<!-- screenshot or GIF here -->

## How it works

- The block reads heading blocks (H2 / H3 / H4) in the current post and lists them in the editor in real time
- On the frontend, PHP parses the saved content to render the TOC and inject anchor `id` attributes into the headings — no client-side JavaScript required for the output
- Heading levels and the title text are configurable from the block sidebar

## Stack

| Layer | Technology |
|---|---|
| PHP | 8.1+, namespaces, class-based design |
| Block editor | `block.json` + JSX (`@wordpress/scripts`) |
| Linting | PHP_CodeSniffer + WordPress Coding Standards |
| CI | GitHub Actions runs PHPCS on every PR |

## Setup

```bash
git clone https://github.com/moriyama-dev/wp-modern-block-plugin.git
cd wp-modern-block-plugin

composer install
npm install && npm run build
```

Copy the plugin folder to `wp-content/plugins/` and activate from the WordPress admin.

For local development:

```bash
npm run start   # watch mode with hot reload
```

## Project structure

```
php/
  Blocks/
    class-tocblock.php       # block registration + server-side render
  Parser/
    class-headingparser.php  # heading extraction and anchor injection
src/
  index.js                   # block registration (JS)
  edit.js                    # Gutenberg editor component
  style.scss                 # frontend + editor styles
block.json                   # block metadata and attributes
plugin.php
```

## CI

On every pull request, GitHub Actions checks all PHP against WordPress Coding Standards.

---

## 日本語

WordPressのGutenbergエディターに「目次」ブロックを追加するプラグインです。

記事内の見出しブロック（H2 / H3 / H4）を自動で検出し、目次を生成します。エディター上ではリアルタイムでプレビューが更新され、フロントエンドはPHPによるサーバーサイドレンダリングで動作します（フロントエンド側にJavaScriptは不要）。

### セットアップ

```bash
composer install
npm install && npm run build
```

`wp-content/plugins/` にコピーして管理画面から有効化してください。
