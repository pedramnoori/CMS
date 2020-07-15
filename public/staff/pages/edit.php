<?php
require_once('../../../private/initialize.php');



$menu_name = '';
$visible = '';
$position = '';

if (!isset($_GET['id'])) {
    redirect_to(buildUrl('/staff/pages/index.php'));
}

$page_title = 'Edit page';
include(SHARED_PATH . '/staff_header.php');

$id = $_GET['id'];
$pages_set = pagesPassQuery();
$number_of_pages = mysqli_num_rows($pages_set);
mysqli_free_result($pages_set);



if (is_post_request()) {
    $page = [];

    $page['id'] = $id;
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';


    $res = update_page($page);
    if ($res === true) {
        redirect_to(buildUrl('/staff/pages/show.php?id=') . h(urlencode($id)));
    } else {
        $errors = $res;
    }
} else {

    $page = find_page_by_id($id);

}
?>
<br />
<div id="content">

    <a class="back-link" href="<?php echo buildUrl('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

    <div class="page new">
        <h1>Edit Page</h1>

        <?php echo display_errors($errors) ?>

        <form action="<?php echo buildUrl('/staff/pages/edit.php?id=' . urlencode(h($id))) ?>" method="POST">
            <?php $subjects_set = subjectsPassQuery(); ?>
            <dl>
                <dt>Subject</dt>
                <dd>
                    <select name="subject_id">
                        <?php while ($subject = mysqli_fetch_assoc($subjects_set)) { ?>
                            <option value="<?php echo $subject['id'] ?>" <?php if ($page['subject_id'] == $subject['id']) {
                                                                                echo "selected";
                                                                            } ?>>
                                <?php echo h($subject['menu_name']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </dd>
            </dl>

            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']) ?>" /></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php for ($i = 1; $i <= $number_of_pages; $i++) { ?>
                            <option value="<?php echo $i ?>" <?php if ($page['position'] == $i) {
                                                                    echo " selected";
                                                                } ?>>
                                <?php echo $i ?>
                            </option>
                        <?php } ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><input type="hidden" name="visible" value="0" /></dd>
                <dd><input type="checkbox" name="visible" value="1" <?php if ($page['visible'] == 1) {
                                                                        echo " checked";
                                                                    } ?> /></dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd><textarea value="" name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea></dd>
            </dl>
            <dl>
                <dd><input type="submit" name="submit" value="Edit page" /></input></dd>
            </dl>

        </form>



    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php');
?>