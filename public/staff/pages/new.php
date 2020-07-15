<?php
require_once('../../../private/initialize.php');


if (is_post_request()) {

    $page = [];

    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';


    $res = insert_page($page);
    if ($res === true) {
        $id = mysqli_insert_id($db);
        redirect_to(buildUrl('/staff/pages/show.php?id=') . $id);
    } else {
        $errors = $res;
    }
}
// $page = [];
$pages = pagesPassQuery();
$number_of_rows = mysqli_num_rows($pages);
mysqli_free_result($pages);
$page['position'] = $number_of_rows + 1;

$subjects_set = subjectsPassQuery();

$page_title = 'Create page';
include(SHARED_PATH . '/staff_header.php');

?>
<br />
<div id="content">

    <a class="back-link" href="<?php echo buildUrl('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

    <div class="page new">
        <h1>Create Page</h1>
        <?php echo display_errors($errors) ?>

        <form action="<?php echo buildUrl('/staff/pages/new.php') ?>" method="POST">

            <dl>
                <dt>Subject</dt>
                <dd>
                    <select name="subject_id">
                        <?php while ($subject = mysqli_fetch_assoc($subjects_set)) { ?>
                            <option value="<?php echo $subject['id'] ?>" <?php if ($page['subject_id'] == $subject['id']) {
                                echo 'selected';
                            } ?>> <?php echo h($subject['menu_name']) ?> </option>
                        <?php } ?>
                        <?php mysqli_free_result($subjects_set) ?>

                    </select>
                </dd>
            </dl>

            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="<?php echo $page['menu_name'] ?>" /></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php for ($i = 1; $i <= $number_of_rows + 1; $i++) { ?>

                            <option value="<?php echo $i ?>" <?php if ($page['position'] == $i) {
                                                                    echo " selected";
                                                                } ?>> <?php echo $i ?> </option>

                        <?php } ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><input type="hidden" name="visible" value="0" /></dd>
                <dd><input type="checkbox" name="visible" value="1" /></dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd><textarea name="content" value="" cols="60" rows="10"><?php echo h($page['content']) ?></textarea></dd>
            </dl>
            <br />
            <dl>
                <dd><input type="submit" name="submit" value="Create page" /></input></dd>
            </dl>

        </form>



    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php');
?>