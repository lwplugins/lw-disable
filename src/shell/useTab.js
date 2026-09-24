/**
 * WordPress dependencies
 */
import { useEffect, useState } from '@wordpress/element';

const currentHash = () => window.location.hash.replace( '#', '' );

/**
 * Current tab from location.hash; the first load also honours `?tab=`. The
 * tab ids come from the server (settings meta), so they may still be empty
 * while loading: the requested ids are kept and resolved once ids arrive.
 *
 * @param {string[]} ids     Tab ids (empty while loading).
 * @param {string}   initial Tab from the URL (?tab=).
 * @return {string} Current tab id ('' while there are no ids).
 */
export default function useTab( ids, initial ) {
	const [ wanted, setWanted ] = useState( () => [ currentHash(), initial ] );

	useEffect( () => {
		const onChange = () => {
			setWanted( [ currentHash() ] );
			window.scrollTo( { top: 0 } );
		};
		window.addEventListener( 'hashchange', onChange );
		return () => window.removeEventListener( 'hashchange', onChange );
	}, [] );

	return wanted.find( ( id ) => ids.includes( id ) ) || ids[ 0 ] || '';
}
