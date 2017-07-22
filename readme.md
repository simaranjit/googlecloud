Download `GoogleClouldStorageServiceProvider.php` file and put it under `app/providers` directory.

##How to use this library
You need to simply use below namespace to use it's functions.
```
use App\Providers\GoogleCloudStorageServiceProvider;
```

**How to instantiate this class**
```
$googleCloud = new GoogleCloudStorageServiceProvider('project-id');
```

**Create a bucket**

```
$googleCould->createBucket('bucket-name')
```

**Retrieve a bucket information**

```
$googleCould->getBucketInfo('bucket-name')
```

**Retrieve list of buckets**

```
$googleCould->getBuckets()
```

**Check existance of a bucket**

```
$googleCould->bucketExists('bucket-name')
```

**Upload a file in a bucket**

```
$googleCould->uploadFile('bucket-name', 'file-name', 'file-content')
```

**Retrieve list of files in a bucket**

```
$googleCould->getFiles('bucket-name')
```

**Get file information**

```
$googleCould->getFileInfo('bucket-name', 'file-name')
```

**Get file content**

```
$googleCould->getFileInfo('bucket-name', 'file-name')
```








