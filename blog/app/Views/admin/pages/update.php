<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="text-capitalize fw-bold mb-2"> Update Page </h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button class="btn btn-dark btn-refresh btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh page">
            <span class="fa fa-sync-alt text-decoration-none"></span>
        </button>
        <a href="<?= base_url('pages') ?>" class="btn btn-label-secondary btn-icon " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <!---- Pages ---->
            <div class="col-lg-12">
                <form action="<?= base_url('pages/update/'.$page['id']) ?>" method="post" class="form row g-4" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="col-lg-8">
                        <label for="title-page" class="form-label">Title</label>
                        <input type="text" class="form-control pe-2 text-capitalize <?= (isset(session('errors')['title-page'])) ? 'is-invalid' : ''; ?>" id="title-page" name="title-page" value="<?= old('title-page') ?? $page['title'] ?>">
                        <?php if(isset(session('errors')['title-page'])): ?>
                            <div id="title-page" class="text-danger invalid-feedback mt-2"><?= session('errors')['title-page'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <label for="slug-page" class="form-label">Slug</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['slug-page'])) ? 'is-invalid' : ''; ?>" id="slug-page" name="slug-page" value="<?= old('slug-page') ?? $page['slug'] ?>" readonly>
                        <?php if(isset(session('errors')['slug-page'])): ?>
                            <div id="slug-page" class="text-danger invalid-feedback mt-2"><?= session('errors')['slug-page'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label for="content-page" class="form-label">Content</label>
                        <textarea class="form-control <?= (isset(session('errors')['content-page'])) ? 'is-invalid' : ''; ?>" name="content-page" id="content-page" cols="30" rows="10"><?= old('content-page') ?? $page['content'] ?></textarea>
                        <?php if(isset(session('errors')['content-page'])): ?>
                            <div id="content-page" class="text-danger invalid-feedback mt-2"><?= session('errors')['content-page'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-8">
                        <label for="image-page" class="form-label">Image</label>
                        <input type="file" class="form-control mt-2 <?= (isset(session('errors')['image-page'])) ? 'is-invalid' : ''; ?>" id="image-page" name="image-page" value="">
                        <?php if ($page['image']) : ?>
                            <img src="data:image/jpeg;base64, <?= base64_encode($page['image']); ?>" alt="" class="img-fluid mt-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $page['id'] ?>" style="max-width: 500px; max-height: 500px;">
                        <?php endif; ?>
                        <?php if(isset(session('errors')['image-page'])): ?>
                            <div id="image-page" class="text-danger invalid-feedback mt-2"><?= session('errors')['image-page'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="author" class="form-label">Author</label><br>
                                <a class="text-decoration-underline" href="<?= base_url('users/update/'). $page['user_id'] ?>"><?= $page['username'] ?></a>
                            </div>
                            <div class="col-12">
                                <label for="created_at" class="form-label">Date Created</label>
                                <input type="text" class="form-control" name="created_at" value="<?= old('created_at') ?? date('d-m-Y H:i', strtotime($page['created_at'])) ?>" readonly>
                            </div>
                            <div class="col-12">
                                <label for="updated_at" class="form-label">Last Modified</label>
                                <?php if (!empty($page['updated_at'])) : ?>
                                    <input type="text" class="form-control" value="<?= old('updated_at') ?? date('d-m-Y H:i', strtotime($page['updated_at'])) ?>" readonly>
                                <?php else : ?>
                                    <input type="text" class="form-control" value="Blank" readonly>
                                <?php endif ;?>
                                <input type="hidden" class="form-control" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-5">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

            <!---- Pages Contents ---->
            <div class="col-lg-12 mt-5" id="pagesContents">
                <div class="d-flex justify-content-between">
                    <h3 class="text-capitalize fw-bold">Content Sections</h3>
                    <button type="button" class="btn btn-label-primary" data-bs-toggle="modal" data-bs-target="#addContentModal<?= $page['id'] ?>"><i class="fas fa-plus"></i> Add Contents</button>
                </div>
                <hr>     
                <?php if (isset($pages_contents)) : ?>
                    <table id="contentsTables" class="table table-striped table-hover nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center text-capitalize">No</th>
                                <th class="text-center text-capitalize">Content Title</th>
                                <th class="text-center text-capitalize">Content Image</th>
                                <th class="text-center text-capitalize">Date Created</th>
                                <th class="text-center text-capitalize">Last Modified</th>
                                <th class="text-center"><i class="fas fa-cogs"></i</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pages_contents as $contents) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td class="text-capitalize">
                                        <?= !empty($contents['contents_title']) ? $contents['contents_title'] : 'Blank' ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($contents['contents_image'])) : ?>
                                            <img class="rounded" src="data:image/jpeg;base64, <?= base64_encode($contents['contents_image']); ?>" alt="" class="img-fluid mt-4" width="50" height="50" data-bs-toggle="modal" data-bs-target="#imageContent<?= $contents['contents_id'] ?>">
                                        <?php else : ?>
                                            <img class="rounded" src="<?= base_url('assets/images/noimage.jpeg') ?>" alt="" class="img-fluid mt-4" width="50" height="50">
                                        <?php endif ;?>
                                        <!-- Modal Image Content -->
                                        <div class="modal fade" id="imageContent<?= $contents['contents_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageContent" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content bg-transparent">
                                                    <div class="modal-header border border-0">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="data:image/jpeg;base64, <?= base64_encode($contents['contents_image']); ?>" alt="" class="img-fluid mt-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($contents['contents_created_at']) ? date('d-m-Y H:i', strtotime($contents['contents_created_at'])) : 'Blank' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($contents['contents_updated_at']) ? date('d-m-Y H:i', strtotime($contents['contents_updated_at'])) : 'Blank' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateContentModal<?= $contents['contents_id'] ?>"><i class="fas fa-edit text-primary"></i></a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteContentModal" data-id="<?= $contents['contents_id'] ?>"><i class="fas fa-trash-alt text-danger ms-3"></i></a>   
                                    </td>
                                </tr>
                                <!-- Modal Update Contents -->
                                <div class="modal fade" id="updateContentModal<?= $contents['contents_id'] ?>" tabindex="-1" aria-labelledby="updateContentModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateContentModalLabel"> 
                                                    <i class="fas fa-edit"></i> Update Content
                                                </h5>
                                                <hr>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php if (session()->has('info-content')) : ?>
                                                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                                            No changes were made.
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php endif; ?>
                                                <form action="<?= site_url('pages/update/content/'). $contents['contents_id'] ?>" class="form row" method="post" enctype="multipart/form-data">
                                                    <?= csrf_field() ?>
                                                    <div class="row g-4">
                                                        <div class="col-lg-8">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" name="title" id="title" value="<?= old('title') ?? $contents['contents_title']  ?>">
                                                            <?php if(session()->has('errors') && isset(session('errors')['title'])): ?>
                                                                <div class="text-danger error-message mt-2"><?= session('errors')['title'] ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label for="slug" class="form-label">Slug</label>
                                                            <input type="text" class="form-control" name="slug" id="slug" value="<?= old('slug') ?? $contents['contents_slug']?>" readonly>
                                                            <?php if(session()->has('errors') && isset(session('errors')['slug'])): ?>
                                                                <div class="text-danger error-message mt-2"><?= session('errors')['slug'] ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label for="content" class="form-label">Content</label>
                                                            <textarea class="form-control" name="content" id="content-update"><?= old('content') ?? $contents['contents_content'] ?? 'This content is blank...' ?></textarea>
                                                        </div>
                                                        <div class="col-8">
                                                            <label for="image" class="form-label">Image</label>
                                                            <input type="file" name="image" class="form-control" id="image" value="<?= old('image') ?>" onchange="previewImage(event)">
                                                            <img class="image-preview img-fluid mt-3 rounded" src="data:image/jpeg;base64, <?= base64_encode($contents['contents_image']); ?>" alt=""  style="max-width: 300px; max-height: 300px;">
                                                            <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                                                                <div class="text-danger error-message mt-2"><?= session('errors')['image'] ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="row g-4">
                                                                <div class="col-12">
                                                                    <label for="created_at" class="form-label">Date Created</label>
                                                                    <input type="text" class="form-control" id="created_at" value="<?= old('created_at') ?? date('d-m-Y H:i', strtotime($contents['contents_created_at'])) ?>" readonly>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="updated_at" class="form-label">Last Modified</label>
                                                                    <input type="text" class="form-control" id="updated_at" value="<?= old('updated_at') ? date('d-m-Y H:i', strtotime(old('updated_at'))) : (isset($contents['contents_updated_at']) ? date('d-m-Y H:i', strtotime($contents['contents_updated_at'])) : 'Blank') ?>" readonly>
                                                                    <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                                                                    <input type="hidden" name="pages_id" value="<?= $page['id'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-between mt-5">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                        
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Content Title</th>
                                <th class="text-center">Content Image</th>
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Last Modified</th>
                                <th class="text-center"><i class="ti ti-settings fs-6"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">Data not available</td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal Image Page -->
<div class="modal fade" id="staticBackdrop<?= $page['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
        <div class="modal-header border border-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img src="data:image/jpeg;base64, <?= base64_encode($page['image']); ?>" alt="" class="img-fluid mt-4">
        </div>
    </div>
  </div>
</div>
<!-- Modal Add Contents -->
<div class="modal fade" id="addContentModal<?= $page['id'] ?>" tabindex="-1" aria-labelledby="addContentModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContentModalLabel"> 
                    <i class="fas fa-plus"></i> Add Content
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('pages/create/content/'). $page['id'] ?>" class="form" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-4">
                        <div class="col-8">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control <?= (isset(session('errors')['title'])) ? 'is-invalid' : ''; ?>" name="title" id="title" value="<?= old('title') ?>">
                            <?php if(isset(session('errors')['title'])): ?>
                                <div id="title" class="text-danger invalid-feedback mt-2"><?= session('errors')['title'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-4">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control <?= (isset(session('errors')['slug'])) ? 'is-invalid' : ''; ?>" name="slug" id="slug" value="<?= old('slug') ?>" readonly>
                            <?php if(isset(session('errors')['slug'])): ?>
                                <div id="slug" class="text-danger invalid-feedback mt-2"><?= session('errors')['slug'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control <?= (isset(session('errors')['content'])) ? 'is-invalid' : ''; ?>" name="content" id="content-add" cols="10" rows="10"><?= old('contents') ?></textarea>
                            <?php if(isset(session('errors')['content'])): ?>
                                <div id="content" class="text-danger invalid-feedback mt-2"><?= session('errors')['content'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-6">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control <?= (isset(session('errors')['image'])) ? 'is-invalid' : ''; ?>" onchange="previewImage(event)">
                            <img src="" class="image-preview mt-3" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                            <?php if(isset(session('errors')['image'])): ?>
                                <div id="image" class="text-danger invalid-feedback mt-2"><?= session('errors')['image'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-6">
                            <label for="created_at" class="form-label">Date Created</label>
                            <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i') ?>" readonly>
                            <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                        </div>
                        <div class="col-lg-12 d-flex justify-content-between mt-5 mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
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
        $('#contentsTables').DataTable({
            responsive:true,
            paging: true,
            ordering: true,
        });

        <?php if (session()->has('errors')): ?>
            <?php $error_modal = session('error_modal'); ?>
            <?php if (strpos($error_modal, 'add_') !== false): ?>
                var addContentId = '<?= str_replace('add_', '', $error_modal) ?>';
                $('#addContentModal' + addContentId).modal('show');
            <?php elseif (strpos($error_modal, 'update_') !== false): ?>
                var updateContentId = '<?= str_replace('update_', '', $error_modal) ?>';
                $('#updateContentModal' + updateContentId).modal('show');
            <?php endif; ?>
        <?php elseif (session()->has('info-content')): ?>
            <?php $info_modal = session('info-content'); ?>
            <?php if (strpos($info_modal, 'info_') !== false): ?>
                var infoContentId = '<?= str_replace('info_', '', $info_modal) ?>';
                $('#updateContentModal' + infoContentId).modal('show');
            <?php endif; ?>
        <?php endif; ?>

        $('#addContentModal').on('hidden.bs.modal', function () {
            $('.error-message').remove();
        });
        $('#updateContentModal').on('hidden.bs.modal', function () {
            $('.error-message').remove();
        });

        $('#deleteContentModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("pages/delete/content/") ?>' + id;
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
<?= $this->include('admin/modals/pages/delete_content') ?>
<?= $this->endSection(); ?>
