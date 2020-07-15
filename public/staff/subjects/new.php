<?php

require_once('../../../private/initialize.php');
$subject = [];


if (is_post_request()) {

  $subject = [];
  $subject['menu_name'] = $_POST['menu_name'] ?? '';
  $subject['position'] = $_POST['position'] ?? '';
  $subject['visible'] = $_POST['visible'] ?? '';


  $insert_q = insert_subject($subject);

  if ($insert_q === true) {

    $new_ID = mysqli_insert_id($db);
    redirect_to(buildUrl('/staff/subjects/show.php?id=' . h(urlencode($new_ID))));
  } else {
    // echo $subject['menu_name'];
    $errors = $insert_q;
  }
}


$subject_set = subjectsPassQuery();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

$subject['position'] = $subject_count + 1;

?>

<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo buildUrl('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject new">
    <h1>Create Subject</h1>
    <?php echo display_errors($errors); ?>

    <form action="<?php echo buildUrl('/staff/subjects/new.php'); ?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($subject['menu_name']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php for ($i = 1; $i <= $subject_count + 1; $i++) { ?>

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
          <input type="checkbox" name="visible" value="1" <?php if ($subject['visible'] === '1') { echo " checked";} ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Subject" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>