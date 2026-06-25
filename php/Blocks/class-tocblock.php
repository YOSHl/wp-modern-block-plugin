<?php
/**
 * Table of Contents block registration and rendering.
 *
 * @package WpModernBlockPlugin\Blocks
 */

declare(strict_types=1);

namespace WpModernBlockPlugin\Blocks;

use WpModernBlockPlugin\Parser\HeadingParser;

/**
 * Registers the table-of-contents block and handles server-side rendering.
 */
class TocBlock {

	/**
	 * Heading parser instance.
	 *
	 * @var HeadingParser
	 */
	private HeadingParser $parser;

	/**
	 * Constructor.
	 *
	 * @param HeadingParser $parser Heading parser.
	 */
	public function __construct( HeadingParser $parser ) {
		$this->parser = $parser;
	}

	/**
	 * Registers the block type and content filter.
	 */
	public function register(): void {
		register_block_type(
			plugin_dir_path( dirname( __DIR__ ) ) . 'block.json',
			array( 'render_callback' => array( $this, 'render' ) )
		);

		add_filter( 'the_content', array( $this, 'inject_heading_anchors' ) );
	}

	/**
	 * Renders the table of contents on the frontend.
	 *
	 * @param array<string, mixed> $attributes Block attributes.
	 * @return string HTML output.
	 */
	public function render( array $attributes ): string {
		$post = get_post();
		if ( ! $post instanceof \WP_Post ) {
			return '';
		}

		$levels = array_map( 'intval', (array) ( $attributes['headingLevels'] ?? array( 2, 3 ) ) );
		$title  = (string) ( $attributes['title'] ?? __( 'Table of Contents', 'wp-modern-block-plugin' ) );

		$headings = $this->parser->extract( $post->post_content, $levels );

		if ( empty( $headings ) ) {
			return '';
		}

		return $this->build_html( $headings, $title );
	}

	/**
	 * Adds id attributes to headings in posts that contain this block.
	 *
	 * @param string $content Post content.
	 * @return string Modified content.
	 */
	public function inject_heading_anchors( string $content ): string {
		if ( ! has_block( 'wp-modern-block-plugin/table-of-contents' ) ) {
			return $content;
		}

		return $this->parser->add_anchors( $content, array( 2, 3 ) );
	}

	/**
	 * Builds the TOC HTML from the extracted heading list.
	 *
	 * @param array<int, array{level: int, text: string, slug: string}> $headings Extracted headings.
	 * @param string                                                    $title    TOC title text.
	 * @return string
	 */
	private function build_html( array $headings, string $title ): string {
		$html = '<nav class="wp-block-wp-modern-block-plugin-table-of-contents" aria-label="' . esc_attr( $title ) . '">';

		if ( '' !== $title ) {
			$html .= '<p class="toc__title">' . esc_html( $title ) . '</p>';
		}

		$html .= '<ol class="toc__list">';

		$base_level = $headings[0]['level'];

		foreach ( $headings as $heading ) {
			$depth = $heading['level'] - $base_level;
			$html .= '<li class="toc__item toc__item--depth-' . $depth . '">';
			$html .= '<a class="toc__link" href="#' . esc_attr( $heading['slug'] ) . '">';
			$html .= esc_html( $heading['text'] );
			$html .= '</a></li>';
		}

		$html .= '</ol></nav>';

		return $html;
	}
}
