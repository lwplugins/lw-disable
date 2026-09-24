/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Callout from '../components/Callout';
import Section from '../components/Section';
import ToggleRow from '../components/ToggleRow';

/**
 * One settings section: a card with a switch per field. A switch that is on
 * means the feature is disabled (or removed / restricted, as its
 * description says).
 *
 * @param {Object} props
 * @param {Object} props.section Section meta { key, title, icon, fields }.
 * @param {Object} props.store   Settings store.
 */
export default function SectionTab( { section, store } ) {
	return (
		<>
			<Callout>
				{ __(
					'Turn a switch on to disable the feature it names. Turn it off to keep the WordPress default.',
					'lw-disable'
				) }
			</Callout>
			<Section>
				{ section.fields.map( ( field ) => (
					<ToggleRow
						key={ field.key }
						title={ field.label }
						help={ field.description }
						checked={ !! store.data.options[ field.key ] }
						onChange={ ( value ) => store.set( field.key, value ) }
					/>
				) ) }
			</Section>
		</>
	);
}
