<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title ?></title>
    <!-- <link rel="shortcut icon" type="image/png" href="<?=  base_url('assets') ?>/images/logos/favicon.png" /> -->
    <link rel="stylesheet" href="<?=  base_url('assets') ?>/css/styles.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <?= $this->renderSection('css') ?>
    <style class="type/css">
        body{
            background-color: #F1F1F1;
        }
        .lexend-exa {
            font-family: "Lexend Exa", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
        .fade-out {
            transition: opacity 0.5s ease-out;
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?= $this->include('templates/sidebar') ?>
        <div class="body-wrapper">
            <?= $this->include('templates/topbar') ?>
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    
    <script src="<?=  base_url('assets') ?>/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?=  base_url('assets') ?>/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=  base_url('assets') ?>/js/sidebarmenu.js"></script>
    <script src="<?=  base_url('assets') ?>/js/app.min.js"></script>
    <script src="<?=  base_url('assets') ?>/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="<?=  base_url('assets') ?>/libs/simplebar/dist/simplebar.js"></script>
    <script src="<?=  base_url('assets') ?>/js/dashboard.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script> -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="<?= base_url('/vendor/ckeditor5/ckeditor.js') ?>"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
        });
    </script>
    <?= $this->renderSection('js') ?>
    
   
</body>
</html>