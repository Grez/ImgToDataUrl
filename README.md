# ImgToDataUrl
Converts images in CSS to DataUrl

Usage
-----

```php
$file = new \SplFileInfo(__DIR__ . '/css/test.css');
$imgToDataUrl = new Teddy\ImgToDataUrl();
$imgToDataUrl->setCssFromFile($file);
$imgToDataUrl->setMaxSize(10); // convert only images with size <= 10 KB; (default = 3)
echo $imgToDataUrl->convert();
```

Default public directory is set to $_SERVER['DOCUMENT_ROOT']

You may specify your own with `new Teddy\ImgToDataUrl($file, __DIR__ . '/www');`

There are two ways to pass CSS to `ImgToDataUrl`
-----

Either you pass `\splFileInfo` with `setCssFromFile($file)` or a string with `setCss($css)`.
The first one is better because it keeps information about relative paths

For example with structure

```
www/css/style.css
www/css/images/01.png
```

and

```css
div {background-image: url(./images/01.png)}
```

The first one will look into correct path `www/css/images/01.png` but the second to `www/images/01.png`
