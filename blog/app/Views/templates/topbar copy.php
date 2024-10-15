<header class="app-header" style="background-color: #F1F1F1;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if(session()->get('image')) : ?>
                        <img src="data:image/jpeg;base64, <?= base64_encode(session()->get('image')); ?>" alt="" width="35" height="35" class="rounded-circle">
                    <?php else : ?>
                        <img src="<?= base_url('assets/images/profile/user.jpg') ?>" alt="" width="35" height="35" class="rounded-circle">
                    <?php endif; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="<?= base_url('profile') ?>" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="<?= base_url('logout'); ?>" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-logout-2 fs-6"></i>
                      <p class="mb-0 fs-3">Logout</p>
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>