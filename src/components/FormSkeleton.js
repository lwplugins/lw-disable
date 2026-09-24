/**
 * WordPress dependencies
 */
import { Card, CardBody } from '@wordpress/components';

/**
 * Internal dependencies
 */
import { SkeletonBlock, SkeletonRegion, SkeletonRows } from './skeleton';

/**
 * Placeholder for a section, same layout as SectionTab: the explanation
 * line, then a card of switch rows.
 */
export default function FormSkeleton() {
	return (
		<SkeletonRegion className="lw-skel-tab">
			<SkeletonBlock height={ 40 } />
			<Card className="lw-admin-section">
				<CardBody>
					<SkeletonRows count={ 4 } />
				</CardBody>
			</Card>
		</SkeletonRegion>
	);
}
