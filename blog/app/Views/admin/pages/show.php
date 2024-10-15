<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-2"><?= $page['title']  ?></h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d-m-Y H:i', strtotime($page['created_at'])); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <div class="ms-md-auto py-2 py-md-0">
            <a href="<?= base_url("pages/update/"), $page['id'] ?>" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit page">
                <i class="fas fa-pen"></i>
            </a>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deletePageModal" data-id="<?= $page['id'] ?>" class="btn btn-danger btn-icon ms-1">
                <span class="fas fa-trash-alt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete page"></span>
            </button>
            <a href="<?= base_url('pages') ?>" class="btn btn-label-secondary btn-icon ms-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
                <i class="fas fa-backward"></i> 
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <?php if ($page['image']) : ?>
            <div class="d-flex d-flex justify-content-center mb-5">
                <img src="data:image/jpeg;base64, <?= base64_encode($page['image']); ?>" class="img-fluid rounded" alt="img" width="300">
            </div>
        <?php endif ;?>
        <div class="content">  
            <?= $page['content'] ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<?= $this->include('admin/modals/pages/delete') ?>
<script type="text/javascript">
    $(document).ready(function() {
        function formatDate(dateString) {
            var date    = new Date(dateString);
            var month   = date.getMonth() + 1; // Bulan dimulai dari 0
            var day     = date.getDate();
            var year    = date.getFullYear();
            var hours   = date.getHours();
            var minutes = date.getMinutes();

            // Menambahkan nol di depan jika nilai kurang dari 10
            if (month < 10) {
                month = '0' + month;
            }
            if (day < 10) {
                day = '0' + day;
            }
            if (hours < 10) {
                hours = '0' + hours;
            }
            if (minutes < 10) {
                minutes = '0' + minutes;
            }

            return month + '-' + day + '-' + year + '<span class="ms-2">' + hours + ':' + minutes + '</span>';
        }
        $('#deletePageModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("pages/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
    });
</script>
<?= $this->endSection(); ?>
