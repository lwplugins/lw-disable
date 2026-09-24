/**
 * WordPress dependencies
 */
import { Icon, code, cog, dashboard, post, shield } from '@wordpress/icons';

/**
 * Section dashicons (FieldsData) mapped to their `@wordpress/icons` match.
 */
const ICONS = {
	'dashicons-admin-settings': cog,
	'dashicons-performance': dashboard,
	'dashicons-shield': shield,
	'dashicons-editor-code': code,
	'dashicons-admin-post': post,
};

/**
 * A section's icon: the matching SVG icon, or the dashicon itself when no
 * match is mapped (e.g. a section added later).
 *
 * @param {Object} props
 * @param {string} props.name Dashicon class from the settings meta.
 * @param {number} props.size Size in px.
 */
export default function SectionIcon( { name, size = 20 } ) {
	if ( ICONS[ name ] ) {
		return <Icon icon={ ICONS[ name ] } size={ size } />;
	}

	return (
		<span
			className={ `dashicons ${ name || 'dashicons-admin-generic' }` }
			aria-hidden="true"
		/>
	);
}
