# GitHub — Style Reference
> Clean midday workspace, with a midnight dark mode variant

**Primary theme:** `midday` (light). **Dark mode variant:** `midnight`.

The system uses a light-on-white midday aesthetic as its default. The palette is inspired by GitHub's clean, functional UI: white and light-gray surfaces with subtle blue-purple gradients, Polar Blue accents, and a spacious, comfortable layout. Typography is precise and organized, contrasting dark text against light backgrounds. Components are lightweight with rounded corners, subtle borders, and minimal shadows.

A dark mode variant (`midnight`) is available, switching the canvas to deep-space black with Ghost White text and glowing accents—ideal for low-light environments. All CSS custom properties in this document represent the midnight variant; the midday variant uses equivalent light-mode tokens (see `github-midday.css`).

## Tokens — Colors

> The table below lists the **midnight** (dark mode) color tokens. The midday theme uses equivalent light-mode values defined in `webroot/css/github-midday.css`.

| Name | Value | Token | Role |
|------|-------|-------|------|
| Deep Space | `#0d1117` | `--color-deep-space` | Primary page background, base for most dark surfaces |
| Midnight Ink | `#000000` | `--color-midnight-ink` | Elevated surfaces, code blocks, modal backgrounds, and deeply shadowed areas |
| Code Canvas | `#151a22` | `--color-code-canvas` | Secondary background for sections, code editor areas, and subtle surface differentiation |
| Subtle Gray | `#21262d` | `--color-subtle-gray` | Borders between sections, divider lines, and very soft visual separation |
| Ash Gray | `#283041` | `--color-ash-gray` | Faint background for inactive states or subtle borders, hinting at elevation |
| Ghost White | `#ffffff` | `--color-ghost-white` | Primary text, prominent icons, and active navigation elements. Also used as a white background for some translucent elements |
| Faded Silver | `#f0f6fc` | `--color-faded-silver` | Secondary text, subheadings, and muted UI elements that require slightly less prominence than primary text |
| UI Gray | `#9198a1` | `--color-ui-gray` | Placeholder text, secondary icons, and less prominent text labels |
| Muted Text | `#7c8980` | `--color-muted-text` | Subtle helper text, less important details, and desaturated captions |
| Polar Blue | `#8dd6ff` | `--color-polar-blue` | Link text, outlined button borders, and interactive icon accents. It's a key brand identifier for interactive elements |
| Spring Green | `#08872b` | `--color-spring-green` | Primary action button background. Signals positive action or confirmation |
| Cosmic Violet | `#8c93fb` | `--color-cosmic-violet` | Decorative card borders and subtle illustrative accents, creating a sense of digital magic |
| Neon Green | `#5fed83` | `--color-neon-green` | Highlight text or decorative elements, particularly within code or feature descriptions |
| Interface Blue | `#1f6feb` | `--color-interface-blue` | Solid background for specific active elements or content blocks, providing a stronger visual presence |
| Violet Glow | `radial-gradient(circle at 0px 100%, rgb(230, 183, 254) 10%, rgb(80, 73, 194) 20%, rgba(87, 78, 255, 0) 60%)` | `--color-violet-glow` | Illustrative element — background highlight for abstract graphics |
| Blue-Violet Orb | `radial-gradient(rgb(167, 162, 255) 30%, rgba(147, 80, 255, 0.5))` | `--color-blue-violet-orb` | Illustrative element — focused glow emanating from central points in graphics |
| Vapor Trail Blue | `linear-gradient(rgba(120, 115, 203, 0.2) 60%, rgb(89, 147, 212) 100%)` | `--color-vapor-trail-blue` | Illustrative element — upward-sweeping light beams in abstract backgrounds |
| Deep Gradient Start | `linear-gradient(rgb(0, 2, 64), rgba(0, 0, 0, 0))` | `--color-deep-gradient-start` | Illustrative element — beginning of a deep blue gradient for background effects |

## Tokens — Typography

### Mona Sans — Primary brand typeface for all headings, body text, UI elements, and navigation. Its wide range of weights and precise letter-spacing ensures a consistent, modern voice. · `--font-mona-sans`
- **Substitute:** Inter
- **Weights:** 400, 425, 440, 460, 480, 500, 600, 800
- **Sizes:** 14px, 16px, 18px, 22px, 24px, 40px, 48px, 64px
- **Line height:** 1.00, 1.08, 1.18, 1.20, 1.30, 1.40, 1.50
- **Letter spacing:** -0.035, 0.01, 0.011, 0.013, 0.015
- **Role:** Primary brand typeface for all headings, body text, UI elements, and navigation. Its wide range of weights and precise letter-spacing ensures a consistent, modern voice.

### Mona Sans VF — Used for smaller text, auxiliary information, and captions where Mona Sans would be too heavy. Its variable font capabilities likely allow for subtle optical adjustments. · `--font-mona-sans-vf`
- **Substitute:** Inter
- **Weights:** 400, 500, 600, 700
- **Sizes:** 12px, 14px, 16px, 24px
- **Line height:** 1.00, 1.25, 1.43, 1.50
- **Letter spacing:** 0
- **Role:** Used for smaller text, auxiliary information, and captions where Mona Sans would be too heavy. Its variable font capabilities likely allow for subtle optical adjustments.

### Mona Sans Mono — Monospace variant for code snippets, technical terms, and environments where code-like presentation is desired, ensuring visual consistency with the main typeface. · `--font-mona-sans-mono`
- **Substitute:** JetBrains Mono
- **Weights:** 400
- **Sizes:** 14px
- **Line height:** 1.50
- **Letter spacing:** 0.015
- **Role:** Monospace variant for code snippets, technical terms, and environments where code-like presentation is desired, ensuring visual consistency with the main typeface.

### ui-monospace — Fallback monospace font for code blocks and technical displays, ensuring readability across systems. · `--font-ui-monospace`
- **Substitute:** Menlo, Monaco
- **Weights:** 400
- **Sizes:** 14px
- **Line height:** 1.50
- **Letter spacing:** 0
- **Role:** Fallback monospace font for code blocks and technical displays, ensuring readability across systems.

### Type Scale

| Role | Size | Line Height | Letter Spacing | Token |
|------|------|-------------|----------------|-------|
| caption | 12px | 1.5 | — | `--text-caption` |
| body-sm | 14px | 1.5 | 0.015px | `--text-body-sm` |
| body | 16px | 1.5 | 0.01px | `--text-body` |
| subheading | 18px | 1.5 | 0.01px | `--text-subheading` |
| heading-sm | 22px | 1.4 | 0.01px | `--text-heading-sm` |
| heading | 24px | 1.4 | 0.01px | `--text-heading` |
| heading-lg | 40px | 1.2 | -0.035px | `--text-heading-lg` |
| display | 64px | 1 | -0.035px | `--text-display` |

## Tokens — Spacing & Shapes

**Base unit:** 4px

**Density:** comfortable

### Spacing Scale

| Name | Value | Token |
|------|-------|-------|
| 4 | 4px | `--spacing-4` |
| 8 | 8px | `--spacing-8` |
| 12 | 12px | `--spacing-12` |
| 16 | 16px | `--spacing-16` |
| 20 | 20px | `--spacing-20` |
| 24 | 24px | `--spacing-24` |
| 28 | 28px | `--spacing-28` |
| 32 | 32px | `--spacing-32` |
| 40 | 40px | `--spacing-40` |
| 44 | 44px | `--spacing-44` |
| 48 | 48px | `--spacing-48` |
| 64 | 64px | `--spacing-64` |
| 80 | 80px | `--spacing-80` |
| 96 | 96px | `--spacing-96` |

### Border Radius

| Element | Value |
|---------|-------|
| pill | 60px |
| cards | 8px |
| input | 8px |
| buttons | 6px |
| default | 6px |

### Layout

- **Section gap:** 24px
- **Card padding:** 8px
- **Element gap:** 16px

## Components

### Ghost Header Button
**Role:** Navigation, secondary actions

Transparent background, 8px padding. No border.
- **Midday:** Ink (#1f2328) text, hover background rgba(208, 215, 222, 0.5).
- **Midnight:** Ghost White (#ffffff) text, hover background rgba(255, 255, 255, 0.1).

### Pill Ghost Button
**Role:** Secondary, subtle actions, category filters

Transparent background, 8px vertical / 16px horizontal padding, 60px border radius (pill shape).
- **Midday:** Ink (#1f2328) text.
- **Midnight:** Ghost White (#ffffff) text.

### Primary Action Button
**Role:** Main call to action

6px border radius, 6px vertical / 28px horizontal padding.
- **Midday:** Spring Green #1a7f37 background, #ffffff text. Hover: #158c37.
- **Midnight:** Spring Green #08872b background, #ffffff text. Hover: #0a9e33.

### Outlined Accent Button
**Role:** Secondary interactive actions

Transparent background, 1px solid border, 8px border radius, 6px vertical / 28px horizontal padding.
- **Midday:** Polar Blue (#0969da) text, border `--color-border-light` (#d0d7de).
- **Midnight:** Polar Blue (#8dd6ff) text, border Ghost White (#ffffff).

### Content Card
**Role:** Elevated content blocks

8px border radius (`--radius-cards`), 8px internal padding (`--card-padding`), 1px solid border.
- **Midday:** White background (`--color-canvas`), border `--color-border-subtle` (#d8dee4).
- **Midnight:** Translucent background (`rgba(255,255,255,0.2)`), border `--color-subtle-gray` (#21262d).

### Input Field
**Role:** User text input

12px padding, 1px solid border, 8px border radius (`--radius-input`). Focus state: Polar Blue border.
- **Midday:** White background (`--surface-canvas`), Ink (#1f2328) text, border `--color-border-light` (#d0d7de).
- **Midnight:** Code Canvas background (`--surface-code-canvas`), Ghost White (#ffffff) text, border `--color-subtle-gray` (#21262d).

## Do's and Don'ts

### Do (midday — default)
- Use `#ffffff` (`--color-midday-sky`) as the primary page background.
- Use `#f6f8fa` (`--color-paper`) for secondary sections, sidebars, and subtle surface differentiation.
- Use `#1f2328` (`--color-ink`) for headings and body text for maximum contrast on light backgrounds.
- Apply `#1a7f37` (`--color-spring-green`) for primary call-to-action button backgrounds.
- Utilize `#0969da` (`--color-polar-blue`) for all links, outlined buttons, and interactive icons.
- Apply a 6px border radius for most interactive elements; use 8px for cards.
- Maintain comfortable spacing using multiples of 4px.

### Do (midnight — dark mode)
- Use `#0d1117` (`--color-deep-space`) as the page background.
- Use `#ffffff` (`--color-ghost-white`) for headings and body text.
- Apply `#08872b` (`--color-spring-green`) for primary button backgrounds.
- Utilize `#8dd6ff` (`--color-polar-blue`) for links and interactive elements.

### Don't (both themes)
- Do not use generic gray borders on interactive elements; Polar Blue is reserved for interaction outlining.
- Never introduce hard, sharp corners on cards or buttons; maintain the rounded aesthetic.
- Avoid heavy drop shadows; prefer subtle glows and translucency.
- Avoid dense packing of information; maintain `elementGap` and `sectionGap`.
- Do not vary font families outside of Mona Sans variants and monospace fallbacks.

## Surfaces

### Midday (default)

| Level | Name | Value | Purpose |
|-------|------|-------|---------|
| 0 | Midday Sky | `#ffffff` | Primary page background |
| 1 | Paper | `#f6f8fa` | Secondary sections, sidebars |
| 2 | Canvas | `#ffffff` | Elevated surfaces, cards, content areas |

### Midnight (dark mode)

| Level | Name | Value | Purpose |
|-------|------|-------|---------|
| 0 | Deep Space | `#0d1117` | Base page background |
| 1 | Code Canvas | `#151a22` | Secondary sections, code areas |
| 2 | Midnight Ink | `#000000` | Elevated panels, deepest darks |
| 3 | Floating Card Translucent | `#ffffff` | Cards with high transparency (rgba(255, 255, 255, 0.2)) |

## Imagery

The visual language is clean and functional. Icons are outlined in Ink or muted grays, occasionally accented with Polar Blue. In midnight mode, icons are Ghost White or subtle grays with Polar Blue accents. Abstract glowing elements and digital illustrations are used sparingly in midnight mode to add depth against dark backgrounds. The imagery serves both decorative atmosphere and to explain complex concepts, with a density that allows for significant textual information on screen.

## Layout

The page employs a sidebar + main content layout for admin panels. The sidebar is fixed at 260px on desktop; on mobile it slides in from the left via a hamburger toggle. Content sections follow a vertical rhythm with comfortable spacing. Navigation is managed via the sidebar with icon-labeled links and a theme toggle at the bottom. The layout is spacious, providing ample breathing room between information blocks.

## Agent Prompt Guide

### Midday (default)

Quick Color Reference:
text: #1f2328
background: #ffffff
border: #d0d7de
accent: #0969da
primary action: #1a7f37 (filled action)

### Midnight (dark mode)

Quick Color Reference:
text: #ffffff
background: #0d1117
border: #21262d
accent: #8dd6ff
primary action: #08872b (filled action)

Example Component Prompts:
1. Create a Primary Action Button (midday): #1a7f37 background, #ffffff text, 6px radius, compact pill padding.
2. Create a Primary Action Button (midnight): #08872b background, #ffffff text, 6px radius, compact pill padding.
3. Create a navigation link: 16px Mona Sans, weight 400. Midday: color #1f2328, hover Polar Blue (#0969da). Midnight: color #ffffff, hover Polar Blue (#8dd6ff).

## Similar Brands

- **GitHub** — The primary reference. Midday mirrors GitHub's light UI; midnight mirrors GitHub's dark mode.
- **Vercel** — Similar dark theme with vivid accent colors and abstract background visuals.
- **Notion** — Clean, functional UI with distinct text levels and whitespace-driven hierarchy.
- **Stripe** — Sophisticated palette with intentional accent colors against a neutral background and clean typography.

## Quick Start

### CSS Custom Properties

Below are the **midnight** (dark mode) custom properties. For **midday** (default) equivalents, see `webroot/css/github-midday.css`.

```css
:root {
  /* Colors */
  --color-deep-space: #0d1117;
  --color-midnight-ink: #000000;
  --color-code-canvas: #151a22;
  --color-subtle-gray: #21262d;
  --color-ash-gray: #283041;
  --color-ghost-white: #ffffff;
  --color-faded-silver: #f0f6fc;
  --color-ui-gray: #9198a1;
  --color-muted-text: #7c8980;
  --color-polar-blue: #8dd6ff;
  --color-spring-green: #08872b;
  --color-cosmic-violet: #8c93fb;
  --color-neon-green: #5fed83;
  --color-interface-blue: #1f6feb;
  --color-violet-glow: #e6b7fe;
  --gradient-violet-glow: radial-gradient(circle at 0px 100%, rgb(230, 183, 254) 10%, rgb(80, 73, 194) 20%, rgba(87, 78, 255, 0) 60%);
  --color-blue-violet-orb: #a7a2ff;
  --gradient-blue-violet-orb: radial-gradient(rgb(167, 162, 255) 30%, rgba(147, 80, 255, 0.5));
  --color-vapor-trail-blue: #5993d4;
  --gradient-vapor-trail-blue: linear-gradient(rgba(120, 115, 203, 0.2) 60%, rgb(89, 147, 212) 100%);
  --color-deep-gradient-start: #000240;
  --gradient-deep-gradient-start: linear-gradient(rgb(0, 2, 64), rgba(0, 0, 0, 0));

  /* Typography — Font Families */
  --font-mona-sans: 'Mona Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  --font-mona-sans-vf: 'Mona Sans VF', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  --font-mona-sans-mono: 'Mona Sans Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  --font-ui-monospace: 'ui-monospace', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;

  /* Typography — Scale */
  --text-caption: 12px;
  --leading-caption: 1.5;
  --text-body-sm: 14px;
  --leading-body-sm: 1.5;
  --tracking-body-sm: 0.015px;
  --text-body: 16px;
  --leading-body: 1.5;
  --tracking-body: 0.01px;
  --text-subheading: 18px;
  --leading-subheading: 1.5;
  --tracking-subheading: 0.01px;
  --text-heading-sm: 22px;
  --leading-heading-sm: 1.4;
  --tracking-heading-sm: 0.01px;
  --text-heading: 24px;
  --leading-heading: 1.4;
  --tracking-heading: 0.01px;
  --text-heading-lg: 40px;
  --leading-heading-lg: 1.2;
  --tracking-heading-lg: -0.035px;
  --text-display: 64px;
  --leading-display: 1;
  --tracking-display: -0.035px;

  /* Typography — Weights */
  --font-weight-regular: 400;
  --font-weight-w425: 425;
  --font-weight-w440: 440;
  --font-weight-w460: 460;
  --font-weight-w480: 480;
  --font-weight-medium: 500;
  --font-weight-semibold: 600;
  --font-weight-bold: 700;
  --font-weight-extrabold: 800;

  /* Spacing */
  --spacing-unit: 4px;
  --spacing-4: 4px;
  --spacing-8: 8px;
  --spacing-12: 12px;
  --spacing-16: 16px;
  --spacing-20: 20px;
  --spacing-24: 24px;
  --spacing-28: 28px;
  --spacing-32: 32px;
  --spacing-40: 40px;
  --spacing-44: 44px;
  --spacing-48: 48px;
  --spacing-64: 64px;
  --spacing-80: 80px;
  --spacing-96: 96px;

  /* Layout */
  --section-gap: 24px;
  --card-padding: 8px;
  --element-gap: 16px;

  /* Border Radius */
  --radius-md: 6px;
  --radius-xl: 12px;
  --radius-2xl: 16px;
  --radius-3xl: 24px;
  --radius-full: 48px;
  --radius-full-2: 60px;

  /* Named Radii */
  --radius-pill: 60px;
  --radius-cards: 8px;
  --radius-input: 8px;
  --radius-buttons: 6px;
  --radius-default: 6px;

  /* Surfaces */
  --surface-deep-space: #0d1117;
  --surface-code-canvas: #151a22;
  --surface-midnight-ink: #000000;
  --surface-floating-card-translucent: #ffffff;
}
```

### Tailwind v4

Below are the **midnight** (dark mode) tokens. For **midday** (default) equivalents, see `webroot/css/github-midday.css`.

```css
@theme {
  /* Colors */
  --color-deep-space: #0d1117;
  --color-midnight-ink: #000000;
  --color-code-canvas: #151a22;
  --color-subtle-gray: #21262d;
  --color-ash-gray: #283041;
  --color-ghost-white: #ffffff;
  --color-faded-silver: #f0f6fc;
  --color-ui-gray: #9198a1;
  --color-muted-text: #7c8980;
  --color-polar-blue: #8dd6ff;
  --color-spring-green: #08872b;
  --color-cosmic-violet: #8c93fb;
  --color-neon-green: #5fed83;
  --color-interface-blue: #1f6feb;
  --color-violet-glow: #e6b7fe;
  --color-blue-violet-orb: #a7a2ff;
  --color-vapor-trail-blue: #5993d4;
  --color-deep-gradient-start: #000240;

  /* Typography */
  --font-mona-sans: 'Mona Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  --font-mona-sans-vf: 'Mona Sans VF', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  --font-mona-sans-mono: 'Mona Sans Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  --font-ui-monospace: 'ui-monospace', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;

  /* Typography — Scale */
  --text-caption: 12px;
  --leading-caption: 1.5;
  --text-body-sm: 14px;
  --leading-body-sm: 1.5;
  --tracking-body-sm: 0.015px;
  --text-body: 16px;
  --leading-body: 1.5;
  --tracking-body: 0.01px;
  --text-subheading: 18px;
  --leading-subheading: 1.5;
  --tracking-subheading: 0.01px;
  --text-heading-sm: 22px;
  --leading-heading-sm: 1.4;
  --tracking-heading-sm: 0.01px;
  --text-heading: 24px;
  --leading-heading: 1.4;
  --tracking-heading: 0.01px;
  --text-heading-lg: 40px;
  --leading-heading-lg: 1.2;
  --tracking-heading-lg: -0.035px;
  --text-display: 64px;
  --leading-display: 1;
  --tracking-display: -0.035px;

  /* Spacing */
  --spacing-4: 4px;
  --spacing-8: 8px;
  --spacing-12: 12px;
  --spacing-16: 16px;
  --spacing-20: 20px;
  --spacing-24: 24px;
  --spacing-28: 28px;
  --spacing-32: 32px;
  --spacing-40: 40px;
  --spacing-44: 44px;
  --spacing-48: 48px;
  --spacing-64: 64px;
  --spacing-80: 80px;
  --spacing-96: 96px;

  /* Border Radius */
  --radius-md: 6px;
  --radius-xl: 12px;
  --radius-2xl: 16px;
  --radius-3xl: 24px;
  --radius-full: 48px;
  --radius-full-2: 60px;
}
```
