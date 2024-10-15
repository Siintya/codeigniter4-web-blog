<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card w-100 bg-0">
    <div class="card-header bg-transparent border-bottom">
        <div class="mb-3 mb-sm-0">
            <h2 class="fw-semibold lexend-exad"> <?= $article['title'] ?> </h2>
            <?php if ($article['user_image']) : ?>
                <img src="data:image/jpeg;base64, <?= base64_encode($article['user_image']); ?>" class="img-fluid rounded-circle" alt="img" width="30"  height="30">
            <?php else : ?>
                <i class="ti ti-user"></i>
            <?php endif; ?>
            <small class="text-body-secondary">
                <?= $article['username'] ?> 
                <span class="ms-1">  
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="8"  height="8"  viewBox="0 0 24 24"  fill="#808080"  class="icon icon-tabler icons-tabler-filled icon-tabler-circle mb-1 me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" /></svg>
                    <?= date('l, d-m-Y H:i', strtotime($article['created_at'])); ?>
                </span>
            </small>
        </div>
    </div>
    <div class="card-body">
        <?php if ($article['image']) : ?>
            <div class="d-flex d-flex justify-content-center mb-5">
                <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" class="img-fluid rounded" alt="img" width="300">
            </div>
        <?php endif; ?>
        <div class="content">
            <?= $article['content'] ?>        
        </div>
        <div class="d-flex justify-content-between mt-5">
            <a href="<?= base_url('articles/update/'), $article['id'] ?>" class="btn btn-warning"><i class="ti ti-pencil fs-4"></i> Update</a>
            <a href="<?= base_url('articles/delete/'), $article['id'] ?>" class="btn btn-danger"><i class="ti ti-trash fs-4"></i> Delete</a>
            <a href="<?= base_url('articles') ?>" class="btn btn-outline-dark">Back</a>
        </div>
    </div>
</div>

<!-- Modal Image -->
<div class="modal fade" id="staticBackdrop<?= $article['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" alt="" class="img-fluid mt-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $article['id'] ?>">
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
