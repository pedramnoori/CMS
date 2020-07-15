<?php
require_once("../private/initialize.php");
require_once(SHARED_PATH . "/public_header.php");
?>

<?php

if (isset($_GET['id'])) {
  $p_id = $_GET['id'];
  $page = find_page_by_id($p_id);
  $s_id = $page['subject_id'];
} elseif (isset($_GET['s_id'])) {
  $s_id = $_GET['s_id'];
  $page_set = find_pages_by_subject_id($s_id);
  $page = mysqli_fetch_assoc($page_set);
  mysqli_free_result($page_set);

  $p_id = $page['id'];
}

?>

<div id="main">

  <?php include(SHARED_PATH . "/public_navigation.php") ?>

  <div id="page">
    <?php

    if (isset($page)) {
      echo $page['content'] ;
    } else {
      include(SHARED_PATH . "/static_homepage.php");
    }

    ?>
  </div>

</div>

<?php
require_once(SHARED_PATH . "/public_footer.php");
?>