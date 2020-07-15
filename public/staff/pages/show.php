<?php
require_once('../../../private/initialize.php');

$page_title = "Show Pages";
include(SHARED_PATH . "/staff_header.php");

if (!isset($_GET['id'])){
    redirect_to(buildUrl('/staff/pages/index.php'));
}else {
    $id = $_GET['id'];
}

$page = find_page_by_id($id);

?>


<div id="content">
    <a href="<?php echo WWW_ROOT . "/staff/pages/index.php" ?>">Back to list</a>

    <div id="operation">
        <?php $subject = find_subject_by_id($page['subject_id']) ?>
        <h1>Page : <?php echo h($page['menu_name']) ?></h1>
        <dl>
            <dt>Subject</dt>
            <dd><?php echo h($subject['menu_name']) ?></dd>
        </dl>
        <dl>
            <dt>Menu Name</dt>
            <dd><?php echo h($page['menu_name']) ?></dd>
        </dl> 
        <dl>
            <dt>Position</dt>
            <dd><?php echo h($page['position']) ?></dd>
        </dl> 
        <dl>
            <dt>Visible</dt>
            <dd><?php echo h($page['visible']) ? 'True' : 'False';  ?></dd>
        </dl>
        <dl>
            <dt>Content</dt>
            <dd><?php echo h($page['content']) ?></dd>
        </dl>
    
    </div>
</div>


<?php
include(SHARED_PATH . "/staff_footer.php");
?>