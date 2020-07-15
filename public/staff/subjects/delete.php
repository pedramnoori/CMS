<?php require_once('../../../private/initialize.php'); ?>

<?php

if (!isset($_GET['id'])) {
    redirect_to(buildUrl('/staff/subjects/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {

    $res = delete_subject($id);

    redirect_to(buildUrl('/staff/subjects/index.php'));
} else {
    $subject = find_subject_by_id($id);
}
$page_title = "Delete Subject";
include(SHARED_PATH . '/staff_header.php');

?>

<div id="content">

    <a href="<?php echo buildUrl('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this subject?</p>
    <p><strong><?php echo h($subject['menu_name']); ?></strong></p>
    <br></br>

    <form action="<?php echo buildUrl('/staff/subjects/delete.php?id=' . $subject['id']) ?>" method="POST">
        <div>
            <input type="submit" value="Delete Subject" name="comit"></input>
        </div>
    </form>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>