<?php
global $themeColors;
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cleanesta Cleaning Services - Spotless Every Time</title>
<link rel="icon" type="image/png" href="/assets/images/logo/cleanesta-services-logo.png">
<link rel="stylesheet" href="/assets/css/main-min.css">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="/assets/js/main.js"></script>
<style type="text/tailwindcss">
  :root {
    --color-primary: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;
    --color-secondary: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;
    --color-accent: <?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>;
    --color-neutral: <?php echo $themeColors['neutral'] ?? '#ffffff'; ?>;
    --color-dark: <?php echo $themeColors['dark'] ?? '#1f1f1f'; ?>;
  }
</style>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/theme.php'; ?>
<?php /* <link rel="stylesheet" href="/assets/css/theme.css"> */ ?>