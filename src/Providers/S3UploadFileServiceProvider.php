<?php

namespace Asif\S3;

use Illuminate\Support\ServiceProvider;
use Asif\S3\S3UploadFileService;
use Asif\S3\S3FileUploader as S3FileUploaderFacadeAlias;

class S3UploadFileServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('s3-upload-file', function ($app) {
            return new S3UploadFileService();
        });

        $this->app->alias('s3-upload-file', S3FileUploaderFacadeAlias::class);  
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $this->mergeConfigFrom(
            __DIR__.'/config/s3upload.php', config_path('s3upload.php')
        );

        $this->publishes([
            __DIR__.'/config/s3upload.php' => config_path('s3upload.php')
        ], 's3upload');


    }
}