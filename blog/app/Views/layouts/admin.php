<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <title><?= $title ?></title>
    <script src="<?= base_url('vendor') ?>/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?= base_url('vendor') ?>/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('vendor') ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('vendor') ?>/css/plugins.min.css" />
    <!-- kaiadmin.min.css -->
    <link rel="stylesheet" href="<?= base_url('vendor') ?>/css/kaiadmin.css" />
    <link rel="stylesheet" href="<?= base_url('vendor') ?>/css/demo.css" />
    <?= $this->renderSection('css') ?>
</head>
<body>
    <div class="wrapper">
        <?= $this->include('templates/sidebar') ?>

        <div class="main-panel">
            <?= $this->include('templates/topbar') ?>
            <div class="container">
                <div class="page-inner">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Logo Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Navbar Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeTopBarColor" data-color="dark"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="green"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange"></button>
                            <button type="button" class="changeTopBarColor" data-color="red"></button>
                            <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                            <button type="button" class="changeTopBarColor" data-color="grey"></button>
                            <br />
                            <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="green2"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                            <button type="button" class="changeTopBarColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeSideBarColor" data-color="white"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="selected changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="icon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>
    
    <!-- Core JS Files -->
    <script src="<?= base_url('vendor') ?>/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url('vendor') ?>/js/core/popper.min.js"></script>
    <script src="<?= base_url('vendor') ?>/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?= base_url('vendor') ?>/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    
    <!-- jQuery Sparkline -->
    <script src="<?= base_url('vendor') ?>/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Datatables -->
    <script src="<?= base_url('vendor') ?>/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="<?= base_url('vendor') ?>/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- Sweet Alert -->
    <script src="<?= base_url('vendor') ?>/js/plugin/sweetalert/sweetalert.min.js"></script>
    
    <!-- Kaiadmin JS -->
    <script src="<?= base_url('vendor') ?>/js/kaiadmin.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="<?= base_url('vendor') ?>/js/setting-demo.js"></script>
    <script src="<?= base_url('vendor') ?>/js/demo.js"></script>

    <!-- CKeditor -->
    <script src="<?= base_url('vendor/ckeditor5/ckeditor.js') ?>"></script>
    <?= $this->renderSection('js') ?>
    <script>
        // CKEditor Initialization 
        ClassicEditor
            .create(document.querySelector('#address'))
            .catch(error => {
                console.error(error);
        });
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
        });
        ClassicEditor
            .create(document.querySelector('#content-page'))
            .catch(error => {
                console.error(error);
        });
        ClassicEditor
            .create(document.querySelector('#content-add'))
            .catch(error => {
                console.error(error);
        });
        ClassicEditor
            .create(document.querySelector('#content-update'))
            .catch(error => {
                console.error(error);
        });
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
        });
        // Sweet Alert Initialization 
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (session()->has('success')) : ?>
                swal({
                    title: "Success!",
                    text: "<?= session('success') ?>",
                    icon: 'success',
                    buttons: {
                        confirm: {
                            className: "btn btn-success",
                        },
                    },
                });
            <?php endif; ?>
            <?php if (session()->has('info')) : ?>
                swal({
                    title: "Info",
                    text: "<?= session('info') ?>",
                    icon: 'warning',
                    button: {
                        text: "OK",
                        className: "btn btn-warning",
                    },
                });
            <?php endif; ?>

            const statusSwitch = document.getElementById('status');
            const statusLabel = document.querySelector('.switch-status-label');

            statusSwitch.addEventListener('change', function() {
                if (statusSwitch.checked) {
                    statusLabel.innerText = statusLabel.getAttribute('data-online');
                    statusSwitch.value = 'online';
                } else {
                    statusLabel.innerText = statusLabel.getAttribute('data-offline');
                    statusSwitch.value = 'offline';
                }
            });

            // Set nilai input dan label status saat halaman dimuat
            if (statusSwitch.checked) {
                statusLabel.innerText = statusLabel.getAttribute('data-online');
            } else {
                statusLabel.innerText = statusLabel.getAttribute('data-offline');
                statusSwitch.value = 'offline'; // Tambahkan baris ini untuk mengubah nilai input menjadi 'offline'
            }
        });

        $(document).ready(function() {
            <?php if (session()->has('errorsUser')): ?>
                $('#addUserModal').modal('show');
            <?php endif; ?>
            $('#addUserModal').on('hidden.bs.modal', function () {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
            <?php if (session()->has('errorsArticle')): ?>
                $('#addArticleModal').modal('show');
            <?php endif; ?>
            <?php if (session()->has('errors')): ?>
                $('#addPageModal').modal('show');
            <?php endif; ?>

            $('#addArticleModal').on('hidden.bs.modal', function () {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
            $('#addPageModal').on('hidden.bs.modal', function () {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
            <?php if (session()->has('errors')): ?>
                $('#addCategoryModal').modal('show');
            <?php endif; ?>
            $('#addCategoryModal').on('hidden.bs.modal', function () {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
            <?php if (session()->has('errors')): ?>
                $('#addTagModal').modal('show');
            <?php endif; ?>
            $('#addTagModal').on('hidden.bs.modal', function () {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });


            function generateSlug(param) {
                return param.toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-');
            }
            $('input[name="name"]').on('input', function() {
                var param = $(this).val();
                var slug = generateSlug(param);
                $('input[name="slug"]').val(slug);
            });
            
            $('input[name="title"]').on('input', function() {
                var param = $(this).val();
                var slug = generateSlug(param);
                $('input[name="slug"]').val(slug);
            });
        });

        
        function previewImage(event) {
            const input        = event.target;
            const imagePreview = input.closest('.row').querySelector('.image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                imagePreview.src = ''; 
                imagePreview.style.display = 'none';
            }
        };

        function formatDate(dateString) {
            var date    = new Date(dateString);
            var month   = date.getMonth() + 1;
            var day     = date.getDate();
            var year    = date.getFullYear();
            var hours   = date.getHours();
            var minutes = date.getMinutes();

            if (month < 10) month = '0' + month;
            if (day < 10) day = '0' + day;
            if (hours < 10) hours = '0' + hours;
            if (minutes < 10) minutes = '0' + minutes;

            return month + '-' + day + '-' + year + '<span class="ms-2">' + hours + ':' + minutes + '</span>';
        }

        // Delete Button
        $('#deleteArticlesCategoriesModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("categories/delete/article/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
        $('#deleteTagModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("tags/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
         $('#deleteMediaModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("media/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
        $('#deleteArticlesModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            var deleteUrl = '<?= base_url("articles/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
        $('#deletePageModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("pages/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
        $('#deleteCategoryModel').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("categories/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
    </script>
</body>
</html>
