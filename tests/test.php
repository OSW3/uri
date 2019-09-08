<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OSW3\Uri;

$uri = new Uri("http://foo.bar/opensource/database?param=value#resource");

// Data of original URI
echo "<pre>";
print_r($uri->parameters());
echo "<pre>";

// Manipulate
$uri->addParameter("date", date("Y-m-d"));
$uri->addParameter("time", date("H:i:s"));

$uri->addSubdomain("www");
$uri->toggleSecure();
$uri->removeSegments();
$uri->removeFragments();

echo "<pre>". $uri->print() ."<pre>";

// Output Data of URI
echo "<pre>";
print_r($uri->parameters());
echo "<pre>";