<!-- Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel"> 
                    <i class="fas fa-plus"></i> Add category
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('categories/create') ?>" method="post" class="form row g-4" enctype="multipart/form-data">
                    <?= csrf_field() ;?>
                    <div class="col-8">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control pe-2 <?= (isset(session('errors')['name'])) ? 'is-invalid' : ''; ?>" name="name" value="<?= old('name') ?>">
                        <?php if(isset(session('errors')['name'])): ?>
                            <div id="name" class="text-danger invalid-feedback mt-2"><?= session('errors')['name'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control pe-2 <?= (isset(session('errors')['slug'])) ? 'is-invalid' : ''; ?>" name="slug" value="<?= old('slug') ?>" readonly>
                        <?php if(isset(session('errors')['slug'])): ?>
                            <div id="slug" class="text-danger invalid-feedback mt-2"><?= session('errors')['slug'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-8 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control <?= (isset(session('errors')['description'])) ? 'is-invalid' : ''; ?>" name="description" id="description" cols="30" rows="10"><?= old('description') ?></textarea>
                        <?php if(isset(session('errors')['description'])): ?>
                            <div id="description" class="text-danger invalid-feedback mt-2"><?= session('errors')['description'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4">
                        <label for="created_at" class="form-label">Created</label>
                        <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i') ?>" readonly>
                        <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
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