/**
 * WordPress dependencies
 */
import apiFetch from '@wordpress/api-fetch';

/**
 * Internal dependencies
 */
import { NAMESPACE } from './boot';

const admin = ( route ) => `/${ NAMESPACE }/admin${ route }`;

export const api = {
	settings: () => apiFetch( { path: admin( '/settings' ) } ),
	saveSettings: ( patch ) =>
		apiFetch( { path: admin( '/settings' ), method: 'POST', data: patch } ),
};

export const errorMessage = ( error ) =>
	error?.message ||
	'That did not work. Please reload the page and try again.';
