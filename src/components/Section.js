/**
 * WordPress dependencies
 */
import { Card, CardBody } from '@wordpress/components';

/**
 * A card of setting rows: the building block of every section.
 *
 * @param {Object}  props
 * @param {Element} props.children Rows.
 */
export default function Section( { children } ) {
	return (
		<Card className="lw-admin-section">
			<CardBody>
				<div className="lw-admin-rows">{ children }</div>
			</CardBody>
		</Card>
	);
}
