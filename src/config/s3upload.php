<?php
    return [

        // credentials to access the S3
        'aws_access_key_id'           => env('AWS_ACCESS_KEY_ID'),
        'aws_secret_access_key'       => env('AWS_SECRET_ACCESS_KEY'),
        'aws_default_region'          => env('AWS_DEFAULT_REGION'),
        
        // to upload on bucket
        'aws_upload_bucket'           => env('AWS_UPLOAD_BUCKET'),

        // to copy or move on buckets
        'aws_destination_bucket'      => env('AWS_DESTINAITON_BUCKET'),
        'aws_source_bucket'           => env('AWS_SOURCE_BUCKET'),
        'aws_source_folder'           => env('AWS_SOURCE_FOLDER'),
        'aws_destination_folder'      => env('AWS_DESTINAITON_FOLDER'),


        // to upload in bucket folder
        'aws_upload_file_folder'      => env('AWS_UPLOAD_FILE_FOLDER'),
        'aws_upload_image_folder'     => env('APP_UPLOAD_IMAGE_FOLDER'),

        /*
        |--------------------------------------------------------------------------
        | Class Aliases
        |--------------------------------------------------------------------------
        |
        | This array of class aliases will be registered when this application
        | is started. However, feel free to register as many as you wish as
        | the aliases are "lazy" loaded so they don't hinder performance.
        |
        */
        'alias' => 'S3FileUploader',
    ];
?>