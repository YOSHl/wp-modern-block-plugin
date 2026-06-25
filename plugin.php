<?php
/**
 * Plugin Name: Modern Block Plugin
 * Description: A custom Gutenberg block that generates a table of contents from the headings in a post.
 * Version:     1.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.1
 * Author:      moriyama-dev
 * License:     GPL-2.0-or-later
 * Text Domain: wp-modern-block-plugin
 *
 * @package WpModernBlockPlugin
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

add_action(
	'init',
	static function (): void {
		$parser = new WpModernBlockPlugin\Parser\HeadingParser();
		$block  = new WpModernBlockPlugin\Blocks\TocBlock( $parser );
		$block->register();
	}
);
