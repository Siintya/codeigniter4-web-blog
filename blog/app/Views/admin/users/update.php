<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="text-capitalize fw-bold mb-2"> Update User </h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button class="btn btn-dark btn-refresh btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh page">
            <span class="fa fa-sync-alt text-decoration-none"></span>
        </button>
        <a href="<?= base_url('users') ?>" class="btn btn-label-secondary btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card p-3">
    <div class="card-body">
        <form action="<?= base_url('users/update/'.$user['id']) ?>" method="post" class="form row g-4" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="col-lg-3">
                <?php if ($user['image']) : ?>
                    <img src="data:image/jpeg;base64, <?= base64_encode($user['image']); ?>" alt="" class="img-fluid rounded-circle mx-auto" style="height:200px;width:200px;object:cover;" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $user['id'] ?>">
                <?php else : ?>
                    <img src="<?= base_url('assets/images/profile/user.jpg') ?>" alt="" class="img-fluid round-image-200">
                <?php endif; ?>
                <input type="file" name="image" class="form-control mt-3" id="image" value="<?= old('image') ?>">
                <?php if(session()->has('errors') && isset(session('errors')['image'])): ?>
                    <div class="text-danger mt-2"><?= session('errors')['image'] ?></div>
                <?php endif; ?>
            </div>
            <div class="col-lg-9">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control pe-2" name="username" value="<?= old('username') ?? $user['username'] ?>">
                        <?php if(session()->has('errors') && isset(session('errors')['username'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['username'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control text-capitalize" name="fullname" value="<?= old('fullname') ?? $user['fullname'] ?>">
                        <?php if(session()->has('errors') && isset(session('errors')['fullname'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['fullname'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="<?= old('email') ?? $user['email'] ?>">
                        <?php if(session()->has('errors') && isset(session('errors')['email'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="no_telp" class="form-label">No. Telephone</label>
                        <input type="number" class="form-control" name="no_telp" value="<?= old('no_telp') ?? $user['no_telp'] ?>">
                        <?php if(session()->has('errors') && isset(session('errors')['no_telp'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['no_telp'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control form-select" name="gender" id="gender">
                            <option value="Laki-laki" <?= old('gender', $user['gender']) === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= old('gender', $user['gender']) === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="religion" class="form-label">Religion</label>
                        <select class="form-control form-select" name="religion" id="religion">
                            <option value="islam"   <?= (old('religion') ?? $user['religion']) === 'islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="kristen" <?= (old('religion') ?? $user['religion']) === 'kristen' ? 'selected' : '' ?>>Kristen</option>
                            <option value="katolik" <?= (old('religion') ?? $user['religion']) === 'katolik' ? 'selected' : '' ?>>Katolik</option>
                            <option value="hindu"   <?= (old('religion') ?? $user['religion']) === 'hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="budha"   <?= (old('religion') ?? $user['religion']) === 'budha' ? 'selected' : '' ?>>Budha</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label for="roles" class="form-label">Roles</label> <br>
                                <div class="form-check form-check-inline" style="margin-top:-5px;margin-bottom:-15px;">
                                    <input class="form-check-input" type="radio" name="roles" id="admin" value="1" <?= (old('roles') ?? $user['users_roles_id']) == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="admin">Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="roles" id="author" value="2" <?= (old('roles') ?? $user['users_roles_id']) == 2 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="author">Author</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="status" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" <?= (old('status') ?? $user['status']) === 'online' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status" data-bs-toggle="button" tabindex="-1" aria-pressed="<?= (old('status') ?? $user['status']) === 'online' ?>">
                                        <span class="switch-status-label" data-online="online" data-offline="offline"><?= (old('status') ?? $user['status']) === 'online' ? 'Online' : 'Offline' ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" cols="30" rows="10"><?= old('address') ?? $user['address'] ?></textarea>
                        <?php if(session()->has('errors') && isset(session('errors')['address'])): ?>
                            <div class="text-danger mt-2"><?= session('errors')['address'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="created_at" class="form-label">Date Created</label>
                        <input type="text" class="form-control" name="created_at" value="<?= old('created_at') ?? date('d-m-Y H:i', strtotime($user['created_at'])) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="updated_at" class="form-label">Last Modified</label>
                        <input type="text" class="form-control" id="updated_at" value="<?= old('updated_at') ? date('d-m-Y H:i', strtotime(old('updated_at'))) : (isset($user['updated_at']) ? date('d-m-Y H:i', strtotime($user['updated_at'])) : 'Blank') ?>" readonly>
                        <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                    </div>
                    
                    <div class="d-grid gap-2 col-12 mt-5">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Image -->
<div class="modal fade" id="imageZoom<?= $user['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageZoomLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
      <div class="modal-header border border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="data:image/jpeg;base64, <?= base64_encode($user['image']); ?>" alt="" class="img-fluid mt-4" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $user['id'] ?>">
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        
    });
</script>
<?= $this->endSection(); ?>
