<?php
use Bookshop\Util;
$title  = $_REQUEST['title'] ?? '';
?>

<form class="d-flex me-auto" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
    <input type="hidden" name="view" value="search" />
    <input class="form-control form-control-sm me-2" type="search" id="title" name="title" placeholder="Search book by title..." value="<?php echo Util::escape($title); ?>" aria-label="Search">
    <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
</form>