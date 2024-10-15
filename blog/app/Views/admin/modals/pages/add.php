<!-- Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPageModalLabel"> 
                    <i class="fas fa-plus"></i> Add Page
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pages/create') ?>" method="post" class="form row g-4" enctype="multipart/form-data">
                    <div class="col-lg-8 mb-2">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control pe-2 <?= (isset(session('errors')['title'])) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?= old('title') ?>">
                        <?php if(isset(session('errors')['title'])): ?>
                            <div id="title" class="text-danger invalid-feedback mt-2"><?= session('errors')['title'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control pe-2 <?= (isset(session('errors')['slug'])) ? 'is-invalid' : ''; ?>" name="slug" value="<?= old('slug') ?>" readonly>
                        <?php if(isset(session('errors')['slug'])): ?>
                            <div id="slug" class="text-danger invalid-feedback mt-2"><?= session('errors')['slug'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control <?= (isset(session('errors')['content'])) ? 'is-invalid' : ''; ?>" id="content" name="content" cols="30" rows="10"><?= old('content') ?></textarea>
                        <?php if(isset(session('errors')['content'])): ?>
                            <div id="content" class="text-danger invalid-feedback mt-2"><?= session('errors')['content'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-7 mb-4">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control <?= (isset(session('errors')['image'])) ? 'is-invalid' : ''; ?>" onchange="previewImage(event)">
                        <img src="" class="image-preview mt-3 rounded" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                        <?php if(isset(session('errors')['image'])): ?>
                            <div id="image" class="text-danger invalid-feedback mt-2"><?= session('errors')['image'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <label for="statuses" class="form-label">Status</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="statuses" id="publish" value="publish" checked>
                                        <label class="form-check-label" for="publish">Publish</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="statuses" id="private" value="private">
                                        <label class="form-check-label" for="private">Private</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="created_at" class="form-label">Created</label>
                                <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i') ?>" readonly>
                                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
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