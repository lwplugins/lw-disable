/**
 * WordPress dependencies
 */
import { SVG, Path } from '@wordpress/primitives';

/**
 * LW Disable mark: the plugin logo (assets/img/title-icon.svg, Font Awesome
 * Pro duotone ban). Both layers follow `color` (the brand red via CSS).
 */
export default function DisableMark() {
	return (
		<SVG
			className="lw-admin-mark"
			viewBox="0 0 640 640"
			xmlns="http://www.w3.org/2000/svg"
			aria-hidden="true"
			focusable="false"
		>
			<Path
				opacity=".4"
				fill="currentColor"
				d="M163.5 208.8C176 191.3 191.3 176 208.8 163.5L476.5 431.2C464 448.7 448.7 464 431.2 476.5L163.5 208.8z"
			/>
			<Path
				fill="currentColor"
				d="M320 128C426 128 512 214 512 320C512 426 426 512 320 512C214 512 128 426 128 320C128 214 214 128 320 128zM320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576z"
			/>
		</SVG>
	);
}
