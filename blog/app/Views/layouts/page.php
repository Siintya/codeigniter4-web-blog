<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="shortcut icon" type="image/png" href="<?=  base_url('assets') ?>/images/logos/favicon.png" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?=  base_url('assets') ?>/css/styles.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/fonts/icomoon/style.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/tiny-slider.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/aos.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/glightbox.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/style_home.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/flatpickr.min.css">
</head>
<body>
    <?= $this->renderSection('content') ?>
    <script src="<?=  base_url('assets') ?>/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?=  base_url('assets') ?>/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=  base_url('assets') ?>/js/tiny-slider.js"></script>
    <script src="<?=  base_url('assets') ?>/js/flatpickr.min.js"></script>
    <script src="<?=  base_url('assets') ?>/js/aos.js"></script>
    <script src="<?=  base_url('assets') ?>/js/glightbox.min.js"></script>
    <script src="<?=  base_url('assets') ?>/js/navbar.js"></script>
    <script src="<?=  base_url('assets') ?>/js/counter.js"></script>
    <script src="<?=  base_url('assets') ?>/js/custom.js"></script>
</body>
</html>