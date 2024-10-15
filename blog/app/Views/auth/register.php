<?= $this->extend('layouts/page') ?>
<?= $this->section('title') ?>
Register
<?= $this->endSection(); ?>
<?= $this->section('content') ?>
<?= $this->include('templates/navbar') ?>
<!-- Header -->
<div class="site-cover site-cover-sm same-height overlay single-page">
		<div class="container">
			<div class="row same-height justify-content-between">
				<div class="col-md-12">
					<div class="post-entry">
						<h1>Register</h1>
					</div>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a class="text-dark" href="/">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Register</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-header bg-transparent border-bottom">
                    <h2 class="text-center fw-bold">Register</h2>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?= base_url('register') ?>" class="form" role="form">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control <?= (isset(session('errors')['username'])) ? 'is-invalid' : ''; ?>" id="username" aria-describedby="username" aria-describedby="username" name="username" value="<?= old('username') ?>">
                                <?php if (isset(session('errors')['username'])): ?>
                                    <div id="username" class="text-danger invalid-feedback mt-2"><?= session('errors')['username'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?= (isset(session('errors')['email'])) ? 'is-invalid' : ''; ?>" id="email" aria-describedby="email" aria-describedby="email" name="email" value="<?= old('email') ?>">
                                <?php if (isset(session('errors')['email'])): ?>
                                    <div id="email" class="text-danger invalid-feedback mt-2"><?= session('errors')['email'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control  <?= (isset(session('errors')['phone'])) ? 'is-invalid' : ''; ?>" id="phone" placeholder="Example: 087893248834">
                                <?php if (isset(session('errors')['phone'])): ?>
                                    <div id="phone" class="text-danger invalid-feedback mt-2"><?= session('errors')['phone'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control  <?= (isset(session('errors')['address'])) ? 'is-invalid' : ''; ?>" id="address" placeholder="Apartment, studio, or floor">
                                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                                <?php if (isset(session('errors')['address'])): ?>
                                    <div id="address" class="text-danger invalid-feedback mt-2"><?= session('errors')['address'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-2">Register</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                <p class="fs-4 mb-0 fw-bold">Have an account?</p>
                                <a class="text-dark fw-bold ms-2" href="<?= base_url('login') ?>">Login Now!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= $this->include('templates/footer') ?>
<?= $this->endSection(); ?>