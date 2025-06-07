# SRUB_CLEAN

This repository contains the source code for the **Scrub Clean** web site. The front-end assets are built using Vite and Tailwind CSS and the back-end logic is implemented in PHP.

## Building assets

Run the build step to generate the production CSS files under `assets/dist`:

```bash
npm run build
```

The project already includes the generated files, but running the build will ensure they match your current Node environment.

## Deployment notes

The application entry point is `index.php` at the repository root. Make sure your web server points to this file. In production, error reporting is disabled by default.

The compiled CSS files are stored in `assets/dist`. No additional build steps are required for deployment.
