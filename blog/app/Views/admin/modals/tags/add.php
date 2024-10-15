<!-- Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTagModalLabel"> 
                    <i class="fas fa-plus"></i> Add tag
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('tags/create') ?>" method="post" class="form row g-4">
                    <div class="col-7">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['name'])) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name') ?>">
                        <?php if(isset(session('errors')['name'])): ?>
                            <div id="name" class="text-danger invalid-feedback mt-2"><?= session('errors')['name'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-5">
                        <label for="created_at" class="form-label">Data Created</label>
                        <input type="text" class="form-control pe-2" value="<?= date('Y-m-d H:i') ;?>" readonly>
                        <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ;?>">
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
