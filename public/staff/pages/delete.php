<?php require_once('../../../private/initialize.php') ?>

<?php

$page_title = "Delete Page";
include(SHARED_PATH . '/staff_header.php');

if (!isset($_GET['id'])) {
    redirect_to(buildUrl('/staff/pages/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {

    $res = delete_page($id);
    redirect_to(buildUrl('/staff/pages/index.php'));
} else {
    $page = find_page_by_id($id);
}
?>

<div id="content">
    <a href="<?php echo buildUrl('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
    <h1>Delete Page</h1>
    <p>Are you sure you want to delete this page?</p>
    <p><strong><?php echo $page['menu_name'] ?></strong></p>
    <form action="<?php echo buildUrl('/staff/pages/delete.php?id=') . $id ?>" method="POST">

        <input type="submit" name="submitButton" value="Delete page">

    </form>

</div>



<?php
include(SHARED_PATH . '/staff_footer.php');

?>