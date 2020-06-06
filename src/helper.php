<?php

if (! function_exists('controller_path')) {
    /**
     * Get the path to the controller folder.
     *
     * @param  string  $path
     * @return string
     */
    function controller_path($path = '')
    {
        return app_path("Http/Controllers/{$path}");
    }
}

if (! function_exists('request_path')) {
    /**
     * Get the path to the request folder.
     *
     * @param  string  $path
     * @return string
     */
    function request_path($path = '')
    {
        return app_path("Http/Requests/{$path}");
    }
}
