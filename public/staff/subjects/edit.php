<?php

require_once('../../../private/initialize.php');

$menu_name = '';
$position = '';
$visible = '';

if (!isset($_GET['id'])) {
  redirect_to(buildUrl('/staff/subjects/index.php'));
}
$id = $_GET['id'];

$subject_set = subjectsPassQuery();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

?>

<?php
if (is_post_request()) {

  $subject = [];
  $subject['id'] = $id;
  $subject['menu_name'] = $_POST['menu_name'] ?? '';
  $subject['position'] = $_POST['position'] ?? '';
  $subject['visible'] = $_POST['visible'] ?? '';



  $res = update_subject($subject);

  if ($res === true) {
    redirect_to(buildUrl("/staff/subjects/show.php?id=" . $id));
  } else {
    $errors = $res;
    // var_dump($res);
  }
} else {
  $subject = find_subject_by_id($id);
}
?>

<?php $page_title = 'Edit Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a href="<?php echo buildUrl('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject edit">
    <h1>Edit Subject</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo buildUrl('/staff/subjects/edit.php?id=' . h(urlencode($id))); ?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($subject['menu_name']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php for ($i = 1; $i <= $subject_count; $i++) { ?>

              <option value="<?php echo $i ?>" <?php if ($subject['position'] == $i) {
                                                  echo "selected";
                                                } ?>><?php echo $i ?></option>

            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
        <dd><input type="checkbox" name="visible" value="1" <?php if ($subject['visible'] == 1) {
                                                              echo " Checked";
                                                            } ?> /></dd>
        </dd>
      </dl>
      <br />
      <input type="submit" value="Edit Subject" />

    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>