<navigation>

    <?php
    // $s_id = $_GET['s_id'] ?? '';
    // $p_id = $_GET['id'] ?? '';
    ?>

    <?php $nav_subjects = subjectsPassQuery() ?>
    <ul class="subjects">
        <?php while ($nav_subject = mysqli_fetch_assoc($nav_subjects)) { ?>
            <li class=<?php if ($s_id == $nav_subject['id']) {
                            echo "selected_sub";
                        } ?>>
                <a href="<?php echo buildUrl("/index.php?s_id=" . $nav_subject['id']); ?>">
                    <?php echo h($nav_subject["menu_name"]); ?>
                </a>
                <?php if ($s_id == $nav_subject["id"]) {
                $pages_by_subject = find_pages_by_subject_id($nav_subject["id"]);
                ?>
                    <ul class="pages">
                        <?php while ($page_by_subject = mysqli_fetch_assoc($pages_by_subject)) { ?>
                            <li class=<?php if ($p_id == $page_by_subject['id']) {
                                            echo 'selected';
                                        } ?>>
                                <a href="<?php echo buildUrl("/index.php?id=" . h(urlencode($page_by_subject['id']))) ?>"><?php echo $page_by_subject["menu_name"] ?></a>
                            </li>
                        <?php } ?>
                        <?php mysqli_free_result($pages_by_subject) ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
    <?php mysqli_free_result($nev_subjects) ?>


</navigation>