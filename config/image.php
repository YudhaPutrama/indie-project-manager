<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'dir'=> [
        'projects'=> [
            'photos' => '/uploads/projects/photos/',
            'picture' => '/uploads/projects/pictures/'
        ],

        'avatar' => '/uploads/avatar/',
        'post' => '/uploads/blog/',
        'postThumb' => '/uploads/blog/thumb/',
    ]

);
