# WordPress Modern Block Plugin

A WordPress plugin featuring custom **Gutenberg blocks** built with modern PHP practices — namespaces, Composer autoloading, and class-based architecture. This project demonstrates that writing WordPress code the right way in 2025 means classes, not 2000-line `functions.php` files.

## ✨ Features

- Namespace-scoped PHP classes under `src/`
- **Composer** autoloading (`composer.json`)
- Custom Gutenberg block with `block.json` + JSX (`edit` / `save`)
- Build tooling via **`@wordpress/scripts`** (webpack)
- Practical example block: CTA Button with configurable color and text
- Inline **PHPDoc** comments throughout
- **GitHub Actions** workflow running PHP_CodeSniffer (WPCS)

## 🛠 Tech Stack

| Area | Technology |
|------|-----------|
| Backend | PHP 8.1+ (OOP, namespaces) |
| Dependency Management | Composer |
| Block Editor | Gutenberg / WordPress Block API |
| Frontend (Block) | React, JSX, @wordpress/scripts |
| Build Tool | webpack (via @wordpress/scripts) |
| Code Quality | PHP_CodeSniffer + WordPress Coding Standards |
| CI | GitHub Actions |

## 🚀 Getting Started

### Prerequisites

- PHP 8.1+
- Composer
- Node.js 18+
- WordPress 6.0+ installation

### Installation

```bash
git clone https://github.com/YOSHl/wp-modern-block-plugin.git
cd wp-modern-block-plugin

# Install PHP dependencies
composer install

# Install JS dependencies and build assets
npm install
npm run build
```

Copy or symlink the plugin folder into your WordPress `wp-content/plugins/` directory, then activate it from the WordPress admin.

### Development

```bash
npm run start   # watch mode
```

## 📁 Project Structure

```
wp-modern-block-plugin/
├── src/                        # PHP source (PSR-4 autoloaded)
│   └── Blocks/
│       └── CtaBlock.php        # Block registration class
├── blocks/
│   └── cta-button/
│       ├── block.json          # Block metadata
│       ├── edit.jsx            # Editor component
│       ├── save.jsx            # Frontend render
│       └── style.scss          # Block styles
├── composer.json
├── package.json
├── webpack.config.js
└── plugin.php                  # Plugin entry point
```

## 🔑 Keywords

`PHP OOP` · `Composer` · `Gutenberg` · `WordPress Plugin Development` · `@wordpress/scripts` · `GitHub Actions` · `WordPress Coding Standards`

## 👨‍💻 Development

This project was developed with **Claude Code** (Anthropic). AI-assisted development was used to scaffold the plugin structure, implement block components, and configure the CI pipeline.

---

## 日本語

namespace・Composerオートロード・クラス設計で書いたWordPressカスタムブロックプラグインです。

### このプロジェクトについて

14年のWordPress経験を「古い書き方」ではなく「今の書き方」で示すためのプロジェクトです。「2000行の`functions.php`ではなくクラスで書く」というモダンPHPのアプローチを実証します。

### 技術構成

| 分野 | 技術 |
|------|------|
| バックエンド | PHP 8.1+（OOP、namespace）|
| 依存関係管理 | Composer |
| ブロックエディター | Gutenberg / WordPress Block API |
| フロントエンド（ブロック）| React、JSX、@wordpress/scripts |
| ビルドツール | webpack（@wordpress/scripts経由）|
| コード品質 | PHP_CodeSniffer + WordPress Coding Standards |
| CI | GitHub Actions |

### セットアップ

```bash
git clone https://github.com/YOSHl/wp-modern-block-plugin.git
cd wp-modern-block-plugin

# PHP依存関係のインストール
composer install

# JSビルド
npm install
npm run build
```

プラグインフォルダをWordPressの`wp-content/plugins/`に配置し、管理画面から有効化してください。

### 開発について

このプロジェクトは **Claude Code**（Anthropic）を活用して開発しました。プラグイン構成のスキャフォールド・ブロックコンポーネントの実装・CIパイプラインの設定にAIアシスト開発を採用しています。
