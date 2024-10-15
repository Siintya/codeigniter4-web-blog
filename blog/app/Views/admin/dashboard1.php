<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row g-3">
    <div class="col-lg-12">
        <!-------------- 
        Username Login
        --------------->
        <div class="mb-5 mb-sm-0">
            <h1 class="fw-bold display-6 lexend-exad">
                    Hi, <?= session()->get('username'); ?>! <span style="font-size:20px;color:gray;"><i class="ti ti-calendar-event"></i> <?= date('l, d F Y, H:i'); ?></span>
            </h1>
        </div>
    </div>
    <!-------------- 
        Users Total 
    --------------->
    <div class="col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-7 ms-2">
                        <h2 class="fw-semibold mb-3"><?= $total_users; ?></h2>
                        <h4 class="card-title mb-9 fw-semibold">Users</h4>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <i class="ti ti-users display-3 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------- 
        Blogs Total 
    --------------->
    <div class="col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-7 ms-2">
                        <h2 class="fw-semibold mb-3"><?= $total_articles; ?></h2>
                        <h4 class="card-title mb-9 fw-semibold">Blogs</h4>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <i class="ti ti-article display-3 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------- 
        Categories Total 
    --------------->
    <div class="col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-7 ms-2">
                        <h2 class="fw-semibold mb-3"><?= $total_categories; ?></h2>
                        <h4 class="card-title mb-9 fw-semibold">Categories</h4>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <i class="ti ti-bookmarks display-3 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------- 
        Tags Total 
    --------------->
    <div class="col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-7 ms-2">
                        <h2 class="fw-semibold mb-3"><?= $total_tags; ?></h2>
                        <h4 class="card-title mb-9 fw-semibold">Tags</h4>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <i class="ti ti-tag display-3 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="article">
    <!-------------- 
        Recent Blogs
    --------------->
    <div class="col-lg-9 d-flex align-items-stretch mt-4">
        <div class="card w-100" id="RecentBlogs">
            <div class="card-header bg-transparent border-bottom">
                <h2 class="fw-semibold">Recent Blogs</h2>
            </div>
            <div class="card-body">
                <?php if (session()->has('success-article')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session('success-article') ?>
                    </div>
                <?php elseif (session()->has('error-article')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error-article') ?>
                    </div>
                <?php endif; ?>

                <?php if ($latests_articles > 0) : ?>
                    <?php foreach ($latests_articles as $article): ?>
                        <div class="card shadow-none">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php if ($article['image']) : ?>
                                        <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" class="img-fluid rounded-start mt-3" alt="img" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $article['id'] ?>">
                                        <!-- Modal Image Articles -->
                                        <div class="modal fade" id="imageZoom<?= $article['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageZoomLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="fw-bold"><?= $article['title'] ;?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" alt="" class="img-fluid mt-2" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $article['id'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <img src="<?= base_url('assets/images/noimage.jpeg') ?>" class="img-fluid rounded-start mt-3" alt="img">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="row">
                                           <div class="col-sm-10">
                                                <h3 class="card-title">
                                                    <a href="<?= base_url('articles/'), $article['slug'] ?>" class="text-dark"><?= $article['title']; ?></a>
                                                </h3>
                                           </div>
                                            <div class="col-sm-2">
                                                <a href="<?= base_url('articles/update/'), $article['id'] ?>" class="btn btn-warning btn-sm rounded-circle me-2"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#deleteArticlesModal" data-id="<?= $article['id'] ?>"><i class="ti ti-trash"></i></a>
                                            </div>
                                        </div>
                                        <p class="card-text"><?= word_limiter($article['content'], 50); ?></p>
                                        <div class="card-text d-flex justify-content-between">
                                            <div>
                                                <?php if ($article['user_image']) : ?>
                                                    <img src="data:image/jpeg;base64, <?= base64_encode($article['user_image']); ?>" class="img-fluid rounded-circle round-image-30 me-1" alt="img">
                                                <?php else : ?>
                                                    <i class="ti ti-user"></i>
                                                <?php endif; ?>
                                                <small class="text-body-secondary">
                                                    <a href="<?= base_url('users/update/'). $article['user_id'] ?>"><?= $article['username'] ?> </a>
                                                    <span class="ms-1">  
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="8"  height="8"  viewBox="0 0 24 24"  fill="#808080"  class="icon icon-tabler icons-tabler-filled icon-tabler-circle mb-1 me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" /></svg>
                                                        <?= date('l, d-m-Y H:i', strtotime($article['created_at'])); ?>
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="pagination">
                        <?= $pager_links; ?>
                    </div>
                <?php endif ;?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Media Total -->
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-7 ms-2">
                                <h2 class="fw-semibold mb-3"><?= $total_media; ?></h2>
                                <h4 class="card-title mb-9 fw-semibold">Media</h4>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="d-flex align-items-center justify-content-end">
                                    <i class="ti ti-bookmarks display-3 text-dark"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <!-- Online Users -->
                <div class="card">
                    <div class="card-body">
                        <div class="row g-0 align-items-start">
                            <div class="col-12 d-flex justify-content-between">
                                <h5 class="card-title mb-9 fw-semibold lexend-exad"> Online Users </h5>
                            </div>
                            <?php if (count($online_users) > 0) : ?>
                                <?php foreach ($online_users as $u) :?>
                                    <div class="col-12 d-flex align-items-start justify-content-between pb-1">
                                        <p class="fw-semibold text-dark"><i class="ti ti-user me-2"></i> <?= $u['username']; ?></p>
                                        <span class="round-8 bg-success rounded-circle mt-2 d-inline-block"></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                None of the users is online. 
                            <?php endif ;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-------------- 
    New Users
--------------->
<div class="row" id="user">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-header bg-transparent border-bottom">
                <h2 class="lexend-exad fw-semibold">New Users</h2>
            </div>
            <div class="card-body p-4">
                <?php if (session()->has('success-user')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session('success-user') ?>
                    </div>
                <?php elseif (session()->has('error-user')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error-user') ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Roles</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Last Modified</th>
                                <th class="text-center fw-bold"><i class="ti ti-settings fs-6"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($latest_users > 0) : ?>
                                <?php $no = 1; foreach ($latest_users as $user) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?>.</td>
                                        <td><?= $user['username']; ?></td>
                                        <td>
                                            <?php if ($user['statuses'] == 'online') : ?>
                                                <button class="btn btn-sm btn-success rounded-pill" type="button"><?= $user['statuses']; ?></button>
                                            <?php else : ?>
                                                <button class="btn btn-sm btn-light rounded-pill" style="background-color:lightgray;color:gray;" type="button"><?= $user['statuses']; ?></button>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-capitalize"><?= $user['role']; ?></td>
                                        <td>
                                            <a href="mailto:<?= $user['email']; ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="ti ti-mail"></i> Email
                                            </a>
                                        </td>
                                        <td><?= date('d-m-Y H:i', strtotime($user['created_at'])); ?></td>
                                        <td><?= date('d-m-Y H:i', strtotime($user['updated_at'])); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('users/update/'), $user['id'] ?>" class="btn btn-warning btn-sm rounded-pill"><i class="ti ti-pencil"></i></a>
                                            <button type="button" class="btn btn-sm btn-danger rounded-circle ms-2" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="<?= $user['id'] ?>">
                                                <i class="ti ti-trash fs-3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td class="text-center" colspan="8">Data no available</td>
                                </tr>
                            <?php endif ;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= $this->include('admin/modals/articles/delete') ?>
<?= $this->include('admin/modals/users/delete') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#userTable').DataTable({
            responsive:true,
            paging: false,
            order: true,
        });


        $('.switch-status').each(function() {
            var $switch = $(this);
            var $label = $switch.next('.form-check-label').find('.switch-status-label');
            var articleId = $switch.data('article-id');
            
            // Set nilai input dan label status saat halaman dimuat
            if ($switch.is(':checked')) {
                $label.text($label.data('online'));
            } else {
                $label.text($label.data('offline'));
                $switch.val('private');
            }

            $switch.change(function() {
                var status = $switch.is(':checked') ? 'publish' : 'private';
                $label.text(status);

                $.ajax({
                    url: "<?php echo base_url('articles/update_status'); ?>/" + articleId,
                    type: "POST",
                    data: {
                        statuses: status,
                        <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                    },
                    success: function(response) {
                        // console.log(response); // Handle success response

                        // Add fade-out animation to the article content
                        $('#article-' + articleId).addClass('fade-out');
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Handle error response
                    }
                });
            });
        });

        $('#deleteArticlesModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("articles/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });

        $('#deleteUserModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("users/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
    });
    
</script>
<?= $this->endSection(); ?>
