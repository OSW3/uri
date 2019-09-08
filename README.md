# URI

Parse and manipulate URI, URL and URN.

## Install

```sh
composer require osw3/uri
```

## Usage

```php
new Uri(string $uri);
```

- `$uri` (string) The URI you want to parse.


## Parse URI

```php
// use namsespace
use OSW3\Uri;

// ...

// Instanciate Uri()
$uri = new Uri("http://foo.bar/opensource/database?param=value#resource");

// ..

// Get URI parameters
print_r( $uri->parameters() );
```



## Output methods

- `print([$type])`  
Return the string of URI
```php
$uri->print();
$uri->print('uri'); // default
$uri->print('url');
$uri->print('urn');
```

- `parameters()`  
Return an array of all URI paramaters
```php
$uri->parameters();
```

<pre>Array
(
    [original] => http://foo.bar/opensource/database?param=value#resource
    [hash] => 8055f2691c03d7ef54cbec8af205de5a
    [secured] => 
    [uri] => Array
        (
            [text] => http://foo.bar/opensource/database?param=value#resource=
            [md5] => 6c89b086480fbea32bacfd40251d7cce
            [sha1] => 901bfc28a6713be0de7c0948b031c6456bc05279
        )

    [url] => Array
        (
            [text] => http://foo.bar/opensource/database
            [md5] => 05386599aadf31b39042b64d77637a25
            [sha1] => 3f681fc482c68feb13f41654f354ec23a75844a4
        )

    [urn] => Array
        (
            [text] => foo.bar/opensource/database?param=value#resource=
            [md5] => e0c2f7057a96f7115844a3bc5eb62891
            [sha1] => 9e7d3b3bbc40810f62cbdb1e5ca9a7e8295a0215
        )

    [scheme] => http
    [protocol] => http://
    [user] => 
    [pass] => 
    [host] => foo.bar
    [registrable_domain] => foo.bar
    [subdomain] => 
    [hostname] => foo
    [tld] => bar
    [isValidDomain] => 1
    [isIp] => 
    [port] => 
    [path] => /opensource/database
    [segments] => Array
        (
            [0] => opensource
            [1] => database
        )

    [file] => 
    [dirname] => 
    [filename] => 
    [extension] => 
    [query] => param=value
    [parameters] => Array
        (
            [param] => value
        )

    [fragment] => resource
    [fragments] => Array
        (
            [resource] => 
        )

)</pre>


- `getUri()` 

Return the original URI (your input)

```php
$uri->getUri();
```

- `getScheme()` (string)  

Return the URI Scheme. (e.g.: http, https)

```php
$uri->getScheme();
```

- `getProtocol()` (string)  

Return the URI Protocol. (e.g.: http://, https://)

```php
$uri->getProtocol();
```

- `getIsSecured()` (bool)

Return TRUE if the transport is secured (e.g.: https).  
Return FALSE if the transport is not secured (e.g.: http).  

```php
$uri->getIsSecured();
```

- `getUser()` (null|string)

Return the username of the URI

```php
$uri->getUser();
```

- `getPass()` (null|string)

Return the password of the URI

```php
$uri->getPass();
```

- `getHost()` 

```php
$uri->getHost();
```

- `getPort()` 

```php
$uri->getPort();
```

- `getPath()` 

```php
$uri->getPath();
```

- `getSegment()` 

```php
$uri->getSegment();
```

- `getSegments()` 

```php
$uri->getSegments();
```

- `getQuery()` 

```php
$uri->getQuery();
```

- `getParameter()` 

```php
$uri->getParameter();
```

- `getParameters()` 

```php
$uri->getParameters();
```

- `getFragment()` 

```php
$uri->getFragment();
```

- `getFragmentsParameter()` 

```php
$uri->getFragmentsParameter();
```

- `getFragments()` 

```php
$uri->getFragments();
```

- `getHostname()` 

```php
$uri->getHostname();
```

- `getSubdomain()` 

```php
$uri->getSubdomain();
```

- `getTld()` 

```php
$uri->getTld();
```

- `getRegistrableDomain()` 

```php
$uri->getRegistrableDomain();
```

- `getIsValidDomain()` 

```php
$uri->getIsValidDomain();
```

- `getIsIp()` 

```php
$uri->getIsIp();
```


## Manipulation

- `changeScheme(string $scheme)`  
Change the scheme (e.g.: http to view-source).  
All valid schemes [here](https://fr.wikipedia.org/wiki/Sch%C3%A9ma_d%27URI#Sch%C3%A9mas_enregistr%C3%A9s_aupr%C3%A8s_de_l'IANA).
```php
$uri->changeScheme('view-source');
```

- `secure(bool $secure)`  
If `$secure` is TRUE, Set ON secure transnport (e.g.: http to https)  
If `$secure` is FALSE, Set OFF secure transnport (e.g.: https to http)
```php
$uri->secure(true);
```

- `toggleSecure()`  
Toggle secure transnport
```php
$uri->toggleSecure();
```


- `addUser()`  
Add User name if is not defined
```php
$uri->addUser('Bob');
```

- `changeUser()`  
Change or Add User name
```php
$uri->changeUser('John');
```


- `addPass()`  
Add Password if is not defined
```php
$uri->addPass('123456!');
```

- `changePass()`  
Change or Add Password
```php
$uri->changePass('l2EAS6!');
```


- `changeHost()`  
Change Full Host
```php
$uri->changeHost('www.google.com');
```

- `addSubdomain()`  
Add SubDomain if is not defined
```php
$uri->addSubdomain('app');
```

- `changeSubdomain()`  
Change or Add SubDomain
```php
$uri->changeSubdomain('store');
```

- `removeSubdomain()`  
Remove SubDomain
```php
$uri->removeSubdomain();
```

- `changeHostname()`  
Change the Hostname
```php
$uri->changeHostname('goo');
```

- `changeTld()`  
Change the TLD
```php
$uri->changeTld('gl');
```

- `addPort()`  
Add Port if is not defined
```php
$uri->addPort(8080);
```

- `changePort()`  
Change or Add Port
```php
$uri->changePort(8082);
```


- `addSegment()`  
Add a segment
```php
$uri->addSegment('folder_A');
```

- `replaceSegment()`  
Replace a segment
```php 
$uri->replaceSegment(1, 'folder_C'); // Replace the N segment
$uri->replaceSegment('folder_B', 'folder_C'); // Replace the segment 'folder_B'
```

- `removeSegment()`  
Remove a segment
```php
$uri->removeSegment('folder_A');
```

- `removeSegments()`  
Remove all segments
```php
$uri->removeSegments();
```

- `resetSegments()`  
Reset segments
```php
$uri->resetSegments();
```


- `addParameter()`  
Add a parameter
```php
$uri->addParameter('p1', 'lorem ipsum');
```

- `replaceParameter()`  
Replace a parameter
```php
$uri->replaceParameter('p2', 42);
```

- `removeParameter()`  
Remove a parameter
```php
$uri->removeParameter('p2');
```

- `removeParameters()`  
Remove all parameters
```php
$uri->removeParameters();
```

- `resetParameters()`  
Reset parameters
```php
$uri->resetParameters();
```


- `addFragment()`  
Add a fragment
```php
$uri->addFragment('p1', 'lorem ipsum');
```

- `replaceFragment()`  
Replace a fragment
```php
$uri->replaceFragment('p2', 42);
```

- `removeFragment()`  
Remove a fragment
```php
$uri->removeFragment('p2');
```

- `removeFragments()`  
Remove all fragments
```php
$uri->removeFragments();
```

- `resetFragments()`  
Reset fragments
```php
$uri->resetFragments();
```
