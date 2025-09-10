<?php

return [

    'show_warnings' => false,
    'public_path'   => null,
    'convert_entities' => true,

    'options' => [

        /**
         * مجلد الخطوط (يجب أن يكون موجود وقابل للكتابة)
         */
        'font_dir'   => storage_path('fonts/'),
        'font_cache' => storage_path('fonts/'),

        /**
         * مجلد الملفات المؤقتة
         */
        'temp_dir'   => sys_get_temp_dir(),

        /**
         * منع dompdf من الوصول للملفات خارج مشروعك
         */
        'chroot' => realpath(base_path()),

        /**
         * البروتوكولات المسموحة
         */
        'allowed_protocols' => [
            'data://'  => ['rules' => []],
            'file://'  => ['rules' => []],
            'http://'  => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        'artifactPathValidation' => null,
        'log_output_file'        => null,

        /**
         * تشغيل الـ font subsetting (أفضل لحجم الملف)
         */
        'enable_font_subsetting' => true,

        /**
         * المحرك المستخدم
         */
        'pdf_backend' => 'CPDF',

        /**
         * نوع الوسائط
         */
        'default_media_type' => 'screen',

        /**
         * حجم الصفحة الافتراضي
         */
        'default_paper_size' => 'a4',

        /**
         * اتجاه الصفحة
         */
        'default_paper_orientation' => 'portrait',

        /**
         * الخط الافتراضي
         */
        'default_font' => 'arial',

        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => false,
        'allowed_remote_hosts' => null,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true,
    ],

    /**
     * تعريف الخطوط المخصصة
     */
    'fonts' => [
        'arial' => [
            'normal'      => public_path('fonts/arial.ttf'),
            'bold'        => public_path('fonts/arialbd.ttf'),
            'italic'      => public_path('fonts/ariali.ttf'),
            'bold_italic' => public_path('fonts/arialbi.ttf'),
        ]],
        'font_dir' => public_path('fonts/'),
'font_cache' => storage_path('fonts/'),
'default_font' => 'amiri',

'fonts' => [
    'amiri' => [
        'R'  => 'Amiri-Regular.ttf',
        'B'  => 'Amiri-Bold.ttf',
        'I'  => 'Amiri-Italic.ttf',
        'BI' => 'Amiri-BoldItalic.ttf',
    ],
],

        ];