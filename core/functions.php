<?php

/**
 * Dumps the data on the screen
 * @param $data
 */
function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}

function view($file, $data = [])
{
    $file = str_replace('.', '/', $file);
    extract($data);
    require "views-may-be-vue/{$file}.view.php";
}

function redirect($path)
{
    header("Location: {$path}");
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}