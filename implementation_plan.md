# Implementation Plan - Company Profile Homepage Design

This plan outlines the design and implementation of a premium, modern homepage for a company profile. We will build it under the theme of **Nanas Home Studio** (a creative agency specializing in design, tech, and branding). We will construct a lightweight PHP MVC framework skeleton in `nanascms` to route and render the page properly, and we will style it using **Tailwind CSS v4** with a dark, premium theme featuring amber/orange accents (the "Nanas" yellow/orange brand colors).

## Design Concept: Nanas Home Studio
- **Aesthetic Direction**: *Premium Dark Cyber-Organic*. We combine a clean dark-mode background (slate-950/zinc-900) with glowing Tailwind CSS amber and emerald accents.
- **Typography**: Display serif/sans hybrid typography (using *Plus Jakarta Sans* for modern clean layouts, paired with elegant *Syne* or *Clash Display* styles).
- **Layout**: Asymmetric grids, glassmorphism card components, custom hover micro-interactions, floating background blobs (gradient meshes), and custom animated SVG graphics.
- **Tone**: Professional, modern, and creative.

---

## Proposed Changes

### 1. Framework Core & Routing
To support rendering the homepage through the CMS structure, we will implement simple MVC routing:

#### [NEW] [Router.php](file:///var/www/html/nanascms/core/Router.php)
- Implement a basic PHP router that maps GET/POST requests to controllers and actions.
- Auto-extract request URI and execute the corresponding class method.

#### [NEW] [Controller.php](file:///var/www/html/nanascms/core/Controller.php)
- Implement the base controller class with a `view` helper to include views and pass data variables.

#### [MODIFY] [index.php](file:///var/www/html/nanascms/public/index.php)
- Set up a simple PHP autoloader for `core/` and `app/` files.
- Define the home route (`/`) mapping to `HomeController@index`.
- Resolve the route.

---

### 2. Controllers & Views

#### [NEW] [HomeController.php](file:///var/www/html/nanascms/app/Controllers/HomeController.php)
- Define a controller that handles the home request and renders the main homepage.

#### [NEW] [main.php](file:///var/www/html/nanascms/app/Views/layout/main.php)
- Master layout view.
- Include Google Fonts (*Plus Jakarta Sans* and *Outfit* / *Cabinet* style).
- Include Tailwind CSS output file `/assets/css/style.css`.
- Render a header navigation bar (with scroll backdrop blur) and a footer.

#### [NEW] [home.php](file:///var/www/html/nanascms/app/Views/home.php)
- The main company profile sections:
  1. **Hero Section**: Large, bold headline, interactive CTA buttons, and an animated glow effect representing digital innovation.
  2. **Services Grid**: Interactive cards for Web Development, Brand Identity, AI Integration, and UI/UX design. Uses Tailwind hover transitions.
  3. **Stats & About**: Dynamic number counters, elegant grid layout showcasing agency philosophy.
  4. **Portfolio Showcase**: Visual grid featuring simulated premium project cards (interactive hover zoom, tags).
  5. **Testimonials**: Clean, elegant masonry/cards for reviews.
  6. **Interactive Contact Section**: Modern form layout with sleek floating input labels and interactive submit button.

---

### 3. Styling & Compilation

#### [MODIFY] [input.css](file:///var/www/html/nanascms/src/input.css)
- Define Tailwind v4 theme variables, animations, custom cursors, and glow keyframes.
- Add utility classes for glassmorphism panels, glow backdrops, and gradient meshes.

---

## Verification Plan

### Automated/Compiler Verification
- Run Tailwind CSS build command:
  ```bash
  npm run build
  ```
  Ensure it compiles without error and writes to `/var/www/html/nanascms/public/assets/css/style.css`.

### Manual Verification
- We can inspect the output code files.
- If a local PHP server is started, we can preview the layout. We will verify responsiveness, dark/light theme details, Tailwind classes, and semantic correctness.
