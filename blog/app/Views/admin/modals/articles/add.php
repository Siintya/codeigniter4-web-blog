<link rel="stylesheet" href="<?= base_url('assets/css/virtual-select.min.css') ?>">
<!-- Modal -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel"> 
                    <i class="fas fa-plus"></i> Add Article
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('articles/create') ?>" class="form row g-4" method="post" enctype="multipart/form-data">
                    <div class="col-8">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control <?= (isset(session('errorsArticle')['title'])) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?= old('title') ?>">
                        <?php if(isset(session('errorsArticle')['title'])): ?>
                            <div id="title" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsArticle')['title'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control <?= (isset(session('errorsArticle')['slug'])) ? 'is-invalid' : ''; ?>" id="slug" name="slug" value="<?= old('slug') ?>" readonly>
                        <?php if(isset(session('errorsArticle')['slug'])): ?>
                            <div id="slug" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsArticle')['slug'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control <?= (isset(session('errorsArticle')['content'])) ? 'is-invalid' : ''; ?>" name="content" id="content" cols="30" rows="10"><?= old('content') ?></textarea>
                        <?php if(isset(session('errorsArticle')['content'])): ?>
                            <div id="content" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsArticle')['content'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-8">
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control <?= (isset(session('errorsArticle')['image'])) ? 'is-invalid' : ''; ?>" onchange="previewImage(event)">
                                <img src="" class="image-preview mt-3" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;" loading="lazy">
                                <?php if(isset(session('errorsArticle')['image'])): ?>
                                    <div id="image" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsArticle')['image'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-12">
                                <label for="status" class="form-label">Status</label><br>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="publish" value="publish" checked>
                                        <label class="form-check-label" for="publish">Publish</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="draft" value="draft">
                                        <label class="form-check-label" for="draft">Draft</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="pending" value="pending">
                                        <label class="form-check-label" for="pending">Pending</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="created_at" class="form-label">Date Created</label>
                                <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i') ?>" readonly>
                                <input type="hidden" name="created_at" id="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <label class="form-label" for="categories">Category</label>
                                <select class="form-select form-control" id="category" name="category">
                                    <?php foreach ($categories as $category) :?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="tag" class="form-label">Tag</label>
                                <div class="selectgroup selectgroup-pills <?= (isset(session('errorsArticle')['tag'])) ? 'is-invalid' : ''; ?>" id="tag" name="tag">
                                    <?php foreach ($tags as $tag) :?>
                                        <label class="selectgroup-item mb-2">
                                            <input type="checkbox" name="tag[]" value="<?= $tag['id'] ;?>" class="selectgroup-input"/>
                                            <span class="selectgroup-button"><?= $tag['name'] ;?></span>
                                        </label>
                                    <?php endforeach ;?>
                                </div>
                                <?php if(isset(session('errorsArticle')['tag'])): ?>
                                    <div id="tag" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsArticle')['tag'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 modal-footer d-flex justify-content-between mt-5">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>