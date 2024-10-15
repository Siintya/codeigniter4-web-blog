<?= $this->extend('layouts/page') ?>

<?= $this->section('title') ?>
Login
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<?= $this->include('templates/navbar') ?>
<!-- Header -->
  <div class="site-cover site-cover-sm same-height overlay single-page">
		<div class="container">
			<div class="row same-height justify-content-between">
				<div class="col-md-12">
					<div class="post-entry">
						<h1>Login</h1>
					</div>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a class="text-dark" href="/">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Login</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
<div class="page-wrapper" style="background-color:#f1f1f1;" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                  <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php elseif (session()->has('error_login')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session('error_login') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php endif; ?>
                  <form method="POST" action="<?= route_to('login') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= (isset(session('error')['username'])) ? 'is-invalid' : ''; ?>" id="username" aria-describedby="username" aria-describedby="username" name="username" value="<?= old('username') ?>">
                        <?php if (isset(session('error')['username'])): ?>
                            <div id="username" class="text-danger invalid-feedback mt-2"><?= session('error')['username'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= (isset(session('error')['password'])) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?= old('password') ?>">
                        <?php if (isset(session('error')['password'])): ?>
                            <div id="password" class="text-danger invalid-feedback mt-2"><?= session('error')['password'] ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Haven't account?</p>
                        <a class="text-dark fw-bold ms-2" href="<?= base_url('register') ?>">Register Now!</a>
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