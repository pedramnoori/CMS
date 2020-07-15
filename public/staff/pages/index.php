<?php
require_once("../../../private/initialize.php");

$page_title = "Pages";
include(SHARED_PATH . "/staff_header.php");
?>

<?php
$pages_set = pagesPassQuery();
?>


<div id="content">
  <div class="pages listing">
    <h1>Pages</h1>
    <div>
      <a href="<?php echo buildUrl('/staff/pages/new.php') ?>">Create New Page</a>
    </div>
    <br />
    <table class="list">
      <tr>
        <th>ID</th>
        <th>Subject</th>
        <th>Position</th>
        <th>Visible</th>
        <th>Category</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php while ($page = mysqli_fetch_assoc($pages_set)) { ?>
        <?php $subject = find_subject_by_id($page['subject_id']) ?>
        <tr>
          <td>
            <?php echo h(urlencode($page['id'])); ?>
          </td>
          <td>
            <?php echo h(($subject['menu_name'])); ?>
          </td>
          <td>
            <?php echo h($page['position']); ?>
          </td>
          <td>
            <?php echo h($page['visible']) ? 'True' : 'False'; ?>
          </td>
          <td>
            <?php echo h($page['menu_name']); ?>
          </td>
          <td>
            <a href="<?php echo buildUrl('/staff/pages/show.php?id=' . h(urlencode($page['id']))); ?>">View</a>
          </td>
          <td>
            <a href="<?php echo buildUrl('/staff/pages/edit.php?id=' . h(urlencode($page['id']))); ?>">Edit</a>
          </td>
          <td>
            <a href="<?php echo buildUrl('/staff/pages/delete.php?id=' . h(urlencode($page['id']))); ?>">Delete</a>
          </td>
        </tr>

      <?php } ?>
    </table>
    <?php mysqli_free_result($pages_set) ?>
  </div>
</div>



<?php

include(SHARED_PATH . "/staff_footer.php");


?>