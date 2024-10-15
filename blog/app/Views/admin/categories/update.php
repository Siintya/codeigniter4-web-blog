<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="text-capitalize fw-bold mb-2"> Update Category </h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button class="btn btn-dark btn-refresh btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh page">
            <span class="fa fa-sync-alt text-decoration-none"></span>
        </button>
        <a href="<?= base_url('categories') ?>" class="btn btn-label-secondary btn-icon ms-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="<?= base_url('categories/update/'.$category['id']) ?>" method="post" class="form row g-4">
            <?= csrf_field() ?>
            <div class="row g-4">
                <!---------- 
                    Category
                ------------->
                <div class="col-1g-12">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control pe-2" name="name" value="<?= old('name') ?? $category['name'] ?>">
                            <?php if(session()->has('error') && isset(session('error')['name'])): ?>
                                <div class="text-danger mt-2"><?= session('error')['name'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control pe-2" name="slug" value="<?= old('slug') ?? $category['slug'] ?>" readonly>
                            <?php if(session()->has('error') && isset(session('error')['slug'])): ?>
                                <div class="text-danger mt-2"><?= session('error')['slug'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10"><?= old('description') ?? $category['description'] ?></textarea>
                            <?php if(session()->has('error') && isset(session('error')['description'])): ?>
                                <div class="text-danger mt-2"><?= session('error')['description'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <label for="created_at" class="form-label">Date Created</label>
                                    <input type="text" class="form-control" name="created_at" value="<?= old('created_at') ?? date('d-m-Y H:i', strtotime($category['created_at'])) ?>" readonly>
                                </div>
                                <div class="col-sm-12">
                                    <label for="updated_at" class="form-label">Last Modified</label>
                                    <input type="text" class="form-control" id="updated_at" value="<?= old('updated_at') ? date('d-m-Y H:i', strtotime(old('updated_at'))) : (isset($category['updated_at']) ? date('d-m-Y H:i', strtotime($category['updated_at'])) : 'Blank') ?>" readonly>
                                    <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <!------------------------
                    Articles Categories
                ------------------------->
                <div class="col-lg-12 mb-3 mt-5" id="articleCategory">
                    <div class="d-flex justify-content-between">
                        <h3 class="text-capitalize fw-bold">Articles</h3>
                        <button type="button" class="btn btn-label-primary" data-bs-toggle="modal" data-bs-target="#addArticleCategoriesModal"><i class="fas fa-plus"></i> Add Article</button>
                    </div>
                    <hr>

                    <table id="articlesTable" class="table table-striped table-hover nowrap display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center text-capitalize">No</th>
                                <th class="text-center text-capitalize">Title</th>
                                <th class="text-center text-capitalize">Author</th>
                                <th class="text-center text-capitalize">Date Created</th>
                                <th class="text-center text-capitalize">Last Modified</th>
                                <th class="text-center"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($articles_categories != NULL) : ?>
                                <?php $no = 1; foreach ($articles_categories as $data) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td>
                                        <a href="<?= base_url('articles/' . $data['articles_slug']) ?>" class="text-capitalize">
                                            <?= strlen($data['articles_title']) > 40 ? substr($data['articles_title'], 0, 40) . '...' : $data['articles_title'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('users/update/'), $data['users_id'] ?>" class="text-decoration-underline"><?= $data['username'] ?></a>
                                    </td>
                                    <td class="text-center"><?= !empty($data['articles_created_at']) ? date('d-m-Y H:i', strtotime($data['articles_created_at'])) : 'Blank' ?></td>
                                    <td class="text-center"><?= !empty($data['articles_updated_at']) ? date('d-m-Y H:i', strtotime($data['articles_updated_at'])) : 'Blank' ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('articles/update/'), $data['articles_id'] ?>" class="text-primary"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteArticlesCategoriesModal" data-id="<?= $data['articles_categories_id'] ?>"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Data not available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Button Add Article -->
<div class="modal fade" id="addArticleCategoriesModal" tabindex="-1" aria-labelledby="addArticleCategoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleCategoriesModalLabel"> 
                    <i class="fas fa-plus"></i> Add Article
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (session()->has('error')): ?>
                    <script>
                        $(document).ready(function() {
                            $('#addArticleCategoriesModal').modal('show');
                        });
                    </script>
                <?php endif; ?>
                <form action="<?= base_url('categories/create/article/'.$category['id']) ?>" method="post" class="form row g-4">
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
<?= $this->include('admin/modals/categories/delete_article') ?>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#articlesTable').DataTable({
            responsive:true,
            paging: true,
            ordering: true,
        });
    });
</script>
<?= $this->endSection(); ?>
