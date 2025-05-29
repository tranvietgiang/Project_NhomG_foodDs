<?php
return [
    'show_warnings' => false,
    'public_path' => public_path(),
    'convert_entities' => false, // Tắt để tránh lỗi ký tự đặc biệt như ₫
    'options' => [
        'font_dir' => storage_path('fonts'), // Thư mục chứa font
        'font_cache' => storage_path('fonts'),
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => realpath(base_path()),
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],
        'artifactPathValidation' => null,
        'log_output_file' => null,
        'enable_font_subsetting' => true, // Bật để nhúng glyph tiếng Việt
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',
        'default_font' => 'Roboto', // Sử dụng font Roboto
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => false, // Tắt vì PDF tĩnh không cần JS
        'enable_remote' => true, // Bật nếu cần tải hình ảnh từ URL
        'allowed_remote_hosts' => null,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true,
    ],
];
