# ImgToDataUrl
Converts images in CSS to DataUrl

Usage
-----

```php
$file = new \SplFileInfo(__DIR__ . '/css/test.css');
$imgToDataUrl = new Teddy\ImgToDataUrl($file);
$imgToDataUrl->setMaxSize = 3; // convert only images with size <= 3 KB; (default = 5)
$imgToDataUrl->setMaxSizeTotal = 200; // we don't our CSS file to be too huge...; (default = 100)
echo $imgToDataUrl->convert();
```

Default public directory is set to $_SERVER['DOCUMENT_ROOT']

You may specify your own with `new Teddy\ImgToDataUrl($file, __DIR__ . '/www');`
