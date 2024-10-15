<!-- Modal -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel"> 
                    <i class="ti ti-plus"></i>Add article
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('articles/create') ?>" class="form row g-4" method="post" enctype="multipart/form-data">
                    <div class="col-8">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control pe-2" name="title" value="<?= old('title') ?>">
                        <?php if(session()->has('errors') && isset(session('errors')['title'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['title'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control pe-2" name="slug" value="<?= old('slug') ?>" readonly>
                        <?php if(session()->has('errors') && isset(session('errors')['slug'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['slug'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-8 mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?= old('content') ?></textarea>
                        <?php if(session()->has('errors') && isset(session('errors')['content'])): ?>
                            <div class="text-danger mt-2 mb-5"><?= session('errors')['content'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" id="category" ata-value-key="id" data-search="true" data-silent-initial-value-set="true"></select>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="tag" class="form-label">Tag</label>
                                <select id="tag" name="tag[]" data-value data-varia-label="Default select example" data-live-search="true" placeholder="Select tag"></select>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" id="image" value="<?= old('image') ?>">
                                <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                                    <div class="text-danger mt-2"><?= session('errors')['image'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="statuses" class="form-label">Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statuses" id="publish" value="publish" checked>
                                    <label class="form-check-label" for="publish">Publish</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statuses" id="private" value="private">
                                    <label class="form-check-label" for="private">Private</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="created_at" class="form-label">Created</label>
                                <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i') ?>" readonly>
                                <input type="hidden" name="created_at" id="created_at" value="<?= date('Y-m-d H:i:s') ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between mt-5">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>