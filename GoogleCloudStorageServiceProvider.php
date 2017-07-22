<?php

namespace App\Providers;

use Exception;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\ServiceProvider;

class GoogleCloudStorageServiceProvider extends ServiceProvider {

    private $storage;

    /**
     * @param string $projectID
     */
    public function __construct($projectID) {
        // Skip it
        # Your Google Cloud Platform project ID
        $projectId = 'deep-byte-172204';

        # Instantiates a client
        $this->storage = new StorageClient([
            'projectId' => $projectId
        ]);
    }

    /**
     * Returns list of all buckets available
     * 
     * @return array
     */
    public function getBuckets() {
        $buckets = [];

        foreach ($this->storage->buckets() as $bucket) {
            $buckets[] = $bucket->info();
        }

        return $buckets;
    }

    /**
     * Checks existence of bucket on the basis of name
     * 
     * @param string $bucketName
     * 
     * @return bool
     */
    public function bucketExists($bucketName) {
        $bucket = $this->storage->bucket($bucketName);
        if (!$bucket->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Returns bucket info
     * 
     * @param string $bucketName
     * 
     * @return array
     */
    public function getBucketInfo($bucketName) {
        $bucket = $this->storage->bucket($bucketName);
        if (!$bucket->exists()) {
            throw new Exception('Bucket does not exist');
        }

        return $bucket->info();
    }

    /**
     * Used to create a bucket
     * 
     * @param string $bucketName
     * 
     * @return array
     * @throws Exception
     */
    public function createBucket($bucketName) {
        $bucket = $this->storage->createBucket($bucketName);

        if (!$bucket->exists()) {
            throw new Exception('Bucket does not exist');
        }

        return $bucket->info();
    }

    /**
     * Upload a file to the bucket
     * 
     * @param string $name
     * @param string $content
     * 
     * @return array
     * @throws Exception
     */
    public function uploadFile($bucketName, $fileName, $content) {
        $bucket = $this->storage->bucket($bucketName);
        if (!$bucket->exists()) {
            throw new Exception('Bucket does not exist');
        }

        $file = $bucket->upload($content, ['name' => $fileName, 'predefinedAcl' => 'publicRead']);

        return $file->info();
    }

    /**
     * Retrieve list of files under a bucket
     * 
     * @param string $bucketName
     * @param string $fileName
     * 
     * @return array
     * @throws Exception
     */
    public function getFiles($bucketName) {
        $bucket = $this->storage->bucket($bucketName);
        if (!$bucket->exists()) {
            throw new Exception('Bucket does not exist');
        }

        $objects = $bucket->objects();

        $files = [];
        foreach ($objects as $file) {
            $files[] = $file->info();
        }
        
        return $files;
    }
    
    /**
     * Retrieve information of a file
     * 
     * @param string $bucketName
     * @param string $fileName
     * 
     * @return array
     * @throws Exception
     */
    public function getFileInfo($bucketName, $fileName) {
        $bucket = $this->storage->bucket($bucketName);
        if (!$bucket->exists()) {
            throw new Exception('Bucket does not exist');
        }

        $file = $bucket->object($fileName);
        if (!$file->exists()) {
            throw new Exception('File does not exist');
        }

        return $file->info();
    }

    /**
     * Get contents of a file
     * 
     * @param string $bucketName
     * @param string $fileName
     * 
     * @return string
     * @throws Exception
     */
    public function getFileContent($bucketName, $fileName) {
        $bucket = $this->storage->bucket($bucketName);
        if (!$bucket->exists()) {
            throw new Exception('Bucket does not exist');
        }

        $file = $bucket->object($fileName);
        if (!$file->exists()) {
            throw new Exception('File does not exist');
        }

        return $file->downloadAsString();
    }

}
