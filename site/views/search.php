<?php
use Bookshop\Util;

require_once('views/partials/header.php');

$offset = $_REQUEST['offset'] ?? 0;
$epp    = $_REQUEST['epp'] ?? 4;  // epp … entries per page

$page = isset($title) ?
	Data\DataManager::getBooksForSearchCriteriaWithPaging($title, $offset, $epp) :
	null;
?>

  <div class="page-header">
   <h2>Search Result for "<?php echo Util::escape($title); ?>"</h2>
  </div>

<?php if (isset($page)): ?>

	<?php if (sizeof($page->getResult()) > 0) : ?>

    <p>
      Displaying results <?php echo Util::escape($page->getPositionOfFirst()); ?> to <?php echo Util::escape
		($page->getPositionOfLast()); ?> of <?php echo Util::escape($page->getTotalCount()); ?>.
    </p>

		<?php
		$books = $page->getResult();
		require('views/partials/booklist.php');
		?>


   <nav>
    <ul class="pagination justify-content-center">
		<?php
		$p = 0;
		$i = 0;
		while ($i < $page->getTotalCount()) :
			?>
      <li class="page-item">
          <a class="page-link" href="?title=<?php echo rawurlencode($title); ?>&view=search&offset=<?php echo rawurlencode($i); ?>&epp=<?php echo rawurlencode($epp); ?>"><?php echo Util::escape(++$p); ?></a>
    </li>
      <?php
			$i += $epp;
		endwhile;
		?>
    </ul>
  </nav>
 

	<?php else : ?>
    <p>No matching books found.</p>
	<?php endif; ?>

<?php endif; ?>

<?php require_once('views/partials/footer.php');