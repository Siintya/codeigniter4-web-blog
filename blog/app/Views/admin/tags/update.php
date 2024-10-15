<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="text-capitalize fw-bold mb-2"> Update Tags </h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button class="btn btn-dark btn-refresh btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh page">
            <span class="fa fa-sync-alt text-decoration-none"></span>
        </button>
        <a href="<?= base_url('tags') ?>" class="btn btn-label-secondary btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="<?= base_url('tags/update/'.$tag['id']) ?>" method="post" class="form row g-4">
            <?= csrf_field() ?>
            <!----------- 
                Tags
            ------------>
            <div class="col-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control pe-2" name="name" value="<?= old('name') ?? $tag['name'] ?>">
                <?php if(session()->has('error') && isset(session('error')['name'])): ?>
                    <div class="text-danger mt-2"><?= session('error')['name'] ?></div>
                <?php endif; ?>
            </div>
            <div class="col-3 mb-3">
                <label for="created_at" class="form-label">Date Created</label>
                <?php if (!empty($tag['created_at'])) : ?>
                    <input type="text" class="form-control" name="created_at" value="<?= old('created_at') ?? date('d-m-Y H:i', strtotime($tag['created_at'])) ?>" readonly>
                <?php else : ?>
                    <input type="text" class="form-control" name="created_at" value="-" readonly>
                <?php endif ;?>
            </div>
            <div class="col-3">
                <label for="updated_at" class="form-label">Last Modified</label>
                <input type="text" class="form-control" id="updated_at" value="<?= old('updated_at') ? date('d-m-Y H:i', strtotime(old('updated_at'))) : (isset($tag['updated_at']) ? date('d-m-Y H:i', strtotime($tag['updated_at'])) : 'Blank') ?>" readonly>
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ;?>">
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-between mb-5 mt-1">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!---------------  
                Articles Tags
            ----------------->
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between">
                    <h3 class="text-capitalize fw-bold">Articles</h3>
                    <button type="button" class="btn btn-label-primary" data-bs-toggle="modal" data-bs-target="#addArticleModal"><i class="fas fa-plus"></i> Add Article</button>
                </div>
                <hr>
                
                <?php if (session()->has('success-tag')) : ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session('success-tag') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->has('error-tag')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session('error-tag') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($article_tag)) : ?>
                    <table id="articleTable" class="table table-striped table-hover nowrap display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center text-capitalize">No</th>
                                <th class="text-center text-capitalize">Title</th>
                                <th class="text-center text-capitalize">Author</th>
                                <th class="text-center text-capitalize">Date Created</th>
                                <th class="text-center text-capitalize">Last Modified</th>
                                <th class="text-center"><i class="fas fa-cogs"></i</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($article_tag as $data) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td>
                                        <a href="<?= base_url('articles/' . $data['article_slug']) ?>" class="text-capitalize">
                                            <?= strlen($data['article_slug']) > 30 ? substr($data['article_slug'], 0, 30) . '...' : $data['article_slug'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('users/update/'). $data['user_id'] ?>" class="text-decoration-underline"><?= $data['username'] ?></a>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($data['articles_tags_created_at']) ? date('d-m-Y H:i', strtotime($data['articles_tags_created_at'])) : 'Blank' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($data['articles_tags_updated_at']) ? date('d-m-Y H:i', strtotime($data['articles_tags_updated_at'])) : 'Blank' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('articles/update/'), $data['article_id'] ?>" class="text-primary"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteArticleModal" data-id="<?= $data['articles_tags_id'] ?>"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <table class="table table-striped mt-4">
                        <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Author</th>
                                    <th class="text-center">Date Created</th>
                                    <th class="text-center">Last Modified</th>
                                    <th class="text-center"><i class="ti ti-settings fs-6"></i></th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">Data no available</td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif ;?>
            </div>
        </form>
    </div>
</div>

<!-- Modal Button Add Article -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel"> 
                    <i class="ti ti-plus"></i>Add Article
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('tags/create/article/'.$tag['id']) ?>" method="post" class="form row g-4">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="article" class="form-label">Title</label>
                        <select class="form-select" name="article" id="article">
                            <?php if (empty($articles)) : ?>
                                <option value="" selected>No articles available</option>
                            <?php elseif ($all_articles_used) : ?>
                                <option value="" selected>All articles are used</option>
                            <?php else : ?>
                                <?php foreach($articles as $article) : ?>
                                    <?php if (!$is_used[$article['id']]) : ?>
                                        <option value="<?= $article['id'] ?>"><?= $article['title'] ;?></option>
                                    <?php endif ;?>
                                <?php endforeach ;?>
                                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript">
 $(document).ready(function() {
    $('#articleTable').DataTable({
        responsive: true,
        paging:true,
        order:true,
        search:true
    });
    $('#deleteArticleModal').on('show.bs.modal', function (event) {
        var button      = $(event.relatedTarget);
        var id          = button.data('id');
        var modal       = $(this);
        var deleteUrl   = '<?= base_url("tags/delete/article/") ?>' + id;
        modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
    });

    <?php if (session()->has('errors')): ?>
        <?php $error_modal = session('error_modal'); ?>
        <?php if (strpos($error_modal, 'add_') !== false): ?>
            var addContentId = '<?= str_replace('add_', '', $error_modal) ?>';
            $('#addArticleModal' + addContentId).modal('show');
        <?php endif; ?>
    <?php endif; ?>
});
</script>
<?= $this->include('admin/modals/tags/delete_article') ?>
<?= $this->endSection(); ?>