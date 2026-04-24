# Inkwave — Design System Documentation

## Project Overview

Inkwave is a modern blogging/writing platform with a focus on elegant typography, ambient visuals, and a distraction-free writing experience. The platform consists of:

- **Public Homepage** — Featured stories and content stream
- **Authentication** — Login and registration pages
- **Dashboard** — Writer's desk with stats and post management
- **Studio** — Distraction-free writing editor
- **Admin Panel** — User and category management

---

## Design Tokens

### Color Palette

| Token | Value | Usage |
|-------|-------|-------|
| `--bg` | `#111827` | Primary background |
| `--surface` | `#F9FAFB` | Text and surface elements |
| `--accent` | `#2563EB` | Primary accent (blue) |
| `--accent-light` | `#3b82f6` | Lighter accent variant |
| `--muted` | `#6B7280` / `#9ca3af` | Secondary/muted text |
| `--faint` | `#1f2a3c` | Subtle backgrounds |
| `--stroke` | `rgba(249, 250, 251, 0.10)` | Border color |

### Typography

| Token | Value | Usage |
|-------|-------|-------|
| `--serif` | `'Cormorant Garamond', Georgia, serif` | Headings, titles, decorative text |
| `--sans` | `'DM Sans', sans-serif` | Body text, UI elements |

### Font Sizes

- **Display**: `clamp(3rem, 7vw, 6rem)` — Hero taglines
- **H1**: `clamp(2.5rem, 5vw, 4rem)` — Page titles
- **H2**: `clamp(1.8rem, 3.5vw, 2.6rem)` — Section titles
- **Body**: `16px` — Default body text
- **Small**: `0.75rem - 0.875rem` — Captions, meta text

---

## Component Architecture

### Navigation Components

#### Main Navigation (`.site-nav`)
- Fixed top navigation bar
- Logo with brand styling
- Search button
- Login/Write links

#### Sidebar Navigation (`.sidebar`)
- Fixed left sidebar for dashboard
- Navigation groups with labels
- User card with avatar
- Logout button

### Content Components

#### Story Card (`.story-item`)
- Category label
- Title with hover underline effect
- Excerpt text
- Author info with avatar
- Read time

#### Featured Story (`.featured-story`)
- Large hero image background
- Featured label
- Title and excerpt
- Author and read link

### Form Components

#### Input Group (`.input-group`)
- Floating label pattern
- Bottom border style
- Focus state with accent color

#### Buttons
- Primary button (`.primary-btn`, `.btn-primary`)
- Ghost button (`.iw-btn-ghost`)
- CTA button (`.cta`)

### Dashboard Components

#### Stat Card (`.stat-card`)
- Icon with colored background
- Value display
- Label and meta text
- Hover elevation effect

#### Post Item (`.post-item`)
- Status indicator dot
- Title with truncation
- Meta information (category, time, views)
- Arrow icon on hover

#### Goal Card (`.goal-card`)
- Progress indicators (daily goals)
- Progress text
- Completion states

### Editor Components (Studio)

#### Page (`.page`)
- Lined paper aesthetic
- Gutter line
- Title input
- Contenteditable editor
- Word count display

#### Tool Chips (`.chip`)
- Formatting buttons (Bold, Italic, H1, H2, Quote)
- Hover states

---

## Layout System

### Grid Patterns

1. **Dashboard Grid**: `grid-template-columns: 280px 1fr` (sidebar + main)
2. **Studio Grid**: `grid-template-columns: 260px 1fr 320px` (tools + editor + preview)
3. **Stats Grid**: `grid-template-columns: repeat(4, 1fr)`
4. **Content Grid**: `grid-template-columns: 1fr 380px` (main + sidebar)

### Responsive Breakpoints

| Breakpoint | Behavior |
|------------|----------|
| `> 1024px` | Full layout with sidebars |
| `720px - 1024px` | Compressed sidebars |
| `< 720px` | Collapsed sidebars, single column |

---

## Visual Effects

### Grain Overlay
```css
body::before {
    background-image: url("data:image/svg+xml,..."); /* Noise filter */
    opacity: 0.35;
    pointer-events: none;
    z-index: 9999;
}
```

### Ambient Backgrounds
- Radial gradients for depth
- Animated floating elements
- Grid glow patterns

### Glassmorphism
- `backdrop-filter: blur(10px)`
- Semi-transparent backgrounds
- Subtle borders

### Animations

| Animation | Usage |
|-----------|-------|
| `fadeUp` | Entry animations |
| `fadeIn` | Simple fade-in |
| `scrollPulse` | Scroll hint indicator |
| `iw-float` | Floating background elements |
| `reveal` | Intersection observer fade-in |

---

## Identified Design Issues

### 1. Duplicate CSS Definitions
- `.dash-header`, `.dash-greeting`, `.dash-title` defined in both `style.css` and `dashboard.css`
- Root variables duplicated across files

### 2. Inconsistent Class Naming
- Sidebar navigation: `.sidebar` vs `.rail`
- Navigation items: `.nav-item` vs `.rail-link`
- User avatar: `.avatar` vs `.user-avatar`

### 3. SVG Icons Inline
- Multiple inline SVG icons throughout
- Should use Bootstrap Icons for consistency

### 4. Multiple CSS Files
- `style.css`, `dashboard.css`, `create-post.css`, `login.css`, `register.css`
- Should be consolidated into single file with proper organization

### 5. Class Naming Conflicts
- `.avatar` used for both story authors and dashboard user
- `.brand` used in multiple contexts with different styles
- `.field` used for both auth forms and studio

---

## Recommendations

### CSS Organization
1. Consolidate all CSS into `assets/css/style.css`
2. Use BEM-style naming convention
3. Group styles by component/section
4. Remove duplicate definitions

### Class Naming Standards
1. Use descriptive prefixes: `iw-` for Inkwave components
2. Follow pattern: `.block__element--modifier`
3. Avoid generic names like `.brand`, `.field`

### Icon System
1. Replace inline SVGs with Bootstrap Icons
2. Use CDN: `https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css`
3. Use semantic icon classes: `bi-search`, `bi-pencil`, `bi-house`, etc.

### Accessibility
1. Ensure proper ARIA labels
2. Maintain focus states
3. Support keyboard navigation
4. Ensure color contrast ratios

---

## File Structure (Recommended)

```
assets/
├── css/
│   └── style.css          # Single consolidated stylesheet
├── js/
│   └── script.js          # Main JavaScript file
└── images/
    └── favicon.ico
```

---

## Bootstrap Icons Mapping

| Current SVG | Bootstrap Icon |
|-------------|----------------|
| Search | `bi-search` |
| Arrow Right | `bi-arrow-right` |
| Document/Post | `bi-file-text` |
| Plus | `bi-plus-lg` |
| Edit/Pen | `bi-pencil` |
| Check | `bi-check-lg` |
| Eye/View | `bi-eye` |
| User | `bi-person` |
| Settings | `bi-gear` |
| Logout | `bi-box-arrow-left` |
| Grid/Dashboard | `bi-grid-1x2` |
| Chevron | `bi-chevron-right` |

---

*Document Version: 1.0*
*Last Updated: 2026*