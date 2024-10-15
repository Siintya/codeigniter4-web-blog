<?php $pager->setSurroundCount(2) ?>
<div class="row text-start">
    <div class="col-md-12">
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination">
                <?php if ($pager->hasPreviousPage()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
                            Previous
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Previous">
                            Previous
                        </span>
                    </li>
                <?php endif ?>

                <?php foreach ($pager->links() as $link): ?>
                    <li class="page-item<?= $link['active'] ? ' active' : '' ?>">
                        <a class="page-link" href="<?= $link['uri'] ?>">
                            <?= $link['title'] ?>
                        </a>
                    </li>
                <?php endforeach ?>

                <?php if ($pager->hasNextPage()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Next">
                            Next
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Next">
                            Next
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</div>
