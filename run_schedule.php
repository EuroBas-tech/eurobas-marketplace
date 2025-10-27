<?php

// تحميل ملف التطبيق Laravel
require_once __DIR__ . '/../bootstrap/autoload.php'; // المسار إلى autoload.php
$app = require_once __DIR__ . '/../bootstrap/app.php'; // المسار إلى app.php

// تشغيل جدول المهام (schedule)
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->schedule();