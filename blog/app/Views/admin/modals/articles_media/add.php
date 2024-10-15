<!-- Modal -->
<div class="modal fade" id="addMediaModal" tabindex="-1" aria-labelledby="addMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMediaModalLabel"> 
                    <i class="fas fa-plus"></i> Add media
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('media/create') ?>" class="form" method="post" enctype="multipart/form-data"></form>
                <div class="modal-body">
                    <div class="row g-4 px-2">
                        <div class="col-lg-12">
                            <label for="article" class="form-label">Article</label>
                            <select class="form-control form-select mb-3" name="article" id="article">
                            </select>
                            <?php if(session()->has('errors') && isset(session('errors')['article'])): ?>
                                <div class="text-danger mt-2 error-message"><?= session('errors')['article'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-12">
                            <label for="captions" class="form-label">Captions</label>
                            <textarea class="form-control" name="captions" id="content" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                            <img src="" class="image-preview mt-3" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                            <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                                <div class="text-danger mt-2"><?= session('errors')['image'] ?></div>
                            <?php endif; ?>
                            <input type="hidden" name="created_at" id="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        <?php if (session()->has('errors')): ?>
            $('#addMediaModal').modal('show');
        <?php endif; ?>

        $('#addMediaModal').on('hidden.bs.modal', function () {
            $('.error-message').remove();
        });

        $.ajax({
            url: "<?php echo base_url('media/add-modals'); ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
                var articleSelectOptions = $('#article');
                if (data.length === 0) {
                    // Jika data artikel kosong, tambahkan opsi default dan tampilkan pesan
                    articleSelectOptions.append(`<option value="" disabled selected>No articles available</option>`);
                } else {
                    $.each(data, function(index, article) {
                        articleSelectOptions.append(`<option value="${article.id}">${article.title}</option>`);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
