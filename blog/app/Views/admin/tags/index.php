<!-- app/Views/admin/pages/index.php -->

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-2">Tags</h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button type="button" class="btn btn-label-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addTagModal">
            <i class="fas fa-plus"></i> Add Tag
        </button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table id="Tagtable" class="table table-striped table-hover nowrap" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center text-capitalize">No.</th>
                    <th class="text-center text-capitalize">Name</th>
                    <th class="text-center text-capitalize">Date Created</th>
                    <th class="text-center text-capitalize">Last Modified</th>
                    <th class="text-center"><i class="fas fa-cogs"></i></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?= $this->include('admin/modals/tags/add') ?>
<?= $this->include('admin/modals/tags/delete') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#Tagtable').DataTable({
            processing: true,
            responsive: true,
            serverSide: false,
            ordering: true,
            data: <?= json_encode($tags) ?>, 
            columns: [
                { 
                    "data": null, 
                    "render": function (data, type, row, meta) {
                        return '<div class="text-center">' + (meta.row + 1 ) + '. </div>'; // Menampilkan nomor urut
                    }
                },
                { 
                    "data": "name",
                    "render": function (data, type, row, meta) {
                        return '<div class="text-capitalize">' + data + '</div>' ;
                    }
                },
                { 
                    "data": "created_at",
                    "render": function (data, type, row) {
                        return '<div class="text-center">' + formatDate(data) + '</div>'; // Memformat tanggal
                    }
                },
                { 
                    "data": "updated_at",
                    "render": function (data, type, row) {
                        if (!data) {
                            return '<div class="text-center">Blank</div>';
                        } else {
                            return '<div class="text-center">' + formatDate(data) + '</div>';
                        }
                    }
                },

                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<div class="text-center"><a href="<?= base_url("tags/update/") ?>' + row.id + '" class="text-primary"><i class="fas fa-edit"></i></a>' + '<a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteTagModal" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i></a></div>';
                    }

                }
            ],
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
                        
        });
    });
</script>
<?= $this->endSection(); ?>