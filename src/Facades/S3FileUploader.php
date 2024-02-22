<?php

namespace SudoCoder\S3;

use Illuminate\Support\Facades\Facade;

class S3FileUploader extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 's3-upload-file';
    }
}
