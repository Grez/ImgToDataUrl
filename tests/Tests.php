<?php

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/ImgToDataUrl/ImgToDataUrl.php';

Tester\Environment::setup();

class Tests extends Tester\TestCase
{

    /**
     * Image from WWW_DIR && quotes
     */
    public function testOne()
    {
        $expected = ".test1 {background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsIAAA7CARUoSoAAAADISURBVGhD7dmxDcIwEIXhZ2aBJcgEYZBQwiikDIOECWAEmmSXw5GupfNZL9b7pCjydb8sK5GcLEMDDv7ePYWwUQgbhbBRCBuFsFEIG4WwUQibwJAVY5eQUkI3rj6LExPyuuaAE+4fX1dQOMR34fIEzg8s8+DzeIVDFnzzLgyzwd43HH1aQ+GQHpMZpt6XFQUe9roUwkYhbBTCppkQbNcK5cyWf0q2a4r/T/7sR2hmR3TRw0YhbBTCRiFsFMJGIWwUwkYhbBoJAX7xb8uu6HXd0wAAAABJRU5ErkJggg==) no-repeat 50% 100%}
.test2 {background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsIAAA7CARUoSoAAAADISURBVGhD7dmxDcIwEIXhZ2aBJcgEYZBQwiikDIOECWAEmmSXw5GupfNZL9b7pCjydb8sK5GcLEMDDv7ePYWwUQgbhbBRCBuFsFEIG4WwUQibwJAVY5eQUkI3rj6LExPyuuaAE+4fX1dQOMR34fIEzg8s8+DzeIVDFnzzLgyzwd43HH1aQ+GQHpMZpt6XFQUe9roUwkYhbBTCppkQbNcK5cyWf0q2a4r/T/7sR2hmR3TRw0YhbBTCRiFsFMJGIWwUwkYhbBoJAX7xb8uu6HXd0wAAAABJRU5ErkJggg==) no-repeat 50% 100%}
.test3 {background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsIAAA7CARUoSoAAAADISURBVGhD7dmxDcIwEIXhZ2aBJcgEYZBQwiikDIOECWAEmmSXw5GupfNZL9b7pCjydb8sK5GcLEMDDv7ePYWwUQgbhbBRCBuFsFEIG4WwUQibwJAVY5eQUkI3rj6LExPyuuaAE+4fX1dQOMR34fIEzg8s8+DzeIVDFnzzLgyzwd43HH1aQ+GQHpMZpt6XFQUe9roUwkYhbBTCppkQbNcK5cyWf0q2a4r/T/7sR2hmR3TRw0YhbBTCRiFsFMJGIWwUwkYhbBoJAX7xb8uu6HXd0wAAAABJRU5ErkJggg==) no-repeat 50% 100%}
";

        $file = new \SplFileInfo(__DIR__ . '/css/test1.css');
        $imgToDataUrl = new Teddy\ImgToDataUrl(__DIR__);
        $imgToDataUrl->setCssFromFile($file);
        $actual = $imgToDataUrl->convert();
        Assert::same($expected, $actual);

        $imgToDataUrl = new Teddy\ImgToDataUrl(__DIR__);
        $imgToDataUrl->setCss(file_get_contents($file));
        $actual = $imgToDataUrl->convert();
        Assert::same($expected, $actual);
    }

    /**
     * Image in relative path (when we know where to look we'll find it, otherwise... nope)
     */
    public function testTwo()
    {
        $file = new \SplFileInfo(__DIR__ . '/css/test2.css');

        $expected = ".test1 {background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsIAAA7CARUoSoAAAAD1SURBVGhD7dnBDYIwGMXxr85iPDlB3cBByjp4dRBYxJOwS20LGC+SmPSRJ3m/pLEJXv7WL0h0MbEdOMyvf08hbBTCRiFsFMJGIWwUwkYhbBTCRiFr+saZc5/rYrdxvoiSn9mr6UJ+/v+6Qje/DwBwIt7aIeYP6L26MF25Xxvrp219uQavi6klnYqPKRJCw/6T8WmPsjnb6Vg29c0nAzW0vgy7R32vEnzI0EZf5iOkScEBh+CHfAEMWSKw948FKGTbiAwQsn1EVjfkPdjbRmRVQ9JPkRKxunwbEXO/mzu7/rFioxA2CmGjEDYKYaMQNgphoxAuZi9I1H7bRee8bQAAAABJRU5ErkJggg==) no-repeat 50% 100%}
.test2 {background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsIAAA7CARUoSoAAAAD1SURBVGhD7dnBDYIwGMXxr85iPDlB3cBByjp4dRBYxJOwS20LGC+SmPSRJ3m/pLEJXv7WL0h0MbEdOMyvf08hbBTCRiFsFMJGIWwUwkYhbBTCRiFr+saZc5/rYrdxvoiSn9mr6UJ+/v+6Qje/DwBwIt7aIeYP6L26MF25Xxvrp219uQavi6klnYqPKRJCw/6T8WmPsjnb6Vg29c0nAzW0vgy7R32vEnzI0EZf5iOkScEBh+CHfAEMWSKw948FKGTbiAwQsn1EVjfkPdjbRmRVQ9JPkRKxunwbEXO/mzu7/rFioxA2CmGjEDYKYaMQNgphoxAuZi9I1H7bRee8bQAAAABJRU5ErkJggg==) no-repeat 50% 100%}
";
        $imgToDataUrl = new Teddy\ImgToDataUrl(__DIR__);
        $imgToDataUrl->setCssFromFile($file);
        $actual = $imgToDataUrl->convert();
        Assert::same($expected, $actual);

        $file = new \SplFileInfo(__DIR__ . '/css/test2.css');
        $imgToDataUrl = new Teddy\ImgToDataUrl(__DIR__);
        $imgToDataUrl->setCss(file_get_contents($file));
        $actual = $imgToDataUrl->convert();
        $expected = ".test1 {background: url(./images/02.png) no-repeat 50% 100%}
.test2 {background: url(images/02.png) no-repeat 50% 100%}
";

        Assert::same($expected, $actual);
    }

}

$tests = new Tests();
$tests->run();
