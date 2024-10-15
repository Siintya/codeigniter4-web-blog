<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-2">Media</h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button type="button" class="btn btn-label-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addMediaModal">
            <i class="fas fa-plus"></i> Add Media
        </button>
    </div>
</div>
<div class="card">
    <div class="card-body" id="articleMedia">
        <table id="mediaTable" class="table table-striped table-hover nowrap" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center text-capitalize">No.</th>
                    <th class="text-center text-capitalize">Articles</th>
                    <th class="text-center text-capitalize">Image</th>
                    <th class="text-center text-capitalize">Date Created</th>
                    <th class="text-center text-capitalize">Last Modified</th>
                    <th class="text-center"><i class="fas fa-cogs"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($media > 0) : ?>
                    <?php $no = 1; foreach ($media as $m) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <a href="<?= base_url('articles/' . $m['slug']) ?>" class="text-capitalize">
                                    <?= strlen($m['title']) > 40 ? substr($m['title'], 0, 40) . '...' : $m['title'] ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <img src="data:image/jpeg;base64, <?= base64_encode($m['image']); ?>" class="img-fluid rounded image-preview" alt="img" width="100" height="100" data-bs-toggle="modal" data-bs-target="#image<?= $m['id'] ?>">
                            </td>
                            <td class="text-center">
                                <?= date('d-m-Y H:i', strtotime($m['created_at'])); ?>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($m['updated_at'])) : ?>
                                    <?= date('d-m-Y H:i', strtotime($m['updated_at'])); ?>
                                <?php else : ?>
                                    Blank
                                <?php endif ;?>
                            </td>
                            <td class="text-center">
                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#updateMediaModal<?= $m['id'] ?>"><i class="fas fa-edit"></i></a>
                                <a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteMediaModal" data-id="<?= $m['id'] ?>"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <!-- Modal Image -->
                        <div class="modal fade" id="image<?= $m['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-transparent">
                                    <div class="modal-header border border-0">
                                        <h5><?= $m['filename'] ;?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="data:image/jpeg;base64, <?= base64_encode($m['image']); ?>" alt="" class="img-fluid mt-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Update Media -->
                        <div class="modal fade" id="updateMediaModal<?= $m['id'] ?>"  tabindex="-1" aria-labelledby="updateMediaModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateMediaModalLabel"> 
                                            <i class="ti ti-pencil"></i> Update Media
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url('media/update/'). $m['id'] ?>" class="form" method="post" enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="articles" class="form-label">Article</label>
                                                    <select class="form-select mb-3" name="articles" id="articles">
                                                        <?php if(!empty($articles)) : ?>
                                                            <?php foreach ($articles as $data) : ?>
                                                                <option value="<?= $data['id'] ?>" <?= (old('articles') ?? $m['articles_id'] ?? '') == $data['id'] ? 'selected' : '' ?>><?= $data['title'] ;?></option>
                                                            <?php endforeach ;?>
                                                        <?php else : ?>
                                                            <option value="" disabled selected>No articles available</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label for="captions" class="form-label">Captions</label>
                                                    <textarea class="form-control" name="captions" id="editor-update" cols="30" rows="10"><?= old('captions') ?? $m['captions'] ?></textarea>
                                                </div>
                                                <div class="col-8">
                                                    <label for="image" class="form-label">Image</label>
                                                    <input type="file" name="image" class="form-control" id="image" value="<?= old('image') ?>" onchange="previewImage(event)">
                                                    <img class="image-preview img-fluid mt-2 rounded" src="data:image/jpeg;base64, <?= base64_encode($m['image']); ?>" alt="" style="max-width: 300px; max-height: 300px;">
                                                    <?php if (session()->has('errors-update-media') && isset(session('errors-update-media')['image'])): ?>
                                                        <div class="text-danger mt-2"><?= session('errors-update-media')['image'] ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-4">
                                                    <label for="updated_at" class="form-label">Last Modified</label>
                                                    <input type="text" class="form-control" value="<?= old('updated_at') ? old('updated_at') : (isset($m['updated_at']) ? date('d-m-Y H:i', strtotime($m['updated_at'])) : 'Blank') ?>">
                                                    <input type="hidden" name="updated_at" id="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                                                </div>
                                                <div class="col-12 d-flex justify-content-between mt-4">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ;?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Data not available</td>
                    </tr>
                <?php endif ;?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('admin/modals/articles_media/delete') ?>
<?= $this->include('admin/modals/articles_media/add') ?>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        // DataTables
        $('#mediaTable').DataTable({
            responsive: true,
            paging: true,
            ordering: true,
        }); 
        <?php if (session()->has('errors')): ?>
            <?php $error_modal = session('error_modal'); ?>
            <?php if (strpos($error_modal, 'add_') !== false): ?>
                var addContentId = '<?= str_replace('add_', '', $error_modal) ?>';
                $('#addMediaModal' + addContentId).modal('show');
            <?php elseif (strpos($error_modal, 'update_') !== false): ?>
                var updateContentId = '<?= str_replace('update_', '', $error_modal) ?>';
                $('#updateMediaModal' + updateContentId).modal('show');
            <?php endif; ?>
        <?php endif; ?>
        
    });
</script>
<?= $this->endSection(); ?>
