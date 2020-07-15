<?php

function subjectsPassQuery()
{
    global $db;
    $query = "SELECT * FROM subjects ";
    $query .= "ORDER BY position ASC";
    $res = mysqli_query($db, $query);
    confirm_result_set($res);
    return $res;
}

function pagesPassQuery()
{
    global $db;
    $query = "SELECT * FROM pages ";
    $query .= "ORDER BY subject_id ASC, position ASC";
    $res = mysqli_query($db, $query);
    confirm_result_set($res);
    return $res;
}

function validate_subject($subject)
{
    $errors = [];
    if (is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank!";
    } elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must consist of 2 up to 255 characters!";
    }

    $position_int = (int) $subject['position'];
    if ($position_int <= 0) {
        $errors[] = "Position must be greater than zero!";
    }
    if ($position_int > 999) {
        $errors[] = "Position must be less than 999!";
    }

    $visible_str = (string) $subject['visible'];
    if (has_exclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be 1 or 0 (True or False)!";
    }

    return $errors;
}

function find_subject_by_id($id)
{
    global $db;
    $sql = "SELECT * FROM subjects WHERE id='" . db_escape($db, $id) . "'";
    $res = mysqli_query($db, $sql);
    confirm_result_set($res);
    $res_assoc_arr = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    return $res_assoc_arr;
}


function insert_subject($subject)
{
    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;

    $sql = "INSERT INTO subjects";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES(";
    $sql .= "'" . db_escape($db, $subject['menu_name']) . "',";
    $sql .= "'" . db_escape($db, $subject['position']) . "',";
    $sql .= "'" . db_escape($db, $subject['visible']) . "'";
    $sql .= ")";

    $res = mysqli_query($db, $sql);
    if (!$res) {
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    } else {
        return true;
    }
}

function update_subject($subject)
{
    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    $sql = "UPDATE subjects SET ";
    $sql .= "menu_name='" . db_escape($db, $subject['menu_name']) . "' , ";
    $sql .= "position='" . db_escape($db, $subject['position']) . "' , ";
    $sql .= "visible='" . db_escape($db, $subject['visible']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
    $sql .= "LIMIT 1";

    $res_update = mysqli_query($db, $sql);
    if ($res_update) {
        return true;
        // redirect_to(buildUrl('/staff/subjects/show.php?id='. $id));
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_subject($id)
{
    global $db;
    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "Limit 1";

    $res = mysqli_query($db, $sql);

    if ($res) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_page($page)
{
    $errors = [];

    if (is_blank($page['menu_name'])) {
        $errors[] = "Name cannot be blank!";
    }elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must consist of 2 uo to 255 characters!";
    }

    $position_int = (int) $page['position'];
    if ($position_int <= 0) {
        $errors[] = "Position must be greater than zero!";
    }
    if ($position_int > 999) {
        $errors[] = "Position must be less than 999!";
    }

    $visible_str = (string) $page['visible'];
    if (has_exclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be 1 or 0 (True or False)!";
    }

    if (is_blank($page['content'])) {
        $errors[] = "Every page must have content!!";
    }

    $subjects_set = subjectsPassQuery();
    $subject_ids = [];
    while ($subject = mysqli_fetch_assoc($subjects_set)) {
        $subject_ids[] = $subject['id'];
    }

    if (!has_inclusion_of($page['subject_id'] , $subject_ids)) {
        $errors[] = "You must choose subject from the subject list";
    }
    mysqli_free_result($subjects_set);

    if (!has_unique_page_menu_name($page['menu_name'] , $page['id'])){
        $errors[] = "Your page name must be different from the othres!";
    }

    return $errors;

    
}

function find_page_by_id($id)
{
    global $db;
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";

    $res = mysqli_query($db, $sql);
    confirm_result_set($res);
    $res_assoc = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    return $res_assoc;
}

function find_pages_by_subject_id($subject_id)
{
    global $db;
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
    $sql .= "ORDER BY position ASC";
    $res = mysqli_query($db, $sql);
    confirm_result_set($res);
    return $res;
}


function insert_page($page)
{

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content)";
    $sql .= "VALUES('";
    $sql .= db_escape($db, $page['subject_id']) . "', '";
    $sql .= db_escape($db, $page['menu_name']) . "', '";
    $sql .= db_escape($db, $page['position']) . "', '";
    $sql .= db_escape($db, $page['visible']) . "', '";
    $sql .= db_escape($db, $page['content']) . "' )";


    $res = mysqli_query($db, $sql);

    if (!$res) {
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    } else {
        return true;
    }
}

function update_page($page)
{

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "' , ";
    $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "' , ";
    $sql .= "position='" . db_escape($db, $page['position']) . "' , ";
    $sql .= "visible='" . db_escape($db, $page['visible']) . "' ,";
    $sql .= "content='" . db_escape($db, $page['content']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
    $sql .= "LIMIT 1";

    $res_update = mysqli_query($db, $sql);
    if (!$res_update) {
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    } else {
        return true;
    }
}

function delete_page($id)
{
    global $db;
    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";

    $res_delete = mysqli_query($db, $sql);
    if (!$res_delete) {
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    } else {
        return true;
    }
}
