<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-2">Dashboard</h3>
            <h6 class="op-7 mb-2"> Hi, <?= $userLogin['username']  ?>! <span class="ms-1 fs-6 text-secondary"><i class="fas fa-calendar"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" class="btn btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#addUserModal"> <i class="fas fa-plus"></i> Add User</a>
            <a href="#" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#addArticleModal"><i class="fas fa-plus"></i> Add Article</a>
        </div>
    </div>
    <div class="row">
        <!-- Users -->
        <div class="col">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-black bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Users</p>
                                <h4 class="card-title"><?= $total_users; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blogs -->
        <div class="col">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-black bubble-shadow-small">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Blogs</p>
                                <h4 class="card-title"><?= $total_articles; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Categories -->
        <div class="col">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-black bubble-shadow-small">
                                <i class="fas fa-bookmark"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Categories</p>
                                <h4 class="card-title"><?= $total_categories; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tags -->
        <div class="col">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-black bubble-shadow-small">
                                <i class="fas fa-tags"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Tags</p>
                                <h4 class="card-title"><?= $total_tags; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Media -->
        <div class="col">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-black bubble-shadow-small">
                                <i class="fas fa-images"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Media</p>
                                <h4 class="card-title"><?= $total_media; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Blogs -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round" id="RecentBlogs">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <h4>Recent Blogs</h4>
                        <div class="card-tools">
                            <button class="btn btn-icon btn-link btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                                <span class="fas fa-comments text-decoration-none fs-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Article"></span>
                            </button>
                            <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh">
                                <span class="fa fa-sync-alt text-decoration-none"></span>
                            </button>
                        </div>
                    </div>
                    <p class="card-category">
                        Explore our latest blog posts for fresh insights and updates on trending topics.
                    </p>
                </div>
                <div class="card-body">
                    <?php if ($latests_articles > 0) : ?>
                        <?php foreach ($latests_articles as $article): ?>
                            <div class="card shadow-none">
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php if ($article['image']) : ?>
                                            <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" class="img-fluid rounded-start mt-3" alt="img" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $article['id'] ?>">
                                            <!-- Modal Image Articles -->
                                            <div class="modal modal-img fade" id="imageZoom<?= $article['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageZoomLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bg-transparent">
                                                        <div class="modal-header border border-0 d-flex justify-content-center align-items-center position-relative">
                                                            <h5 class="text-white fw-bold m-0 text-center w-100"><?= $article['title']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" alt="" class="img-fluid mt-2 mx-auto" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $article['id'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/images/noimage.jpeg') ?>" class="img-fluid rounded-start mt-3" alt="img">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-9">
                                                <h4>
                                                    <a href="<?= base_url('articles/'), $article['slug'] ?>" class="text-dark"><?= $article['title']; ?></a>
                                                </h4>
                                            </div>
                                            <div class="col-2 p-2">
                                                <a href="<?= base_url('articles/update/'), $article['id'] ?>" class="text-primary me-3 ms-5"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteArticlesModal" data-id="<?= $article['id'] ?>"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                            <div class="col-12">
                                                <p><?= word_limiter($article['content'], 20); ?></p>
                                                <div class="d-flex justify-content-between">
                                                    <div class="fw-lighter">
                                                        <?php if ($article['user_image']) : ?>
                                                            <img src="data:image/jpeg;base64, <?= base64_encode($article['user_image']); ?>" class="img-fluid rounded-circle me-1" style="width: 25px; height: 25px; object-fit: cover;" alt="img">
                                                        <?php else : ?>
                                                            <i class="fas fa-user-circle fs-4 me-1 text-dark"></i>
                                                        <?php endif; ?>
                                                        <span class="text-body-secondary">
                                                            <a href="<?= base_url('users/update/'). $article['user_id'] ?>"><?= $article['username'] ?> </a>
                                                            <span class="ms-1">  
                                                                <i class="fas fa-calendar me-1"></i>
                                                                <?= date('l, d F Y, H:i', strtotime($article['created_at'])); ?>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="pagination">
                            <?= $pager_links ?>
                        </div>
                    <?php else: ?>
                        <p>No recent blogs available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Tables -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <h4 class="card-title">Users</h4>
                        <div class="card-tools">
                            <button class="btn btn-icon btn-link btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <span class="fas fa-user-plus" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add user"></span>
                            </button>
                            <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh">
                                <span class="fa fa-sync-alt text-decoration-none"></span>
                            </button>
                        </div>
                    </div>
                    <p class="card-category">
                        View and manage all users here. Use search and filters to find what you need.
                    </p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-hover table-sales">
                        <table id="Usertable" class="table table-striped table-hover nowrap" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-center text-capitalize">No</th>
                                    <th class="text-center text-capitalize">Username</th>
                                    <th class="text-center text-capitalize">Status</th>
                                    <th class="text-center text-capitalize">Roles</th>
                                    <th class="text-center text-capitalize">Email</th>
                                    <th class="text-center fw-bold"><i class="fas fa-cogs"></i></th>
                                    <th class="text-center text-capitalize">Date Created</th>
                                    <th class="text-center text-capitalize">Last Modified</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/modals/users/add') ?>
<?= $this->include('admin/modals/articles/add') ?>
<?= $this->include('admin/modals/users/delete') ?>
<?= $this->include('admin/modals/articles/delete') ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#Usertable').DataTable({
            processing: true,
            responsive: true,
            serverSide: false,
            ordering: true,
            order: [[0, 'asc']],
            ajax: {
                url: '<?php echo base_url('dashboard/getUsers'); ?>',
                type: 'GET',
                dataSrc: 'data',
            },
            columns: [
                { 
                    data: 'no',
                    "render": function (data, type, row, meta) {
                        return '<div class="text-center fw-lighter">' + data + '. </div>'; // Menampilkan nomor urut
                    }
                },
                { 
                    data: 'username',
                    render: function (data, type, row) {
                        return '<div class="">' + data + '</div>'
                    }
                },
                { 
                    data: 'status',
                    render: function (data, type, row) {
                        if (data == 'online') {
                            return '<div class="text-center text-capitalize fw-lighter"><button class="btn btn-sm rounded-pill btn-success">' + data + '</button></div>';
                        } else {
                            return '<div class="text-center text-capitalize fw-lighter"><button class="btn btn-sm rounded-pill btn-danger">' + data + '</button></div>';
                        }   
                    }
                },
                {   
                    data: 'roles',
                    render: function (data, type, row) {
                        return '<div class="text-center fw-lighter text-capitalize">' + data + '</div>'
                    }
                },
                { 
                    data: 'email',
                    render: function (data, type, row) {
                        return '<a href="mailto:'+ data +'" class="btn btn-outline-primary btn-sm"><i class="fas fa-envelope"></i> Email</a>';
                    }
                },
                { data: 'actions' },
                { 
                    data: 'date_created',
                    render: function (data, type, row) {
                        return '<div class="text-center fw-lighter">' + formatDate(data) + '</div>'
                    }
                },
                { 
                    data: 'last_modified',
                    render: function (data, type, row) {
                        if (!data) {
                            return '<div class="text-center fw-lighter">Blank</div>';
                        } else {
                            return '<div class="text-center fw-lighter">' + formatDate(data) + '</div>';
                        }
                    }
                },
            ],
            columnDefs: [{
                defaultContent: "Blank",
                targets: "_all"
            }]
        });

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

        $('#deleteUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            var deleteUrl = '<?= base_url("users/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
        $('#deleteArticlesModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("articles/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
    });
</script>
<?= $this->endSection(); ?>
