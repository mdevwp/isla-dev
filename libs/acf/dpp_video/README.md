# DPP Video Section — v1.1.1

Accessible, click-to-play video block for the Isla homepage.
Built against the brief of 26 Aug 2026 and the Figma "Stats section" frame.

---

## What this patch touches

| | |
|---|---|
| **New folder** | `wp-content/themes/kmnd-child/libs/acf/dpp_video/` |
| **Modified files** | `wp-content/themes/kmnd-child/functions.php` — **one `require_once` line** |
| **Database** | nothing on install. The block is only placed on a page when you deliberately run `install.php --apply` (or drag it in via Gutenberg). |

Nothing else in the theme is edited. No existing block, template, stylesheet
or field group is modified, so the patch can be reverted by deleting one
folder and one line.

---

## Install

**1. Upload the folder**

```
wp-content/themes/kmnd-child/libs/acf/dpp_video/
```

**2. Add one line to `functions.php`**

Immediately after the existing `include('inc/gutenbergAcfFunction.php');`:

```php
/* DPP Video Section block (self-contained: libs/acf/dpp_video/) */
require_once get_stylesheet_directory() . '/libs/acf/dpp_video/bootstrap.php';
```

That is the whole installation. The block now appears in the editor under
**Komanda blocks → DPP Video Section**.

**3. Place it on the homepage** — either drag it in through Gutenberg, or run
the migration so staging and production end up byte-identical:

```bash
# from the WordPress root — shows the plan, changes nothing
php wp-content/themes/kmnd-child/libs/acf/dpp_video/install.php

# apply it
php wp-content/themes/kmnd-child/libs/acf/dpp_video/install.php --apply
```

By default it targets the static front page and inserts the block directly
**above** `acf/video-block-v3`, i.e. below the NHS logo carousel, as the brief
specifies.

Options: `--page=10`, `--anchor=acf/video-block-v3`, `--after`.

---

## Optional Pathway graphic move

The brief also asks for the Pathway graphic (`acf/video-block-v3`) to leave the slot the
video now occupies. The PDF places it after the patient-journey section and before
"Cut delays, not corners":

```bash
php wp-content/themes/kmnd-child/libs/acf/dpp_video/install.php --move-pathway
php wp-content/themes/kmnd-child/libs/acf/dpp_video/install.php --move-pathway --apply
```

Resulting order: hero, NHS logos, DPP video, statistics, testimonials, patient journey,
Pathway graphic, "Cut delays, not corners", integrations, closing CTA.

Omit the flag to leave the graphic where it is; an editor can also drag it in Gutenberg.

## Behaviour without JavaScript

`controls` is present in the served HTML, and a `<noscript>` rule hides the poster overlay
and the Play button. With scripting off the visitor gets the browser's own player, fully
usable. With scripting on, the script removes `controls` during init — they would sit
behind the poster and be reachable by keyboard while invisible — and restores them the
moment playback starts.

## Known deviation from the neighbouring sections

On viewports below 768px the heading renders at 28px (26px below 480px) where the other
homepage H2s stay at 40px. This was a deliberate request: at 40px this particular title
runs to four lines on a phone. Remove the two font-size rules at the bottom of `style.css`
to return to exact parity.

## Uninstall / rollback

```bash
# restore the page content exactly as it was before --apply
php wp-content/themes/kmnd-child/libs/acf/dpp_video/install.php --rollback --apply
```

Then remove the `require_once` line and delete the `dpp_video` folder.
Nothing is left behind except one post-meta key, which the rollback deletes.

---

## Why this is safe to deploy

- **Additive.** One new folder plus one `require_once`. No existing file is rewritten.
- **Guarded against fatals.** `bootstrap.php` checks `ABSPATH`, the presence of
  `acf_register_block_type()` / `acf_register_block()`, and the render template. Its one
  global helper is wrapped in `function_exists()`. If ACF is deactivated the block stops
  appearing and the site keeps rendering. This is defence in depth, not a formal proof.
- **No field-group collisions.** Fields are registered in code via
  `acf_add_local_field_group()` under the unique keys `group_dpp_video_section` /
  `field_dpp_*`. Field groups created in the ACF admin UI are untouched.
- **No CSS bleed.** Every rule is namespaced under `.dpp-video-section`. The legacy
  `.video-section` rules in `assets/css/style.css` are not affected, and this block
  does not inherit them.
- **No JS globals.** Vanilla IIFE, null-guarded, scoped per block instance. No jQuery,
  no library, no global names.
- **Assets load only when used.** ACF enqueues `style.css` / `script.js` only on pages
  where the block is present.
- **Content migration is reversible and non-destructive.** `install.php` is dry-run by
  default and backs `post_content` up to post meta before writing. It works on the parsed
  block tree rather than string offsets, so wrapper blocks such as `core/group` are never
  entered by accident. Re-running it preserves the settings already saved on an existing
  DPP block: video, captions, transcript and colours are carried over, only the position
  moves. Before writing it checks the set of blocks is unchanged apart from the intended
  insertion, refuses content that does not survive a parse/serialize round trip, rejects
  any result containing unescaped u-escape sequences, writes through `wp_slash()` and
  then re-reads the row to verify.

---

## Requirements coverage

| Brief requirement | Implementation |
|---|---|
| No auto-play, mobile or desktop | No `autoplay` attribute; `preload="none"`. Playback starts only on click/Enter. |
| Visible Play/Pause and Mute/Unmute | Branded Play button before playback; native `controls` (pause, mute, scrubber, captions menu, fullscreen) from the first frame onward. |
| Must not slow the homepage down | `preload="none"` asks the browser to fetch no video before the visitor presses Play. It is a strong hint, not a guarantee, so confirm with a network trace once the final file is in. Poster is a responsive `<picture>` (WebP + JPEG, 800w/1600w), `loading="lazy"`, `fetchpriority="low"`. `width`/`height` + `aspect-ratio` prevent layout shift. |
| Captions must be indexable | Three layers: `<track kind="captions">` for playback, an on-page transcript (what search engines actually read), and `VideoObject` structured data carrying the transcript. The demo `.vtt` is only ever paired with the demo clip; a real video with no captions yet renders no `<track>` rather than the wrong words. Schema is suppressed entirely while the block is on placeholder media, and `uploadDate` comes from the media library entry for the video, never from the page's modified date. |
| H2 above the video matching other homepage H2s | Uses `class="main-heading"` — the same class the other sections use: Manrope 800 / 50px / 110% / −3%. Colour configurable; defaults to `#242331`, the colour of every other homepage H2. The level is selectable H1–H6 (default H2) for pages with a different outline; the styling never changes with it, and any unexpected value falls back to H2. |
| Position below the NHS logos | `install.php` places it directly above `acf/video-block-v3`. |
| Orange play button below the chin | The exact Figma SVG (145×147, `#F56612`, 0.9 opacity). Centred at 60% of the video height; adjustable 20–85% in the block settings. |
| Rounded corners, white card, soft shadow like the testimonials | Figma spec: radius `28.8px`, `#FFFFFF`, drop shadow `0 0 40px 10px rgba(0,0,0,.10)` — identical to the testimonial card in Figma. |
| Padding matching other content blocks | `100px / 100px` desktop, `70px / 50px` below 991px — the same values as `.video-section.v3`, `.excellence-section` and `.features-section`. |
| Left/right alignment matching the page | Reuses the theme's own `.container`, so alignment matches by construction. |

---

## Block settings

Four tabs in the editor sidebar.

**Content** — heading and heading level (H1–H6, default H2); poster; video source; transcript;
optional CTA link.

*Video source* switches between an uploaded file and YouTube, and only the fields for the
chosen one are shown. Uploaded file takes MP4, optional WebM and a `.vtt` caption track.
YouTube takes any normal address — `watch?v=`, `youtu.be/`, `/embed/`, `/shorts/`, `/live/`.

YouTube is embedded as a facade: until the visitor presses Play the page shows only the
poster and the branded button, and nothing at all is requested from Google. That keeps the
"must not slow the homepage down" requirement intact — a plain YouTube iframe pulls roughly
a megabyte of script on page load. Playback uses `youtube-nocookie.com`, the poster comes
from the video's own thumbnail unless one is uploaded, and a `<noscript>` iframe keeps the
video playable with scripting off. Schema switches from `contentUrl` to `embedUrl`.

**Appearance** — section background and heading colour, each choosable from the brand
palette or as a custom colour; heading alignment; card background; drop shadow on/off;
card and video corner radius; aspect ratio; section padding.

**Play button** — default (the Figma SVG, recolourable) or a custom uploaded image;
size as a % of the video width; vertical position as a %.

**Accessibility & SEO** — show/expand the transcript and its toggle label; `VideoObject`
schema on/off; an optional accessible label for the video.

---

## Placeholder media

`media/` ships with a poster, a short demo clip and a sample `.vtt` so the block is
reviewable before the final assets arrive. They are used **only** when the MP4/WebM
fields are empty, and the block shows a grey "Placeholder media" note underneath so it
can never be mistaken for finished work. Once real files are set in the block, delete
`media/dpp-placeholder.*` if you want.

### Video export specification for the client

```
Resolution / aspect   1920×1080, 16:9   (Figma frame: 1351×756)
Container / codec     MP4, H.264 High profile, faststart (web-optimised)
Frame rate            25 or 30 fps, matching the source
Audio                 AAC 128 kbps stereo
Maximum file size     15 MB
Optional              WebM (VP9 / Opus) — served first where supported
Also required         captions .vtt (or .srt, we convert) + transcript text
                      + a clean poster frame at 1920×1080
```

The file-size ceiling is comfortable because the video is never fetched until the
visitor presses Play, so it has no effect on homepage load time or Core Web Vitals.

---

## Note on the transcript field

It is a plain textarea, not a WYSIWYG, and that is deliberate. ACF sets a WYSIWYG up
through its own `buildQuicktags()`, which throws when the field is created after page
load — inserting the block crashed the editor with *"Cannot read properties of undefined
(reading 'buttons')"*, while blocks already on the page kept working. A transcript is
plain paragraphs, so nothing is lost: blank lines become paragraphs on output and basic
HTML still passes through `wp_kses_post()`. Values saved by the earlier WYSIWYG version
render unchanged.

## Open items

1. **Heading colour.** The brief says "Deep blue"; every other homepage H2 is `#242331`
   (*Isla dark*). The brand *Deep blue* token is `#15253C`. Default is `#242331` because
   the instruction was to match the other H2s exactly — switchable in one click.
2. **Pathway graphic.** The brief asks for it to be moved out of the video's slot. The
   Figma comment points at a destination that is not in the exported PDF, so for now the
   video is inserted above it and the graphic has simply shifted down one position.
3. **Testimonial cards are off-spec.** In Figma both the video card and the testimonial
   card are radius `28.8` with a `0 0 40 10` shadow. The live testimonial CSS
   (`assets/css/style.css`, `.slide-item`) uses radius `32px` and `4px 4px 40px 5px`.
   This block follows Figma; the two card styles will therefore differ very slightly on
   the homepage. Worth raising separately.
