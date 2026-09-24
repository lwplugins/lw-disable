/**
 * Server-provided boot data (SettingsPage inline script).
 */
const boot = window.lwDisable || {};

export const VERSION = boot.version || '';
export const NAMESPACE = boot.namespace || 'lw-disable/v1';
export const DOCS_URL =
	boot.docsUrl || 'https://lwplugins.com/docs/lw-disable/';
