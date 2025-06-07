import { defineConfig } from 'vite';

export default defineConfig({
  root: '.', // project root
  build: {
    outDir: 'assets/dist', // output directory for built assets
    emptyOutDir: true,
    rollupOptions: {
      input: [
        './assets/css/main.css',         // frontend
        './admin/assets/css/admin.css',  // admin
      ],
    },
  },
});
