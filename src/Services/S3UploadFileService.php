<?php

namespace SudoCoder\S3;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;


class S3UploadFileService extends ServiceProvider{

    public function __construct()
    {
        
    }

    public function getS3Config()
    {
        return [
            'aws_key'                 => config('S3upload.aws_access_key_id'),
            'aws_secret_key'          => config('S3upload.aws_secret_access_key'),
            'aws_default_region'      => config('S3upload.aws_default_region'),
            'aws_upload_bucket'       => config('S3upload.aws_upload_bucket'),
            'aws_destination_bucket'  => config('S3upload.aws_destination_bucket'),
            'aws_source_bucket'       => config('S3upload.aws_source_bucket'),
            'aws_upload_file_folder'  => config('S3upload.aws_upload_file_folder'),
            'aws_upload_image_folder' => config('S3upload.aws_upload_image_folder'),
        ];
    }
   
    public function checkS3Client()
    {
        $config = $this->getS3Config();
    
        $client = new S3Client([
            'version' => 'latest',
            'region'  => $config['aws_default_region'],
            'credentials' => [
                'key'    => $config['aws_key'],
                'secret' => $config['aws_secret_key'],
            ]
        ]);
        
        return $client;
    }
  
    public function upload($file)
    {
        try {
            $config           = $this->getS3Config();
            $uploadBucket     = $config['aws_upload_bucket'];
            $uploadFileFolder = $config['aws_upload_file_folder'] ? $config['aws_upload_file_folder'].'/' : '' ;
    
            $options = ['visibility' => 'public', 'mimetype' => 'binary/octet-stream'];
            $path    = $uploadFileFolder . $file;
    
            $client = $this->checkS3Client();
            $result = $client->putObject([
                'Bucket' => $uploadBucket,
                'Key' => $path,
                'Body' => file_get_contents($file),
                'ContentType' => $options['mimetype'],
                'ACL' => 'public-read', // Assuming you want the uploaded file to be publicly accessible
            ]);
    
            // Check if the upload was successful
            if ($result['@metadata']['statusCode'] === 200) {
                // Get the public URL of the uploaded file
                return $client->getObjectUrl($uploadBucket, $path);
            } else {
                return 'Error: File upload failed';
            }
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    
    public function copy($file)
    {
        try {
            $client                  = $this->checkS3Client(); // check S3 client with AWS Access Keys
            $awsBuckets              = $this->getS3Config(); // get S3 config file 

            // AWS buckets and folder detail
            $destinationBucket       = $awsBuckets['aws_destination_bucket'];
            $sourceBucket            = $awsBuckets['aws_source_bucket'];
            $sourceBucketFolder      = $awsBuckets['aws_source_folder'] ? $awsBuckets['aws_source_folder'] . '/' : '';
            $destinationBucketFolder = $awsBuckets['aws_destination_folder'] ? $awsBuckets['aws_destination_folder'].'/' : '' ;

            // set file location with folder name
            $sourcePath              = $sourceBucketFolder . $file;
            $destinationPath         = $destinationBucketFolder . $file;
            
            $exists = $this->hasFile($sourceBucket, $sourceBucketFolder, $file); // check file existance and return value
        
            if ($exists) {
                $transferred = $client->copyObject([
                    'Bucket' => $destinationBucket,
                    'Key' => $destinationPath,
                    'CopySource' => "{$sourceBucket}/{$sourcePath}"
                ]);

                if ($transferred) {
                    return 'Success: Image Copied: ' . $file;
                }

                return 'Error: Image Not Copied: ' . $file;
            } else {
                return 'Error: Image Not Found: ' . $file;
            }
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function download($filePath)
    {
        return response()->download($filePath, basename($filePath), [
            'Content-Type' => 'application/octet-stream',
            'Content-Transfer-Encoding' => 'Binary',
            'Content-disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ]);
    }

    public function hasFile($aws_bucket_name, $aws_source_folder, $file)
    {
        try {
            $client     = $this->checkS3Client();
            $bucketName = $aws_bucket_name ? $aws_bucket_name . '/' : '';
            $folderName = $aws_source_folder ? $aws_source_folder.'/' : '' ;

            $fileLocation = $folderName . $file;
            
            return $client->doesObjectExist($bucketName, $fileLocation);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}