<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel"> 
                    <i class="fas fa-plus"></i> Add user
                </h5>
                <hr>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('users/create') ?>" method="post" class="form row g-4">
                    <div class="col-lg-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= (isset(session('errorsUser')['username'])) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= old('username') ?>">
                        <?php if(isset(session('errorsUser')['username'])): ?>
                            <div id="username" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsUser')['username'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control <?= (isset(session('errorsUser')['fullname'])) ? 'is-invalid' : ''; ?>" id="fullname" name="fullname" value="<?= old('fullname') ?>">
                        <?php if(isset(session('errorsUser')['fullname'])): ?>
                            <div id="fullname" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsUser')['fullname'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control <?= (isset(session('errorsUser')['email'])) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email') ?>">
                        <?php if(isset(session('errorsUser')['email'])): ?>
                            <div id="email" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsUser')['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <label for="no_telp" class="form-label">No. Telephone</label>
                        <input type="number" class="form-control <?= (isset(session('errorsUser')['no_telp'])) ? 'is-invalid' : ''; ?>" id="no_telp" name="no_telp" value="<?= old('no_telp') ?>">
                        <?php if(isset(session('errorsUser')['no_telp'])): ?>
                            <div id="no_telp" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsUser')['no_telp'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control form-select" name="gender" id="gender">
                            <option value="Laki-laki" <?= old('gender') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= old('gender') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control <?= (isset(session('errorsUser')['address'])) ? 'is-invalid' : ''; ?>" id="address" name="address" cols="30" rows="10"><?= old('address') ?></textarea>
                                <?php if(isset(session('errorsUser')['address'])): ?>
                                    <div id="address" class="text-danger invalid-feedback fw-lighter mt-2"><?= session('errorsUser')['address'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12">
                                <label for="created_at" class="form-label">Date Created</label>
                                <input type="text" class="form-control" id="created_at" value="<?= date('d-m-Y H:i') ?>" readonly>
                                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="religion" class="form-label">Religion</label>
                                <select class="form-control form-select" name="religion" id="religion">
                                    <option value="islam"   <?= old('religion') === 'islam'     ? 'selected' : '' ?>>Islam</option>
                                    <option value="kristen" <?= old('religion') === 'kristen'   ? 'selected' : '' ?>>Kristen</option>
                                    <option value="katolik" <?= old('religion') === 'katolik'   ? 'selected' : '' ?>>Katolik</option>
                                    <option value="hindu"   <?= old('religion') === 'hindu'     ? 'selected' : '' ?>>Hindu</option>
                                    <option value="budha"   <?= old('religion') === 'budha'     ? 'selected' : '' ?>>Budha</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="roles" class="form-label">Roles</label><br>
                                <div class="form-check form-check-inline" id="roles">
                                    <input class="form-check-input" type="radio" name="roles" id="admin" value="admin" checked>
                                    <label class="form-check-label" for="admin">
                                        Admin
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="roles" id="author" value="author">
                                    <label class="form-check-label" for="author">
                                        Author
                                    </label>
                                </div>
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
</div>