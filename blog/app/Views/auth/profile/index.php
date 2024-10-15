<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-2">Profile</h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button class="btn btn-dark btn-refresh btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh page">
            <span class="fa fa-sync-alt text-decoration-none"></span>
        </button>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-label-secondary btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back page">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form class="row mt-4 mb-5" method="post" action="<?= route_to('profile/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="col-md-3">
                <?php if($userLogin['image']) : ?>
                    <img src="data:image/jpeg;base64, <?= base64_encode($userLogin['image']); ?>" alt="" class="img-fluid rounded-circle" style="height:200px;width:200px;object:cover;" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $userLogin['id'] ?>">
                <?php else : ?>
                    <i class="fas fa-user-circle text-center" style="font-size:15rem;"></i>
                <?php endif; ?>
                <input type="file" class="form-control mt-3" name="image">
            </div>
            <div class="col-md-9">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= old('username', $userLogin['username']) ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control text-capitalize" name="fullname" value="<?= old('fullname', $userLogin['fullname']) ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= old('email', $userLogin['email']) ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="no_telp" class="form-label">No. Telephone</label>
                        <input type="number" class="form-control" name="no_telp" value="<?= old('no_telp', $userLogin['no_telp']) ?>">
                    </div>
                    <div class="col-sm-4">
                        <label for="roles" class="form-label">Roles</label>
                        <input type="text" class="form-control" name="roles" value="<?= old('role', $userLogin['role']) ?>" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control form-select" name="gender" id="gender">
                            <option value="Laki-laki" <?= old('gender', $userLogin['gender']) === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= old('gender', $userLogin['gender']) === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="religion" class="form-label">Religion</label>
                        <select class="form-control form-select" name="religion" id="religion">
                            <option value="islam"   <?= old('religion', $userLogin['religion'])  === 'islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="kristen" <?= old('religion', $userLogin['religion'])  === 'kristen' ? 'selected' : '' ?>>Kristen</option>
                            <option value="katolik" <?= old('religion', $userLogin['religion'])  === 'katolik' ? 'selected' : '' ?>>Katolik</option>
                            <option value="hindu"   <?= old('religion', $userLogin['religion'])  === 'hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="budha"   <?= old('religion', $userLogin['religion'])  === 'budha' ? 'selected' : '' ?>>Budha</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" cols="30" rows="5"><?= old('address', $userLogin['address'])  ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label for="created_at" class="form-label">Date Created</label>
                        <input type="text" class="form-control" name="created_at" value="<?= date('l, d-m-Y H:i', strtotime(old('created_at', $userLogin['created_at']) )) ?>" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label for="updated_at" class="form-label">Last Modified</label>
                        <input type="text" class="form-control" name="updated_at" value="<?= date('l, d-m-Y H:i', strtotime(old('updated_at', $userLogin['updated_at']))) ?>" readonly>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="#" class="btn btn-success">Change Password</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Image -->
<div class="modal fade" id="imageZoom<?= $userLogin['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageZoomLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
      <div class="modal-header border border-0 d-flex justify-content-center align-items-center position-relative">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="data:image/jpeg;base64, <?= base64_encode($userLogin['image']); ?>" alt="" class="img-fluid mt-4" data-bs-toggle="modal" data-bs-target="#imageZoom<?= $userLogin['id'] ?>">
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>