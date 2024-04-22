<?php

if (!function_exists('UploadFile')) {
    function dot_name($name) {
        return str_replace('[', '.', str_replace(']', '', $name));
    }
}