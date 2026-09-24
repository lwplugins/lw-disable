/**
 * Internal dependencies
 */
import FormSkeleton from './components/FormSkeleton';
import LoadError from './components/LoadError';
import Notices from './components/Notices';
import useSettingsStore from './data/useSettingsStore';
import Footer from './shell/Footer';
import SideNav from './shell/SideNav';
import TopBar from './shell/TopBar';
import useSaveShortcut from './shell/useSaveShortcut';
import useTab from './shell/useTab';
import useUnsavedWarning from './shell/useUnsavedWarning';
import SectionTab from './tabs/SectionTab';

// ?page=lw-disable&tab=security opens the matching section.
const INITIAL_TAB = new URLSearchParams( window.location.search ).get( 'tab' );

/**
 * Shell + one options store shared by every section (partial saves). The
 * sections (nav items and cards) come from the settings meta.
 */
export default function App() {
	const store = useSettingsStore();
	const sections = store.data?.meta?.sections || [];
	const tab = useTab(
		sections.map( ( section ) => section.key ),
		INITIAL_TAB
	);
	const current = sections.find( ( section ) => section.key === tab );

	useUnsavedWarning( store.hasEdits );
	useSaveShortcut( store.save, store.hasEdits && ! store.isSaving );

	let content;
	if ( store.error ) {
		content = (
			<LoadError message={ store.error } onRetry={ store.reload } />
		);
	} else if ( ! current ) {
		content = <FormSkeleton />;
	} else {
		content = <SectionTab section={ current } store={ store } />;
	}

	return (
		<>
			<div className="lw-admin-shell">
				<SideNav sections={ sections } current={ tab } />
				<div className="lw-admin-main">
					<TopBar
						title={ current?.title || '' }
						store={ store.data ? store : null }
					/>
					<main className="lw-admin-scroll">
						<div className="lw-admin-content">{ content }</div>
					</main>
					<Footer />
				</div>
			</div>
			<Notices />
		</>
	);
}
