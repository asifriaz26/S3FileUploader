<?php

namespace SudoCoder\S3fileuploader\Providers;

use Illuminate\Support\ServiceProvider;
use SudoCoder\S3fileuploader\Services\S3UploadFileService;
use SudoCoder\S3fileuploader\Facades\S3FileUploader as S3FileUploaderFacadeAlias;

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
