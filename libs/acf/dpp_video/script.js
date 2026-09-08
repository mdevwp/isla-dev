/**
 * DPP Video Section — click-to-play behaviour.
 *
 * The video ships with preload="none" and no autoplay, so nothing is
 * downloaded until the visitor presses Play. Once playback starts we hand
 * over to the browser's native controls, which give a visible Play/Pause,
 * Mute/Unmute, scrubber, captions menu and fullscreen for free — and are
 * keyboard- and screen-reader-accessible on every platform.
 */
(function () {
	'use strict';

	var SECTION = '.dpp-video-section';

	function init(section) {
		if (!section || section.dataset.dppReady === '1') {
			return;
		}

		var button = section.querySelector('[data-dpp-play]');
		if (!button) {
			return;
		}

		var yt = section.querySelector('[data-dpp-youtube]');

		// YouTube facade: swap in the iframe on the first click and nowhere else,
		// so nothing is fetched from Google until the visitor asks for it.
		if (yt) {
			section.dataset.dppReady = '1';

			button.addEventListener('click', function () {
				if (section.classList.contains('is-playing')) {
					return;
				}

				var id = yt.getAttribute('data-dpp-youtube');
				var frame = document.createElement('iframe');

				frame.className = 'dpp-video-section__yt-frame';
				// autoplay is user-initiated here, so it satisfies the brief.
				frame.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) +
					'?rel=0&autoplay=1&playsinline=1';
				frame.title = yt.getAttribute('data-dpp-title') || '';
				frame.setAttribute('allow',
					'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture');
				frame.setAttribute('allowfullscreen', '');

				yt.appendChild(frame);
				section.classList.add('is-playing');
				frame.focus();
			});

			return;
		}

		var video = section.querySelector('.dpp-video-section__video');
		if (!video) {
			return;
		}

		section.dataset.dppReady = '1';

		// `controls` is present in the HTML so the player still works when this
		// script never runs. Now that it has, take them off: they sit behind the
		// poster and would otherwise be reachable by keyboard while invisible.
		video.controls = false;

		function start() {
			// Only fetch the media once the visitor has asked for it.
			if (video.preload === 'none') {
				video.preload = 'metadata';
				video.load();
			}

			var played = video.play();

			if (played && typeof played.catch === 'function') {
				played.catch(function () {
					// Autoplay policies can still refuse (e.g. low-power mode).
					// Fall back to exposing the native controls so the visitor
					// can start it themselves rather than leaving a dead button.
					reveal();
					video.focus();
				});
			}
		}

		function reveal() {
			video.controls = true;
			section.classList.add('is-playing');
		}

		function restore() {
			// Keep whatever focus the visitor currently has. Pulling it back to
			// the Play button would yank them up the page if the clip happened to
			// finish while they had already tabbed on to something else.
			var focusWasInside = section.contains(document.activeElement);

			video.controls = false;
			section.classList.remove('is-playing');

			if (focusWasInside) {
				button.focus();
			}
		}

		button.addEventListener('click', start);

		video.addEventListener('playing', function () {
			reveal();
		});

		// When the clip finishes, bring the poster and the big Play button
		// back so the section reads as a poster again rather than a black box.
		video.addEventListener('ended', restore);

		// Keep the two states in sync if playback is started from the
		// native controls (possible once they are visible).
		video.addEventListener('play', reveal);

		// On mobile, tapping the picture of a paused native player should resume
		// immediately. Leave the bottom controls strip alone so Pause, volume,
		// seeking and fullscreen keep their normal browser behaviour.
		function resumeFromPicture(event) {
			if (!window.matchMedia('(max-width: 767px)').matches ||
				!video.paused || video.ended) {
				return;
			}

			var rect = video.getBoundingClientRect();
			var controlsHeight = 56;
			if (event.clientY >= rect.bottom - controlsHeight) {
				return;
			}

			event.preventDefault();
			start();
		}

		// Native mobile controls may consume `click` before it reaches the video.
		// Pointer-up runs earlier and reliably catches a tap on the picture, while
		// the paused-state check leaves a tap on the Pause control untouched.
		video.addEventListener('pointerup', resumeFromPicture, true);
		video.addEventListener('click', resumeFromPicture);
	}

	function initAll(root) {
		var scope = root && root.querySelectorAll ? root : document;
		Array.prototype.forEach.call(scope.querySelectorAll(SECTION), init);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initAll(document);
		});
	} else {
		initAll(document);
	}

	// Re-run inside the block editor, where ACF re-renders the preview.
	if (window.acf && typeof window.acf.addAction === 'function') {
		window.acf.addAction('render_block_preview/type=dpp-video', function ($el) {
			initAll($el && $el[0] ? $el[0] : document);
		});
	}
})();
