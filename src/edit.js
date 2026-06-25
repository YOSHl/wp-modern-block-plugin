import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	CheckboxControl,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';

const HEADING_LEVELS = [ 2, 3, 4 ];

function extractHeadingsFromBlocks( blocks ) {
	const headings = [];
	for ( const block of blocks ) {
		if ( block.name === 'core/heading' ) {
			const level = block.attributes.level ?? 2;
			const text  = block.attributes.content?.replace( /<[^>]+>/g, '' ) ?? '';
			if ( text ) {
				headings.push( { level, text } );
			}
		}
		if ( block.innerBlocks?.length ) {
			headings.push( ...extractHeadingsFromBlocks( block.innerBlocks ) );
		}
	}
	return headings;
}

export default function Edit( { attributes, setAttributes } ) {
	const { title, headingLevels } = attributes;

	const blockProps = useBlockProps( {
		className: 'wp-block-wp-modern-block-plugin-table-of-contents',
	} );

	const blocks = useSelect(
		( select ) => select( blockEditorStore ).getBlocks(),
		[]
	);

	const headings = extractHeadingsFromBlocks( blocks ).filter( ( h ) =>
		headingLevels.includes( h.level )
	);

	function toggleLevel( level, checked ) {
		const next = checked
			? [ ...headingLevels, level ].sort()
			: headingLevels.filter( ( l ) => l !== level );
		setAttributes( { headingLevels: next } );
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'wp-modern-block-plugin' ) }>
					<TextControl
						label={ __( 'Title', 'wp-modern-block-plugin' ) }
						value={ title }
						onChange={ ( val ) => setAttributes( { title: val } ) }
					/>
					<fieldset>
						<legend>
							{ __( 'Include heading levels', 'wp-modern-block-plugin' ) }
						</legend>
						{ HEADING_LEVELS.map( ( level ) => (
							<CheckboxControl
								key={ level }
								label={ `H${ level }` }
								checked={ headingLevels.includes( level ) }
								onChange={ ( checked ) =>
									toggleLevel( level, checked )
								}
							/>
						) ) }
					</fieldset>
				</PanelBody>
			</InspectorControls>

			<nav { ...blockProps }>
				{ title && (
					<p className="toc__title">{ title }</p>
				) }

				{ headings.length === 0 ? (
					<p className="toc__placeholder">
						{ __(
							'No headings found. Add H2 or H3 blocks to generate the table of contents.',
							'wp-modern-block-plugin'
						) }
					</p>
				) : (
					<ol className="toc__list">
						{ headings.map( ( heading, i ) => (
							<li
								key={ i }
								className={ `toc__item toc__item--depth-${ heading.level - headingLevels[ 0 ] }` }
							>
								<span className="toc__link">
									{ heading.text }
								</span>
							</li>
						) ) }
					</ol>
				) }
			</nav>
		</>
	);
}
