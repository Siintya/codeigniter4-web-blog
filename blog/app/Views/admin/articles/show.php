<?= $this->extend('layouts/admin') ?>
<?= $this->section('css'); ?>
    <style type="text/css">
        .tooltip-inner {
            background-color: #000;
            color: #fff;
            padding: 5px; 
            font-size: 13px; 
            border-radius: 4px; 
        }

        .tooltip-arrow::before {
            border-bottom-color: #000;
        }
    </style>
<?= $this->endSection();?>
<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="text-capitalize fw-bold mb-2"> <?= $article['title'] ?> </h3>
        <?php if ($article['user_image']) : ?>
            <img src="data:image/jpeg;base64, <?= base64_encode($article['user_image']); ?>" class="img-fluid me-1 rounded-circle" alt="img" style="width: 30px; height: 30px; object-fit: cover;">
        <?php else : ?>
            <i class="fas fa-user-circle fs-5 me-1 text-dark"></i>
        <?php endif; ?>
        <a href="<?= base_url('users/update/'), $article['user_id'] ?>">
            <?= $article['username'] ?>
        </a> 
        <span class="ms-3"><i class="fas fa-calendar me-1 fs-6"></i> <?= date('l, d-m-Y H:i', strtotime($article['created_at'])); ?></span>
        <?php if ($article['status'] == 'publish' ) :?>
            <button class="btn btn-success rounded-pill btn-sm ms-1 text-capitalize"><?= $article['status'] ;?></button>
        <?php elseif ($article['status'] == 'draft') :?>
            <button class="btn btn-danger rounded-pill btn-sm ms-1 text-capitalize"><?= $article['status'] ;?></button>
        <?php elseif ($article['status'] == 'pending') :?>
            <button class="btn btn-warning rounded-pill btn-sm ms-1 text-capitalize"><?= $article['status'] ;?></button>
        <?php endif ;?>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="<?= base_url('articles/update/'), $article['id'] ?>" class="btn btn-info btn-icon rounded-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Article">
            <span class="fas fa-pen"></span>
        </a>
        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteArticlesModal" data-id="<?= $article['id'] ?>" class="btn btn-danger btn-icon ms-1">
            <span class="fas fa-trash-alt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Article"></span>
        </button>

        <a href="<?= base_url('articles') ?>" class="btn btn-label-secondary btn-icon ms-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Back Article">
            <i class="fas fa-backward"></i> 
        </a>
    </div>
</div>
<div class="card p-3">
    <div class="card-body">
        <div class="row">
            <!------------------  
                    Articles Content
                ------------------->
            <div class="col-9 mb-5">
                <?php if ($article['image']) : ?>
                    <div class="d-flex d-flex justify-content-center mb-5">
                        <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" class="img-fluid rounded w-75 h-75" alt="img" data-bs-toggle="modal" data-bs-target="#image<?= $article['id'] ?>">
                    </div>
                <?php endif; ?>
                <div class="content">
                    <?= $article['content'] ?>        
                </div>
            </div>
            <!-----------------
                    Categories & Tags
                ------------------>
            <?php if(!empty($categories) || !empty($tags)) : ?>
                <div class="col-3">
                    <div class="row">
                        <?php if (!empty($categories)) : ?>
                            <div class="col-12">
                                <div class="list-group">
                                    <div class="fs-6 fw-bold list-group-item list-group-item-light">Categories</div>
                                    <?php foreach($categories as $c) : ?>
                                        <a href="<?= base_url('categories/update/'). $c['categories_id'] ?>" class="list-group-item list-group-item-action"><?= $c['categories_name'] ;?></a>
                                    <?php endforeach ;?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($tags)) : ?>
                            <div class="col-12 mt-5">
                                <div class="list-group">
                                    <div class="list-group-item list-group-item-light fs-6 fw-bold">Tags</div>
                                    <?php foreach($tags as $t) : ?>
                                        <a href="<?= base_url('tags/update/'.$t['tags_id']) ?>" class="list-group-item list-group-item-action"><?= $t['tags_name'] ;?></a>
                                    <?php endforeach ;?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div> 
                </div>
            <?php endif ;?>      
        </div>
    </div>
</div>


<!-- Modal Image -->
<div class="modal fade" id="image<?= $article['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="imageLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="data:image/jpeg;base64, <?= base64_encode($article['image']); ?>" alt="" class="img-fluid mt-4" data-bs-toggle="modal" data-bs-target="#image<?= $article['id'] ?>">
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<?= $this->include('admin/modals/articles/delete') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#mediaTable').DataTable({
            responsive:true,
            paging: true,
            order: true,
        });
        $('#deleteArticlesModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("articles/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
    });
</script>
<?= $this->endSection(); ?>