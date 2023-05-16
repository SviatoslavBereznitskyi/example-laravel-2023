<?php

declare(strict_types=1);

use App\Http\Admin\Image\ImageUploadController;

Route::get('', ['as' => 'admin.dashboard', static function () {
    $content = 'Define your dashboard here.';
    return AdminSection::view($content, 'Dashboard');
}]);

Route::get('information', ['as' => 'admin.information', static function () {
    $content = 'Define your information here.';
    return AdminSection::view($content, 'Information');
}]);

Route::post('storage/images_admin', ImageUploadController::class)->name('upload.image.s3');
