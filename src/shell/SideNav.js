/**
 * WordPress dependencies
 */
import { useInstanceId } from '@wordpress/compose';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	Icon,
	chevronDown,
	chevronRight,
	external,
	help,
} from '@wordpress/icons';
import { Badge } from '@wordpress/ui';

/**
 * Internal dependencies
 */
import DisableMark from '../components/DisableMark';
import SectionIcon from '../components/SectionIcon';
import { SkeletonText } from '../components/skeleton';
import { DOCS_URL, VERSION } from '../data/boot';

/**
 * Full-height sidebar: plugin header, one link per settings section, docs
 * link. On mobile the list collapses behind a "current section" toggle.
 * While the sections load, placeholder lines stand in for the links.
 *
 * @param {Object} props
 * @param {Array}  props.sections Sections from the settings meta (empty while loading).
 * @param {string} props.current  Active section key.
 */
export default function SideNav( { sections, current } ) {
	const [ isOpen, setIsOpen ] = useState( false );
	const navId = useInstanceId( SideNav, 'lw-admin-sidenav' );
	const active = sections.find( ( section ) => section.key === current );

	useEffect( () => setIsOpen( false ), [ current ] );

	return (
		<aside className={ `lw-admin-sidebar ${ isOpen ? 'is-open' : '' }` }>
			<div className="lw-admin-sidebar__head">
				<a
					className="lw-admin-sidebar__home"
					href={ sections.length ? `#${ sections[ 0 ].key }` : '#' }
					aria-label={ __( 'LW Disable home', 'lw-disable' ) }
				>
					<DisableMark />
					<strong>LW Disable</strong>
				</a>
				<Badge intent="informational">{ `v${ VERSION }` }</Badge>
			</div>
			{ active && (
				<button
					type="button"
					className="lw-admin-sidebar__toggle"
					aria-expanded={ isOpen }
					aria-controls={ navId }
					onClick={ () => setIsOpen( ! isOpen ) }
				>
					<SectionIcon name={ active.icon } />
					<span>{ active.title }</span>
					<Icon icon={ chevronDown } size={ 20 } />
				</button>
			) }
			<nav
				id={ navId }
				className="lw-admin-sidenav"
				aria-label={ __( 'LW Disable sections', 'lw-disable' ) }
			>
				{ sections.length ? (
					<ul>
						{ sections.map( ( section ) => {
							const isCurrent = section.key === current;
							return (
								<li key={ section.key }>
									<a
										href={ `#${ section.key }` }
										className="lw-admin-sidenav__item"
										aria-current={
											isCurrent ? 'page' : undefined
										}
									>
										<SectionIcon name={ section.icon } />
										<span className="lw-admin-sidenav__label">
											{ section.title }
										</span>
										{ isCurrent && (
											<Icon
												icon={ chevronRight }
												size={ 18 }
											/>
										) }
									</a>
								</li>
							);
						} ) }
					</ul>
				) : (
					<span
						className="lw-skel-stack lw-skel-nav"
						aria-hidden="true"
					>
						{ [ 55, 70, 50, 65, 45 ].map( ( width ) => (
							<SkeletonText
								key={ width }
								width={ `${ width }%` }
							/>
						) ) }
					</span>
				) }
			</nav>
			<div className="lw-admin-sidebar__foot">
				<a
					className="lw-admin-sidenav__item"
					href={ DOCS_URL }
					target="_blank"
					rel="noopener noreferrer"
				>
					<Icon icon={ help } size={ 20 } />
					<span className="lw-admin-sidenav__label">
						{ __( 'Documentation', 'lw-disable' ) }
					</span>
					<Icon icon={ external } size={ 16 } />
					<span className="screen-reader-text">
						{ __( '(opens in a new tab)', 'lw-disable' ) }
					</span>
				</a>
			</div>
		</aside>
	);
}
