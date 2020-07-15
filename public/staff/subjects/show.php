<?php
require_once('../../../private/initialize.php');

$id = $_GET['id'] ?? 1;

$res = find_subject_by_id($id);

$page_title = "Show Subjects";
include(SHARED_PATH . "/staff_header.php");

?>


<div id="content">

    <a href="<?php echo buildUrl("/staff/subjects/index.php") ?>">Back to list</a>

    <div id="attributes">
        <h1> Subject : <?php echo $res['menu_name'] ?> </h1>

        <dl>
            <dt>Menu Name</dt>
            <dd><?php echo $res['menu_name'] ?></dd>
        </dl>
        <dl>
            <dt>Position</dt>
            <dd><?php echo $res['position'] ?></dd>
        </dl>
        <dl>
            <dt>Visible</dt>
            <dd><?php echo $res['visible'] == '1' ? 'True' : 'False' ?></dd>
        </dl>

    </div>

</div>


<?php
include(SHARED_PATH . "/staff_footer.php");
?>