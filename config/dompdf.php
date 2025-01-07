<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    'public_path' => null,  // Override the public path if needed

    /*
     * Dejavu Sans font is missing glyphs for converted entities, turn it off if you need to show € and £.
     */
    'convert_entities' => true,

    'options' => [
        /**
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         */
        'isRemoteEnabled' => true, // This allows DomPDF to load remote files (like 'file:///' paths)
        'isHtml5ParserEnabled' => true,
        'isPhpEnabled' => true,

        'font_dir' => storage_path('fonts/'), // custom font directory
        'font_cache' => storage_path('fonts/'), 
        'default_font' => 'Arial', 
        'default_font_size' => 11, // Set the default font size to 12
        'font_height_ratio' => 1.0, 

        'font_data' => [
            'roboto' => [
                'R'  => 'Roboto-Regular.ttf',    // Regular font
                'B'  => 'Roboto-Bold.ttf',       // Bold font
                'I'  => 'Roboto-Italic.ttf',     // Italic font
                'BI' => 'Roboto-BoldItalic.ttf'  // Bold + Italic font
            ],
            'timesnewroman' => [
                'R'  => 'timesnewroman.ttf', 
                'B'  => 'timesnewromanbold.ttf', 
                'I'  => 'timesnewromanitalic.ttf', 
                'BI' => 'timesnewromanbolditalic.ttf'
            ],
        ],

        /**
         * The location of a temporary directory.
         *
         * The directory specified must be writeable by the webserver process.
         * The temporary directory is required to download remote images and when
         * using the PDFLib back end.
         */
        'temp_dir' => sys_get_temp_dir(),

        /**
         * dompdf's "chroot": Prevents dompdf from accessing system files or other
         * files on the webserver.  All local files opened by dompdf must be in a
         * subdirectory of this directory. 
         */
        'chroot' => realpath(base_path()),

        /**
         * Protocol whitelist
         */

         
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        /**
         * Operational artifact (log files, temporary files) path validation
         */
        'artifactPathValidation' => null,

        /**
         * Whether to enable font subsetting or not.
         */
        'enable_font_subsetting' => false,

        /**
         * The PDF rendering backend to use
         */
        'pdf_backend' => 'CPDF',

        /**
         * The default paper size (A4, letter, etc.)
         */
        'default_paper_size' => 'a4',

        /**
         * The default paper orientation (portrait, landscape)
         */
        'default_paper_orientation' => 'portrait',

        /**
         * The default font family
         */
        'default_font' => 'serif',

        /**
         * Image DPI setting
         */
        'dpi' => 96,

        /**
         * Enable embedded PHP
         */
        'enable_php' => false,

        /**
         * Enable inline JavaScript
         */
        'enable_javascript' => true,

        /**
         * Enable remote file access
         */
        'enable_remote' => false,

        /**
         * List of allowed remote hosts
         */
        'allowed_remote_hosts' => null,

        /**
         * A ratio applied to the fonts height to be more like browsers' line height
         */
        'font_height_ratio' => 1.1,

        /**
         * Use the HTML5 Lib parser (always on in dompdf 2.x)
         */
        'enable_html5_parser' => true,
    ],

];
