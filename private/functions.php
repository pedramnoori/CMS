<?php

function h($string = "")
{
    return htmlspecialchars($string);
}

function error_404()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}

function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

function buildUrl($address = "")
{
    return WWW_ROOT . $address;
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit();
}

function is_post_request()
{
    return ($_SERVER['REQUEST_METHOD'] == 'POST');
}

function is_get_request()
{
    return ($_SERVER['REQUEST_METHOD'] == 'GET');
}

function display_errors($errors = [])
{
    $output = "";
    if (!empty($errors)) {
        $output = "<div class=\"errors\" > ";
        $output .= "<p>Please fix these errors :</p>";
        $output .= "<ul>";
        foreach ($errors as $error) {
            $output .= "<li> " . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";

    }
    return $output;
}
