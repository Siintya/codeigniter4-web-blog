<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="text-capitalize fw-bold mb-2"> Update Article </h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button class="btn btn-dark btn-refresh btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh page">
            <span class="fa fa-sync-alt text-decoration-none"></span>
        </button>
        <a href="<?= base_url('articles') ?>" class="btn btn-label-secondary btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <!---- Update Content Articles ---->
            <div class="col-lg-12 mb-5">
                <form action="<?= base_url('articles/update/'.$article['id']) ?>" method="post" class="form row g-4" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="col-md-8">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control pe-2 text-capitalize <?= (isset(session('errors')['title'])) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?= old('title') ?? $article['title'] ?>">
                        <?php if(isset(session('errors')['title'])): ?>
                            <div id="title" class="text-danger invalid-feedback mt-2"><?= session('errors')['title'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['slug'])) ? 'is-invalid' : ''; ?>" id="slug" name="slug" value="<?= old('slug') ?? $article['slug'] ?>" readonly>
                        <?php if(isset(session('errors')['slug'])): ?>
                            <div id="slug" class="text-danger invalid-feedback mt-2"><?= session('errors')['slug'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content <?= (isset(session('errors')['content'])) ? 'is-invalid' : ''; ?>" id="content" cols="30" rows="10" loading="lazy"><?= old('content') ?? $article['content'] ?></textarea>
                        <?php if(isset(session('errors')['content'])): ?>
                            <div id="content" class="text-danger invalid-feedback mt-2"><?= session('errors')['content'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-5">
                            <div class="col-sm-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control <?= (isset(session('errors')['image'])) ? 'is-invalid' : ''; ?>" id="image" value="<?= old('image') ?>" onchange="previewImage(event)">
                                <?php if(isset(session('errors')['image'])): ?>
                                    <div id="image" class="text-danger invalid-feedback mt-2 mb-2"><?= session('errors')['image'] ?></div>
                                <?php endif; ?>
                                <?php if ($article['image']) : ?>
                                    <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" alt=""  style="max-width: 400px; max-height: 400px;" class="image-preview mt-3 rounded img-fluid" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;" data-bs-toggle="modal" data-bs-target="#ImageArticle<?= $article['id'] ?>" loading="lazy">
                                <?php else : ?>
                                    <img src="" class="image-preview mt-3 rounded" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-12">
                                <div class="row g-4">
                                    <div class="col-6">
                                        <label for="created_at" class="form-label">Date Created</label>
                                        <input type="text" class="form-control" name="created_at" value="<?= old('created_at') ?? date('d-m-Y H:i', strtotime($article['created_at'])) ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="updated_at" class="form-label">Last Modified</label>
                                        <input type="text" class="form-control" value="<?= !empty($article['updated_at']) ? date('d-m-Y H:i', strtotime($article['updated_at'])) : 'Blank' ?>" readonly>
                                        <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="status" class="form-label">Status</label><br>
                                        <div class="form-check" style="margin-bottom:-20px;margin-top:-10px;">
                                            <input class="form-check-input" type="radio" name="status" id="publish" value="publish" <?= ($article['status'] == 'publish') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="publish">Publish</label>
                                        </div>
                                        <div class="form-check" style="margin-bottom:-20px;">
                                            <input class="form-check-input" type="radio" name="status" id="draft" value="draft" <?= ($article['status'] == 'draft') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="draft">Draft</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="pending" value="pending" <?= ($article['status'] == 'pending') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pending">Pending</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="author" class="form-label">Author</label><br>
                                        <a href="<?= base_url('users/update/') . $article['user_id'] ?>" class="text-decoration-underline"><?= $article['username'] ?></a>
                                    </div>
                                </div>
                                    
                            </div>
                            <div class="col-sm-12">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" name="category" id="category" data-value data-varia-label="Default select example" data-live-search="true">
                                    <?php if (!empty($categories)) : ?>
                                        <?php foreach ($categories as $c) : ?>
                                            <option value="<?= $c['id'] ?>" <?= (old('category') ?? $articles_category[0]['categories_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                                <?= $c['name'] ?>
                                            </option>
                                        <?php endforeach ;?>
                                    <?php else : ?>
                                        <option value="" disabled selected>No categories available</option>
                                    <?php endif ;?>
                                </select>
                                <?php if(isset(session('errors')['category'])): ?>
                                    <div id="category" class="text-danger invalid-feedback mt-2"><?= session('errors')['category'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-12">
                                <label for="tag" class="form-label">Tag</label>
                                <div class="selectgroup selectgroup-pills">
                                    <?php foreach ($tags as $tag) : ?>
                                        <label class="selectgroup-item mb-2">
                                            <input type="checkbox" name="tag[]" value="<?= $tag['id']; ?>" class="selectgroup-input" <?= in_array($tag['id'], array_column($articles_tag, 'tags_id')) ? 'checked' : ''; ?> />
                                            <span class="selectgroup-button"><?= $tag['name']; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                                <?php if(isset(session('errors')['tag'])): ?>
                                    <div id="tag" class="text-danger invalid-feedback mt-2"><?= session('errors')['tag'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-2 mt-5">
                        <button type="submit" class="btn btn-primary py-2">Save</button>
                    </div>
                </form>
            </div>
            <!---- Articles Media ---->
            <div class="col-lg-12" id="articleMedia">
                <div class="d-flex justify-content-between">
                    <h3 class="fw-semibold"> Media Article</h3>
                    <button type="button" class="btn btn-label-primary rounded-3 mb-2" data-bs-toggle="modal" data-bs-target="#addMediaModal<?= $article['id'] ?>"><i class="fas fa-plus"></i> Add Media</button>
                </div>
                <hr>
                    
                <?php if (isset($articles_media)) : ?>
                    <table id="mediaTable" class="table table-striped table-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center text-capitalize">No</th>
                                <th class="text-center text-capitalize">Media</th>
                                <th class="text-center text-capitalize">Date Created</th>
                                <th class="text-center text-capitalize">Last Modified</th>
                                <th class="text-center"><i class="ti ti-settings fs-6"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($articles_media as $data) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td class="text-center">
                                        <img src="data:image/jpeg;base64, <?= base64_encode($data['media_image']); ?>" class="img-fluid rounded" alt="img" width="50" height="50" data-bs-toggle="modal" data-bs-target="#imageMedia<?= $data['media_id'] ?>" loading="lazy">
                                        <!-- Modal Image Media-->
                                        <div class="modal fade" id="imageMedia<?= $data['media_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content bg-transparent">
                                                    <div class="modal-header border border-0">
                                                        <h5><?= $data['media_filename'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="data:image/jpeg;base64, <?= base64_encode($data['media_image']); ?>" alt="img" class="img-fluid mt-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?= date('d-m-Y H:i', strtotime($data['media_created_at'])); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($data['media_updated_at']) ? date('d-m-Y H:i', strtotime($data['media_updated_at'])) : 'Blank'  ?>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#updateMedia<?= $data['media_id'] ?>"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="text-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteArticlesMediaModal" data-id="<?= $data['media_id'] ?>"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                        <!-- Modal Update Media -->
                                        <div class="modal fade" id="updateMedia<?= $data['media_id'] ?>" tabindex="-1" aria-labelledby="updateMedia" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateMediaLabel"> 
                                                            <i class="fas fa-edit"></i> Update Media <?= $data['media_filename'] ?>
                                                        </h5>
                                                        <hr>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= site_url('media/update/'). $data['media_id'] ?>" class="form row g-4" method="post" enctype="multipart/form-data">
                                                            <?= csrf_field() ?>
                                                            <div class="col-12 mb-4">
                                                                <label for="captions" class="form-label">Captions</label>
                                                                <textarea class="form-control" name="captions" id="content-update-<?= $data['media_id'] ?>" cols="5" rows="5"><?= old('captions', $data['media_captions'] ?? '') ?></textarea>
                                                            </div>
                                                            <div class="col-8">
                                                                <label for="image" class="form-label">Image</label>
                                                                <input type="file" name="image" class="form-control" id="image" value="<?= old('image') ?>" onchange="previewImage(event)">
                                                                <img class="image-preview img-fluid mt-3 rounded" src="data:image/jpeg;base64, <?= base64_encode($data['media_image']); ?>" alt=""  style="max-width: 200px; max-height: 200px;">
                                                                <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                                                                    <div class="text-danger error-message mt-2"><?= session('errors')['image'] ?></div>                                                           
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="updated_at" class="form-label">Last Modified</label>
                                                                <input type="text" class="form-control" value="<?= !empty($data['media_updated_at']) ? date('d-m-Y H:i', strtotime($data['media_updated_at'])) : 'Blank' ?>" readonly>
                                                                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                                                                <input type="hidden" name="articles" value="<?= $data['articles_id'] ?>">
                                                            </div>
                                                            <div class="col-12">
                                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto;margin-top: 10px;">
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-4">
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                    <th class="text-center">Media</th>
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
        </div>
    </div>
</div>

<!-- Modal Image Article -->
<div class="modal fade" id="ImageArticle<?= $article['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ImageArticleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
        <div class="modal-header border border-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" alt="" class="img-fluid mt-4" data-bs-toggle="modal" data-bs-target="#ImageArticle<?= $article['id'] ?>">
        </div>
    </div>
  </div>
</div>
<!-- Modal Add Media -->
<div class="modal fade" id="addMediaModal<?= $article['id'] ?>" tabindex="-1" aria-labelledby="addMediaModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMediaModalLabel"> 
                    <i class="fas fa-plus"></i> Add Media
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('media/create') ?>" class="form row g-4" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="captions" class="form-label">Captions</label>
                        <textarea class="form-control" name="captions" id="content-add" cols="5" rows="5"><?= old('captions') ;?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                        <img src="" class="image-preview mt-3 rounded" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                        <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                        <input type="hidden" name="article" value="<?= $article['id'] ?>">
                        <?php if(session()->has('errorsMedia') && isset(session('errorsMedia')['image'])): ?>
                            <div class="text-danger error-message mt-2"><?= session('errorsMedia')['image'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('admin/modals/articles/delete_media') ?>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        <?php if (session()->has('errorsMedia')): ?>
            $('#addMediaModal<?= $article['id'] ?>').modal('show');
        <?php endif; ?>

        $('#addMediaModal<?= $article['id'] ?>').on('hidden.bs.modal', function () {
            $('.error-message').remove();
        });

        if (!$.fn.DataTable.isDataTable('#mediaTable')) {
            $('#mediaTable').DataTable({
                responsive:true,
                paging: true,
                order: true,
            });
        }


        $('#deleteArticlesMediaModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("media/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Function to generate slug from title
        function generateSlug(title) {
            return title.toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-');
        }

        // Event listener to update slug when title changes
        $('input[name="title"]').on('input', function() {
            var title = $(this).val();
            var slug = generateSlug(title);
            $('input[name="slug"]').val(slug);
        });


        // var modals = document.querySelectorAll('.modal');
        // modals.forEach(function (modal) {
        //     modal.addEventListener('shown.bs.modal', function () {
        //         var textarea = modal.querySelector('textarea[id^="captions-update-"]');
        //         if (textarea && !textarea.classList.contains('ck-editor-loaded')) {
        //             ClassicEditor
        //                 .create(textarea)
        //                 .then(editor => {
        //                     textarea.classList.add('ck-editor-loaded');
        //                     // Store the editor instance to remove it later if needed
        //                     textarea.ckeditorInstance = editor;
        //                 })
        //                 .catch(error => {
        //                     console.error(error);
        //                 });
        //         }
        //     });
        // });
    });

    function previewImage(event) {
        const input        = event.target;
        const imagePreview = input.closest('.row').querySelector('.image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.src = ''; 
            imagePreview.style.display = 'none';
        }
    }
</script>
<?= $this->endSection(); ?>