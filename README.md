# wp-modern-block-plugin

A WordPress plugin with custom Gutenberg blocks, written with namespaces, Composer autoloading, and class-based PHP. No procedural code dumped into `functions.php`.

The plugin registers a CTA button block as a working example — configurable color and text via the block editor sidebar.

## Stack

- PHP 8.1+ with PSR-4 namespaces
- Composer (autoloading)
- Gutenberg block API (`block.json` + JSX)
- `@wordpress/scripts` for builds
- PHP_CodeSniffer + WordPress Coding Standards
- GitHub Actions (WPCS check on every PR)

## Setup

```bash
git clone https://github.com/YOSHl/wp-modern-block-plugin.git
cd wp-modern-block-plugin

composer install
npm install && npm run build
```

Copy the plugin folder to `wp-content/plugins/` and activate from the WordPress admin.

For development:

```bash
npm run start   # watch mode
```

## Project structure

```
src/
  Blocks/
    CtaBlock.php        # block registration
blocks/
  cta-button/
    block.json
    edit.jsx
    save.jsx
    style.scss
composer.json
package.json
plugin.php
```

## CI

On every pull request, GitHub Actions runs PHP_CodeSniffer against WordPress Coding Standards. The workflow file is at `.github/workflows/phpcs.yml`.

---

## 日本語

namespace・Composerオートロード・クラス設計で書いたWordPressカスタムブロックプラグインです。

`functions.php` に手続き的なコードを書くのではなく、現代的なPHPの書き方（PSR-4 namespace・クラスベース）でWordPress開発をするとどうなるかを示すサンプルです。

CTAボタンブロックを実装例として含んでいます（ブロックエディターのサイドバーから色とテキストを設定可能）。

### セットアップ

```bash
git clone https://github.com/YOSHl/wp-modern-block-plugin.git
cd wp-modern-block-plugin

composer install
npm install && npm run build
```

`wp-content/plugins/` にコピーして、WordPress管理画面から有効化してください。

### CI

PRを出すたびにGitHub ActionsがWordPress Coding StandardsでPHPCSチェックを実行します。
