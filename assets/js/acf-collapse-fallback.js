/**
 * Repeater row collapse inside the iframed block editor canvas.
 *
 * WHY THIS EXISTS
 * ACF registers its blocks with Block API version 2. WordPress 6.9+ renders the
 * post editor canvas in an iframe regardless, so ACF's field markup ends up in
 * the iframe's document while ACF's own JavaScript runs in the parent. The field
 * models are therefore never created for those fields — `acf.getFields()` returns
 * an empty list — and the collapse control does nothing when clicked.
 *
 * This restores just that one control by listening on the iframe's own document.
 * The `-collapsed` class it toggles is the same one ACF uses, and the rules that
 * act on it come from acf-pro-input.css, which is loaded into the canvas by
 * inc/editor-canvas-styles.php.
 *
 * Scope note: only the iframe document is bound. Wherever ACF works natively
 * (the block sidebar, the classic post screen, options pages) its own handler
 * runs and this script stays out of the way, so a row can never be toggled twice.
 *
 * Shift-click collapses or expands every row in the same repeater, matching
 * ACF's own behaviour.
 */
(function () {
	'use strict';

	// ACF's own binding is: 'click a[data-event="collapse-row"]'.
	var TOGGLE = 'a[data-event="collapse-row"]';
	var bound = [];

	function alreadyBound( doc ) {
		for ( var i = 0; i < bound.length; i++ ) {
			if ( bound[ i ] === doc ) {
				return true;
			}
		}
		return false;
	}

	function onClick( e ) {
		var target = e.target;
		if ( ! target || ! target.closest ) {
			return;
		}

		var btn = target.closest( TOGGLE );
		if ( ! btn ) {
			return;
		}

		var row = btn.closest( '.acf-row' );
		if ( ! row || row.classList.contains( 'acf-clone' ) ) {
			return;
		}

		e.preventDefault();
		e.stopPropagation();

		var collapse = ! row.classList.contains( '-collapsed' );

		if ( e.shiftKey ) {
			var repeater = row.closest( '.acf-repeater' );
			var rows = repeater
				? repeater.querySelectorAll( '.acf-row:not(.acf-clone)' )
				: [ row ];

			Array.prototype.forEach.call( rows, function ( r ) {
				r.classList.toggle( '-collapsed', collapse );
			} );

			return;
		}

		row.classList.toggle( '-collapsed', collapse );
	}

	function bind( doc ) {
		if ( ! doc || alreadyBound( doc ) ) {
			return;
		}

		bound.push( doc );
		doc.addEventListener( 'click', onClick, true );
	}

	function scan() {
		var frames = document.querySelectorAll( 'iframe' );

		Array.prototype.forEach.call( frames, function ( frame ) {
			var doc;

			// A cross-origin frame (an embed preview, say) throws here.
			try {
				doc = frame.contentDocument;
			} catch ( err ) {
				return;
			}

			if ( doc && doc.querySelector( '.acf-repeater, .acf-block-fields' ) ) {
				bind( doc );
			}
		} );
	}

	function start() {
		scan();

		// The canvas iframe mounts after the editor boots, and is replaced again
		// whenever the device preview size changes — so keep watching for it.
		if ( window.MutationObserver ) {
			new MutationObserver( scan ).observe( document.body, {
				childList: true,
				subtree: true,
			} );
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', start );
	} else {
		start();
	}
})();

/**
 * Tab groups that ACF left uninitialised.
 *
 * ACF builds the tab strip in JavaScript. When a block is rendered into the
 * editor on the fly that initialisation does not always run, and every field
 * from every tab stacks up in one flat column instead.
 *
 * `acf.doAction( 'append', $el )` is ACF's own documented way to initialise
 * fields that were added after page load. It is called only on a group that is
 * demonstrably broken — a tab field present with no tab strip rendered for it —
 * so nothing that already works is touched or initialised twice.
 */
(function () {
	'use strict';

	function repair( root ) {
		if ( ! window.acf || ! window.jQuery ) {
			return;
		}

		var groups = root.querySelectorAll( '.acf-fields' );

		Array.prototype.forEach.call( groups, function ( group ) {
			var hasTabField = group.querySelector( ':scope > .acf-field-tab' );
			var hasTabStrip = group.querySelector( ':scope > .acf-tab-wrap' );

			if ( ! hasTabField || hasTabStrip ) {
				return; // no tabs here, or they are already built
			}

			try {
				window.acf.doAction( 'append', window.jQuery( group ) );
			} catch ( err ) {
				/* leave the flat list rather than break the editor */
			}
		} );
	}

	function watch() {
		repair( document );

		if ( ! window.MutationObserver ) {
			return;
		}

		var pending = null;

		new MutationObserver( function () {
			clearTimeout( pending );
			pending = setTimeout( function () {
				repair( document );
			}, 150 );
		} ).observe( document.body, { childList: true, subtree: true } );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', watch );
	} else {
		watch();
	}
})();
