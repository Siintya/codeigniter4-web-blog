<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-2">Articles</h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button type="button" class="btn btn-label-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addArticleModal">
            <i class="fas fa-plus"></i> Add Article
        </button>
    </div>
</div>
<div class="card w-100 bg-0" id="user">
    <div class="card-body">
        <div class="table-responsive">
            <table id="articlesTables" class="table table-striped table-hover nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center text-capitalize">No.</th>
                        <th class="text-center text-capitalize">Title</th>
                        <th class="text-center text-capitalize">Author</th>
                        <th class="text-center text-capitalize">Status</th>
                        <th class="text-center"><i class="fas fa-cogs"></i></th>
                        <th class="text-center text-capitalize">Date Created</th>
                        <th class="text-center text-capitalize">Last Modified</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?= $this->include('admin/modals/articles/add') ?>
<?= $this->include('admin/modals/articles/delete') ?>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#articlesTables').DataTable({
            processing: true,
            responsive: true,
            serverSide: false,
            ordering: true, 
            data: <?= json_encode($articles) ?>, 
            columns: [
                { 
                    "data": null, 
                    "render": function (data, type, row, meta) {
                            return '<div class="text-center">' + (meta.row + 1 ) + '. </div>';
                        }
                    },
                {
                    "data": "title",
                    "render": function(data, type, row, meta) {
                        var baseUrl = "<?php echo base_url('articles/'); ?>";
                        var slug = row.slug || ''; // Pastikan slug ada
                        var truncatedTitle = data ? (data.length > 40 ? data.substr(0, 40) + '...' : data) : 'No Title'; // Tambahkan pengecekan data
                        return '<a href="' + baseUrl + slug + '">' + truncatedTitle + '</a>';
                    }
                },
                { 
                    "data": "author", 
                    "render": function (data, type, row, meta) {
                        var baseUrl = "<?= base_url('users/update/') ?>";
                        return '<a href="' + baseUrl + row.user_id + '" class="text-decoration-underline">' + data + '</a>' ;
                    }
                },
                { 
                    "data": "status",
                    "render": function (data, type, row) {
                        if ( data == 'publish') {
                            return '<div class="text-center"><button class="btn btn-sm text-capitalize btn-success rounded-pill">' + data + '</button></div>';
                        }else if ( data == 'draft'){
                            return '<div class="text-center"><button class="btn btn-sm text-capitalize btn-danger rounded-pill">' + data + '</button></div>';
                        }else{
                            return '<div class="text-center"><button class="btn btn-sm text-capitalize btn-warning rounded-pill">' + data + '</button></div>';
                        }
                    }
                },
                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<div class="text-center"><a href="<?= base_url("articles/update/") ?>' + row.id + '" class="text-primary"><i class="fas fa-edit"></i></a>' + '<a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteArticlesModal" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i></a></div>';
                    }
                },
                { 
                    "data": "created_at",
                    "render": function (data, type, row) {
                        return formatDate(data); // Memformat tanggal
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
                }
            ],
            columnDefs: [{
                "defaultContent": '<div class="text-center"><button class="btn btn-sm text-capitalize btn-label-secondary rounded-pill">Blank</button></div>',
                "targets": "_all"
            }]                
        });
    });
</script>
<?= $this->endSection(); ?>
