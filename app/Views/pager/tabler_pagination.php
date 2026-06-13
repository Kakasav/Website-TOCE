<?php $pager->setSurroundCount(2) ?>

<ul class="pagination">
  <?php if ($pager->hasPreviousPage()): ?>
  <li class="page-item">
    <a class="page-link" href="<?= $pager->getPreviousPageURI() ?>">
      <i class="ti ti-chevron-left"></i>
    </a>
  </li>
  <?php endif; ?>

  <?php foreach ($pager->links() as $link): ?>
  <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
    <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
  </li>
  <?php endforeach; ?>

  <?php if ($pager->hasNextPage()): ?>
  <li class="page-item">
    <a class="page-link" href="<?= $pager->getNextPageURI() ?>">
      <i class="ti ti-chevron-right"></i>
    </a>
  </li>
  <?php endif; ?>
</ul>