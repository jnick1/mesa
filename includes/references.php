<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$homedir = "../";
require_once $homedir."../../secure/mysqli_connect.php";
$ti = 1;

//these should get their values from a failed attempt at a POST request
$errors = [];
$warnings = [];
$notifications = [];

$scrubbed = array_map("spam_scrubber", $_POST);

include $homedir."includes/protocols/signout.php";
include $homedir."includes/protocols/deleteaccount.php";

include $homedir."includes/protocols/changeemail.php";
include $homedir."includes/protocols/changepassword.php";

include $homedir."includes/protocols/signin.php";

include $homedir."includes/protocols/forgotpassword.php";
include $homedir."includes/protocols/resetpassword.php";

$references = [
    'Hellmann, Doug. "PyMOTW." Datetime – Date/time Value Manipulation. November 29, 2015. Accessed April 15, 2016. <a href="https://pymotw.com/2/datetime/. " class="ui-revisitablelink">https://pymotw.com/2/datetime/. </a>',
    'Python Software Foundation. "8.1. Datetime — Basic Date and Time Types¶." 8.1. Datetime. January 21, 2016. Accessed April 15, 2016. <a href="https://docs.python.org/3.4/library/datetime.html. " class="ui-revisitablelink">https://docs.python.org/3.4/library/datetime.html. </a>',
    '"How to Send & Receive Serialized Simple Objects across PHP & Python? Of Course! JSON." Joe Kuan Defunct Code. 2011. Accessed March 15, 2016. <a href="https://joekuan.wordpress.com/2011/04/14/how-to-send-receive-serialized-simple-objects-across-php-python-of-course-json/.  " class="ui-revisitablelink">https://joekuan.wordpress.com/2011/04/14/how-to-send-receive-serialized-simple-objects-across-php-python-of-course-json/.  </a>',
    '"The Sarth Repository." The Sarth Repository. Accessed April 19, 2016. <a href="http://blog.yimingliu.com/2007/01/01/my-own-private-thermopylae-sarth/." class="ui-revisitablelink">http://blog.yimingliu.com/2007/01/01/my-own-private-thermopylae-sarth/.</a>',
    'Python Software Foundation. "Phpserialize 1.3 : Python Package Index." Phpserialize 1.3 : Python Package Index. Accessed April 19, 2016. <a href="https://pypi.python.org/pypi/phpserialize." class="ui-revisitablelink">https://pypi.python.org/pypi/phpserialize.</a>',
    '"How to Use Python\'s Xrange and Range | Python Central." Python Central. 2013. Accessed April 19, 2016. <a href="http://pythoncentral.io/how-to-use-pythons-xrange-and-range/." class="ui-revisitablelink">http://pythoncentral.io/how-to-use-pythons-xrange-and-range/.</a>',
    '"2. Built-in Functions¶." 2. Built-in Functions — Python 2.7.11 Documentation. Accessed April 19, 2016. <a href="https://docs.python.org/2/library/functions.html#xrange. " class="ui-revisitablelink">https://docs.python.org/2/library/functions.html#xrange. </a>',
    'Microsoft. "Accessing the Bing Maps REST Services Using PHP." Microsoft Developer Network. Accessed March 22, 2016. <a href="https://msdn.microsoft.com/en-us/library/ff817004.aspx?f=255&MSPPError=-2147217396." class="ui-revisitablelink">https://msdn.microsoft.com/en-us/library/ff817004.aspx?f=255&MSPPError=-2147217396.</a>',
    '"Should MySQL Have Its Timezone Set to UTC?" Stack Overflow. Accessed March 31, 2016. <a href="http://stackoverflow.com/questions/19023978/should-mysql-have-its-timezone-set-to-utc." class="ui-revisitablelink">http://stackoverflow.com/questions/19023978/should-mysql-have-its-timezone-set-to-utc.</a>',
    '"PHP - Split String in Key/Value Pairs." Stack Overflow. Accessed March 31, 2016. <a href="http://stackoverflow.com/questions/4923951/php-split-string-in-key-value-pairs." class="ui-revisitablelink">http://stackoverflow.com/questions/4923951/php-split-string-in-key-value-pairs.</a>',
    '"Parsing Values from a JSON File in Python." Stack Overflow. Accessed April 2, 2016. <a href="http://stackoverflow.com/questions/2835559/parsing-values-from-a-json-file-in-python." class="ui-revisitablelink">http://stackoverflow.com/questions/2835559/parsing-values-from-a-json-file-in-python.</a>',
    '"Google Calendar API." Google Developers. Accessed February 11, 2016. <a href="https://developers.google.com/google-apps/calendar/." class="ui-revisitablelink">https://developers.google.com/google-apps/calendar/.</a>',
    'Achour, Mehdi, Friedhelm Betz, Antony Dovgal, Nuno Lopes, Hannes Magnusson, Georg Richter, Damien Seguy, and Jakub Vrana. "PHP Manual." Php. April 18, 2016. Accessed January 2016. <a href="https://secure.php.net/manual/en/index.php. " class="ui-revisitablelink">https://secure.php.net/manual/en/index.php. </a>',
    'Desruisseaux, B., Ed., and Oracle. "Internet Calendaring and Scheduling Core Object Specification (iCalendar)." The Internet Engineering Task Force. September 2009. Accessed March 2016. <a href="http://tools.ietf.org/html/rfc5545. " class="ui-revisitablelink">http://tools.ietf.org/html/rfc5545. </a>',
    'Dunens, Ed. Uluru. August 16, 2016. Uluru, Flickr, Uluru / Ayers Rock. Accessed March 2016. <a href="https://www.flickr.com/photos/blachswan/15176720492/in/photolist-6vrGpo-p87aqh-p87EfG-5akN6L-oQDSLG-C7rBri-Ccqiym-BBVF11-p89uZB-oQEe6Y-BnsYAS-c5JFEY-Bgd9b9-oQD958-5agHGP-7gEK8n-c5YbYJ-c5Y8qm-5pEy2P-ogot4h-5w74Ag-ogo1sy-ognZWo-5pEyPr-ogotrG. " class="ui-revisitablelink">https://www.flickr.com/photos/blachswan/15176720492/in/photolist-6vrGpo-p87aqh-p87EfG-5akN6L-oQDSLG-C7rBri-Ccqiym-BBVF11-p89uZB-oQEe6Y-BnsYAS-c5JFEY-Bgd9b9-oQD958-5agHGP-7gEK8n-c5YbYJ-c5Y8qm-5pEy2P-ogot4h-5w74Ag-ogo1sy-ognZWo-5pEyPr-ogotrG. </a>',
    'Gehrig, Stefan, and Kieran Andrews. "How Can I Use PHP to Dynamically Publish an Ical File to Be Read by Google Calendar?" Stackoverflow. September 23, 2009. Accessed March 2016. <a href="http://stackoverflow.com/a/1464355. " class="ui-revisitablelink">http://stackoverflow.com/a/1464355. </a>',
    'Google. "Google Apps SMTP Settings to Send Mail from a Printer, Scanner, or App." Google Apps Administrator Help. September 14, 2015. Accessed March 2016. <a href="https://support.google.com/a/answer/176600?hl=en. " class="ui-revisitablelink">https://support.google.com/a/answer/176600?hl=en. </a>',
    'Google. "Google Calendar." Google. April 17, 2016. Accessed January 2016. calendar.google.com.',
    'Jagielski, Jim, Marcus Bointon, Andy Prevost, and Brent R. Matzelle. "Phpmailer." Packagist. November 1, 2015. Accessed March 2016. <a href="https://packagist.org/packages/phpmailer/phpmailer." class="ui-revisitablelink">https://packagist.org/packages/phpmailer/phpmailer.</a>',
    'Jay, Robyn. Uluru. July 29, 2014. To the Kimberleys and Back, Flickr, Uluru / Ayers Rock. Accessed March 2016. <a href="https://www.flickr.com/photos/learnscope/14589120198." class="ui-revisitablelink">https://www.flickr.com/photos/learnscope/14589120198.</a>',
    'Kettler, Rafe. "A Guide to Python\'s Magic Methods." Rafekettler.com. 2012. Accessed February 2016. <a href="http://www.rafekettler.com/magicmethods.html. " class="ui-revisitablelink">http://www.rafekettler.com/magicmethods.html. </a>',
    'Klingenberg, Tom. "PHPMailer Tutorial." Worx International Inc. 2009. Accessed March 2016. <a href="http://phpmailer.worxware.com/?pg=tutorial." class="ui-revisitablelink">http://phpmailer.worxware.com/?pg=tutorial.</a>',
    'Collusion. Less Is More. December 1, 2013. Flickr, Uluru / Ayers Rock. Accessed February 2016. <a href="https://www.flickr.com/photos/resollesta/14535123706/." class="ui-revisitablelink">https://www.flickr.com/photos/resollesta/14535123706/.</a>',
    'Loskit, Uku. "Passing Value from PHP Script to Python Script." Stackoverflow. February 12, 2011. Accessed April 2016. <a href="http://stackoverflow.com/a/4977634." class="ui-revisitablelink">http://stackoverflow.com/a/4977634.</a>',
    'Penn, Joanna. Uluru By Day. November 19, 2009. AYE-Ayers Rock, Flickr, Uluru / Ayers Rock. Accessed February 2016. <a href="https://www.flickr.com/photos/38314728@N08/4116217604/." class="ui-revisitablelink">https://www.flickr.com/photos/38314728@N08/4116217604/.</a>',
    'Python Software Foundation. "Python Release Python 3.5.1." Python.org. December 07, 2015. Accessed April 2016. <a href="https://www.python.org/downloads/release/python-351/. " class="ui-revisitablelink">https://www.python.org/downloads/release/python-351/. </a>',
    'Thomas, Steve. "How to Build an ICal Calendar with PHP and MySQL." Web Development Learnings. June 8, 2012. Accessed March 2016. <a href="http://stevethomas.com.au/php/how-to-build-an-ical-calendar-with-php-and-mysql.html. " class="ui-revisitablelink">http://stevethomas.com.au/php/how-to-build-an-ical-calendar-with-php-and-mysql.html. </a>',
    'Eulinky. Uluru. December 10, 2008. Northern Territory, Flickr, Uluru / Ayers Rock. Accessed February 2016. <a href="https://www.flickr.com/photos/eulinky/3115025467/. " class="ui-revisitablelink">https://www.flickr.com/photos/eulinky/3115025467/. </a>',
    'Xeusy. Uluru. April 23, 2007. Australia 2007, Flickr, Uluru / Ayers Rock. Accessed February 2016. <a href="https://www.flickr.com/photos/resollesta/14535123706/. " class="ui-revisitablelink">https://www.flickr.com/photos/resollesta/14535123706/. </a>',
    'Fina1967. Uluru Red Rock Aboriginal Australia. March 24, 2015. Pixabay, Uluru / Ayers Rock. Accessed February 2016. <a href="https://pixabay.com/en/uluru-red-rock-aboriginal-australia-681140/." class="ui-revisitablelink">https://pixabay.com/en/uluru-red-rock-aboriginal-australia-681140/.</a>',
    'Young, Robert. Uluru. March 5, 2008. Uluru-Kata Tjuta National Park, Northern Territory, Australia, March 2008, Flickr, Uluru / Ayers Rock. Accessed February 2016. <a href="https://www.flickr.com/photos/robertpaulyoung/2716469542/in/photostream/." class="ui-revisitablelink">https://www.flickr.com/photos/robertpaulyoung/2716469542/in/photostream/.</a>',
    'Brian. "MySQL Column Name Standards / Conventions [closed]." Stackoverflow. March 16, 2011. Accessed March 2016. <a href="http://stackoverflow.com/a/5325698." class="ui-revisitablelink">http://stackoverflow.com/a/5325698.</a>',
    'Anderscc. "Send Email Using Gmail SMTP Server through PHP Mailer." Stackoverflow. April 16, 2013. Accessed March 2016. <a href="http://stackoverflow.com/a/16048485." class="ui-revisitablelink">http://stackoverflow.com/a/16048485.</a>',
    'Brian. "Php Exec() Is Not Executing the Command." Stackoverflow. July 29, 2013. Accessed April 2016. <a href="http://stackoverflow.com/a/17929782." class="ui-revisitablelink">http://stackoverflow.com/a/17929782.</a>'
]

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="<?php echo $homedir;?>favicon.png" sizes="128x128">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/re.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.structure.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.theme.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant: References</title>
    </head>
    <body>
        <div id="wpg">
            <div id="re-header" class="ui-container-section <?php echo "uluru".rand(1,8); ?>">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
            </div>
            <div id="re-content">
                <table>
                    <tbody>
                        <?php 
                        foreach($references as $reference) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $reference; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            include $homedir."includes/pageassembly/footer.php";
            ?>
        </div>
        <?php
        include $homedir."includes/pageassembly/signin.php";
        include $homedir."includes/pageassembly/account.php";
        ?>
    </body>
</html>
