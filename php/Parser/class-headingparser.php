<?php
/**
 * Heading parser for the table of contents block.
 *
 * @package WpModernBlockPlugin\Parser
 */

declare(strict_types=1);

namespace WpModernBlockPlugin\Parser;

/**
 * Extracts headings from post content and injects anchor IDs.
 */
class HeadingParser {

	/**
	 * Extracts headings at the specified levels from raw post content.
	 *
	 * @param string $content Raw post content (HTML).
	 * @param int[]  $levels  Heading levels to include, e.g. [2, 3].
	 * @return array<int, array{level: int, text: string, slug: string}>
	 */
	public function extract( string $content, array $levels ): array {
		if ( empty( $levels ) ) {
			return array();
		}

		$level_chars = implode( '', array_map( 'intval', $levels ) );
		$pattern     = '/<h([' . $level_chars . '])[^>]*>(.*?)<\/h\1>/is';

		preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );

		$headings = array();
		$seen     = array();

		foreach ( $matches as $match ) {
			$level = (int) $match[1];
			$text  = wp_strip_all_tags( $match[2] );
			$base  = sanitize_title( $text );
			$slug  = $base;
			$i     = 2;

			while ( isset( $seen[ $slug ] ) ) {
				$slug = $base . '-' . ( $i++ );
			}

			$seen[ $slug ] = true;

			$headings[] = array(
				'level' => $level,
				'text'  => $text,
				'slug'  => $slug,
			);
		}

		return $headings;
	}

	/**
	 * Adds id attributes to headings in the content so TOC anchors resolve.
	 *
	 * Only modifies headings at the given levels. Skips headings that already
	 * have an id attribute. Duplicate heading texts get a numeric suffix,
	 * matching the behaviour of extract().
	 *
	 * @param string $content Raw post content (HTML).
	 * @param int[]  $levels  Heading levels to inject anchors into.
	 * @return string Modified content.
	 */
	public function add_anchors( string $content, array $levels ): string {
		if ( empty( $levels ) ) {
			return $content;
		}

		$level_chars = implode( '', array_map( 'intval', $levels ) );
		$seen        = array();

		return (string) preg_replace_callback(
			'/<h([' . $level_chars . '])([^>]*)>(.*?)<\/h\1>/is',
			function ( array $m ) use ( &$seen ): string {
				$level = $m[1];
				$attrs = $m[2];
				$inner = $m[3];

				if ( str_contains( $attrs, 'id=' ) ) {
					return $m[0];
				}

				$text = wp_strip_all_tags( $inner );
				$base = sanitize_title( $text );
				$slug = $base;
				$i    = 2;

				while ( isset( $seen[ $slug ] ) ) {
					$slug = $base . '-' . ( $i++ );
				}

				$seen[ $slug ] = true;

				return "<h{$level}{$attrs} id=\"" . esc_attr( $slug ) . "\">{$inner}</h{$level}>";
			},
			$content
		);
	}
}
