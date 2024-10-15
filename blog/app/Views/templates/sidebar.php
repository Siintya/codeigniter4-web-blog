<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="<?= base_url('dashboard') ?>" class="logo">
        <h4 class="fw-bold">Blogges.</h4>
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-info">
        <li class="nav-item <?= ($currentUrl == '/dashboard') ? 'active' : '' ?>">
          <a href="<?= base_url('dashboard') ?>"> <i class="fas fa-tachometer-alt"></i> <p>Dashboard</p></a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Management</h4>
        </li>
        <li class="nav-item <?= ($currentUrl == '/pages') ? 'active' : '' ?>">
          <a href="<?= base_url('pages') ?>"><i class="fas fa-file-alt"></i> <p>Pages</p></a>
        </li>
        <li class="nav-item <?= ($currentUrl == '/articles') ? 'active' : '' ?>">
          <a href="<?= base_url('articles') ?>"><i class="fas fa-newspaper"></i> <p>Articles</p></a>
        </li>
        <li class="nav-item <?= ($currentUrl == '/categories') ? 'active' : '' ?>">
          <a href="<?= base_url('categories') ?>"><i class="fas fa-bookmark"></i> <p>Categories</p></a>
        </li>
        <li class="nav-item <?= ($currentUrl == '/tags') ? 'active' : '' ?>">
          <a href="<?= base_url('tags') ?>"><i class="fas fa-tags"></i> <p>Tags</p></a>
        </li>
        <li class="nav-item <?= ($currentUrl == '/media') ? 'active' : '' ?>">
          <a href="<?= base_url('media') ?>"><i class="fas fa-images"></i> <p>Media</p></a>
        </li>
        <li class="nav-item <?= ($currentUrl == '/users') ? 'active' : '' ?>">
          <a href="<?= base_url('users') ?>"><i class="fas fa-users"></i> <p>Users</p></a>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->