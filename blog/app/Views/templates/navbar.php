<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<nav class="site-nav">
	<div class="container">
		<div class="menu-bg-wrap">
			<div class="site-navigation">
				<div class="row g-0 align-items-center">
					<div class="col-2">
						<a href="<?= base_url('/') ?>" class="logo m-0 float-start">Blogges.</a>
					</div>
					<div class="col-8 text-center">
						<ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
							<li class="active"><a href="<?= base_url('/') ?>">Home</a></li>
							<li><a href="<?= base_url('/page/about-us') ?>">About</a></li>
							<li><a href="<?= base_url('/page/blog') ?>">Blog</a></li>
							<li><a href="<?= base_url('/page/contact-us') ?>">Contact</a></li>
						</ul>
					</div>
					<div class="col-2 text-end">
						<a href="#" class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
							<span></span>
						</a>
                        <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
							<li><a href="<?= base_url('login') ?>" class="btn py-1 px-2 btn-outline-dark">Login</a></li>
							<li><a href="<?= base_url('register') ?>" class="btn py-1 px-2 btn-outline-dark">Register</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>