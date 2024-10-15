<!-- Modal -->
<div class="modal fade" id="updateMediaModal" tabindex="-1" aria-labelledby="updateMediaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMediaModalLabel"> 
                    <i class="ti ti-pencil"></i>Update media
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                    <div class="alert alert-danger error-message mt-2"><?= session('errors')['image'] ?></div>
                <?php endif; ?>
                <form action="<?= base_url('media/create') ?>" class="form row g-4" method="post" enctype="multipart/form-data">
                    <div class="col-12">
                        <input type="file" name="images" id="image" class="form-control mb-3">
                        <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                            <div class="text-danger error-message mt-2"><?= session('errors')['image'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer d-flex justify-content-between mt-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Show the modal if there are errors
        <?php if (session()->has('errors')): ?>
            $('#updateMediaModal').modal('show');
        <?php endif; ?>

        $('#updateMediaModal').on('hidden.bs.modal', function () {
            $('.error-message').remove();
        });
    });
</script>

