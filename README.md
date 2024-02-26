# Laravel S3 File Management Package

## Introduction

This Laravel package simplifies file management on Amazon S3 for your application. It provides functionality for uploading, copying between buckets, checking file existence, and downloading files effortlessly.

## Installation

Install the package using Composer:

```bash

composer require sudocoder/s3fileuploader
```
## Configuration

**Set the following environment variables in your Laravel project's .env file:**
```
AWS_ACCESS_KEY_ID= //Your AWS Access Key ID.
AWS_SECRET_ACCESS_KEY=  //Your AWS Secret Access Key.
AWS_DEFAULT_REGION= //The AWS region, e.g., us-east-1.
AWS_UPLOAD_BUCKET= //Target bucket for file uploads.
AWS_DESTINATION_BUCKET= //Destination bucket for file copying.
AWS_SOURCE_BUCKET= //Source bucket for file operations.
AWS_SOURCE_FOLDER= //Source folder for operations involving folders.
AWS_DESTINATION_FOLDER= //Destination folder for copying files.
AWS_UPLOAD_FILE_FOLDER= //Folder for uploading files.
APP_UPLOAD_IMAGE_FOLDER= //Folder for application-specific file uploads.
AWS_USE_PATH_STYLE_ENDPOINT=  //Set to true if using a path-style S3 endpoint, otherwise false.
```

#### Usage

##### Upload File

*To upload a file to S3, use the following:*
```
use SudoCoder\S3\S3FileUploader;

// Specify the file path and destination bucket

S3FileUploader::upload('local/path/to/file.txt');
```

##### Copy File Between Buckets

*To copy a file from one bucket to another:*
```
use SudoCoder\S3\S3FileUploader;

// Specify the file name and source/destination buckets and folder if any in env file

S3FileUploader::copyFile('file.txt');
```

##### Check File Existence
*To check if a file exists on S3:*
```
use SudoCoder\S3\S3FileUploader;

// Specify the file name and the bucket
if (S3FileUploader::fileExists('file.txt', 'AWS_SOURCE_BUCKET', 'AWS_SOURCE_BUCKET_FOLDER')) {
    // File exists
} else {
    // File does not exist
}
```

##### Download File
*To download a file from S3:*
```
use SudoCoder\S3\S3FileUploader;


// Specify the file name and the bucket
S3FileUploader::download('file.txt', 'AWS_SOURCE_BUCKET', 'AWS_SOURCE_BUCKET_FOLDER');
```

## Contribution

Feel free to contribute to this package by creating issues or submitting pull requests.

## License
This package is open-source and available under the MIT License.








