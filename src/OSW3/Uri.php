<?php
/**
 * USAGE
 * 
 * Init
 * ---
 * 
 * >> Create an instance of Uri
 *    new Uri(string $uri, string $hash_mode = "md5");
 * 
 * e.g.: $uri = new Uri("http://foo.bar.com/", Uri::SHA1);
 * e.g.: $uri = new Uri("http://foo.bar.com/");
 * 
 * uri = new Uri([
 *      "host" => "osw3.net",
 *      "tld" => "fr",
 *      "scheme" => "http"
 * ]);
 * 
 * 
 * 
 * 
 * Output
 * ---
 * 
 * >> Convert $uri->parameters() to string
 *    $uri->toString();
 * 
 * >> Return the string of $uri->toString();
 *    $uri->print();
 *    $uri->print('uri'); // default
 *    $uri->print('url');
 *    $uri->print('urn');
 * 
 * >> Return an array of all URI paramaters
 *    $uri->parameters();
 * 
 * >> Get each parameter
 *    $uri->getUri();
 *    $uri->getHash();
 *    $uri->getScheme();
 *    $uri->getProtocol();
 *    $uri->getIsSecured();
 *    $uri->getUser();
 *    $uri->getPass();
 *    $uri->getHost();
 *    $uri->getPort();
 *    $uri->getPath();
 *    $uri->getSegment();
 *    $uri->getSegments();
 *    $uri->getQuery();
 *    $uri->getParameter();
 *    $uri->getParameters();
 *    $uri->getFragment();
 *    $uri->getFragmentsParameter();
 *    $uri->getFragments();
 *    $uri->getHostname();
 *    $uri->getSubdomain();
 *    $uri->getTld();
 *    $uri->getRegistrableDomain();
 *    $uri->getIsValidDomain();
 *    $uri->getIsIp();
 * 
 * 
 * 
 * 
 * Manipulation
 * ---
 * 
 * >> Change the scheme (e.g.: http to view-source)
 * >> All valid scheme @ SCHEMES constant.
 *    $uri->changeScheme('view-source');
 * 
 * 
 * 
 * >> Set ON secure transnport (e.g.: http to https)
 *    $uri->secure(true);
 * 
 * >> Set OFF secure transnport (e.g.: https to http)
 *    $uri->secure(false);
 * 
 * >> Toggle secure transnport
 *    $uri->toggleSecure();
 * 
 * 
 * 
 * >> Add User name if is not defined
 *    $uri->addUser('Bob');
 * 
 * >> Change or Add User name
 *    $uri->changeUser('John');
 * 
 * 
 * 
 * >> Add Password if is not defined
 *    $uri->addPass('123456!');
 * 
 * >> Change or Add Password
 *    $uri->changePass('l2EAS6!');
 * 
 * 
 * 
 * >> Change Full Host
 *    $uri->changeHost('www.google.com');
 * 
 * >> Add SubDomain if is not defined
 *    $uri->addSubdomain('app');
 * 
 * >> Change or Add SubDomain
 *    $uri->changeSubdomain('store');
 * 
 * >> Remove SubDomain
 *    $uri->removeSubdomain();
 * 
 * >> Change the Hostname
 *    $uri->changeHostname('goo');
 * 
 * >> Change the TLD
 *    $uri->changeTld('gl');
 * 
 * >> Add Port if is not defined
 *    $uri->addPort(8080);
 * 
 * >> Change or Add Port
 *    $uri->changePort(8082);
 * 
 * 
 * 
 * >> Add a segment
 *    $uri->addSegment('folder_A');
 * 
 * >> Replace a segment
 *    > Replace the N segment
 *    $uri->replaceSegment(1, 'folder_C');
 *    > Replace the segment 'folder_B'
 *    $uri->replaceSegment('folder_B', 'folder_C');
 * 
 * >> Remove a segment
 *    $uri->removeSegment('folder_A');
 * 
 * >> Remove all segments
 *    $uri->removeSegments();
 * 
 * >> Reset segments
 *    $uri->resetSegments();
 * 
 * 
 * 
 * >> Add a parameter
 *    $uri->addParameter('p1', 'lorem ipsum');
 * 
 * >> Replace a parameter
 *    $uri->replaceParameter('p2', 42);
 * 
 * >> Remove a parameter
 *    $uri->removeParameter('p2');
 * 
 * >> Remove all parameters
 *    $uri->removeParameters();
 * 
 * >> Reset parameters
 *    $uri->resetParameters();
 * 
 * 
 * 
 * >> Add a fragment
 *    $uri->addFragment('p1', 'lorem ipsum');
 * 
 * >> Replace a fragment
 *    $uri->replaceFragment('p2', 42);
 * 
 * >> Remove a fragment
 *    $uri->removeFragment('p2');
 * 
 * >> Remove all fragments
 *    $uri->removeFragments();
 * 
 * >> Reset fragments
 *    $uri->resetFragments();
 * 
 * 
 * 
 */
namespace OSW3;

use LayerShifter\TLDDatabase\Store as TLDDatabase;
use LayerShifter\TLDExtract\Extract;

class Uri
{
    const SLASHE = "/";

    const SCHEMES = ["aaa","aaas","about","acap","acct","acd","acr","adiumxtra","adt","afp","afs","aim","amss","android","appdata","apt","ark","attachment","aw","barion","beshare","bitcoin","bitcoincash","blob","bolo","browserext","calculator","callto","cap","cast","casts","chrome","chrome-extension","cid","coap","coap+tcp","coap+ws","coaps","coaps+tcp","coaps+ws","com-eventbrite-attendee","content","conti","crid","cvs","dab","data","dav","diaspora","dict","did","dis","dlna-playcontainer","dlna-playsingle","dns","dntp","dpp","drm","drop","dtn","dvb","ed2k","elsi","example","facetime","fax","feed","feedready","file","filesystem","finger","first-run-pen-experience","fish","fm","ftp","fuchsia-pkg","geo","gg","git","gizmoproject","go","gopher","graph","gtalk","h323","ham","hcap","hcp","http","https","hxxp","hxxps","hydrazone","iax","icap","icon","im","imap","info","iotdisco","ipn","ipp","ipps","irc","irc6","ircs","iris","iris.beep","iris.lwz","iris.xpc","iris.xpcs","isostore","itms","jabber","jar","jms","keyparc","lastfm","ldap","ldaps","leaptofrogans","lorawan","lvlt","magnet","mailserver","mailto","maps","market","message","microsoft.windows.camera","microsoft.windows.camera.multipicker","microsoft.windows.camera.picker","mid","mms","modem","mongodb","moz","ms-access","ms-browser-extension","ms-calculator","ms-drive-to","ms-enrollment","ms-excel","ms-eyecontrolspeech","ms-gamebarservices","ms-gamingoverlay","ms-getoffice","ms-help","ms-infopath","ms-inputapp","ms-lockscreencomponent-config","ms-media-stream-id","ms-mixedrealitycapture","ms-mobileplans","ms-officeapp","ms-people","ms-project","ms-powerpoint","ms-publisher","ms-restoretabcompanion","ms-screenclip","ms-screensketch","ms-search","ms-search-repair","ms-secondary-screen-controller","ms-secondary-screen-setup","ms-settings","ms-settings-airplanemode","ms-settings-bluetooth","ms-settings-camera","ms-settings-cellular","ms-settings-cloudstorage","ms-settings-connectabledevices","ms-settings-displays-topology","ms-settings-emailandaccounts","ms-settings-language","ms-settings-location","ms-settings-lock","ms-settings-nfctransactions","ms-settings-notifications","ms-settings-power","ms-settings-privacy","ms-settings-proximity","ms-settings-screenrotation","ms-settings-wifi","ms-settings-workplace","ms-spd","ms-sttoverlay","ms-transit-to","ms-useractivityset","ms-virtualtouchpad","ms-visio","ms-walk-to","ms-whiteboard","ms-whiteboard-cmd","ms-word","msnim","msrp","msrps","mss","mtqp","mumble","mupdate","mvn","news","nfs","ni","nih","nntp","notes","ocf","oid","onenote","onenote-cmd","opaquelocktoken","openpgp4fpr","pack","palm","paparazzi","payto","pkcs11","platform","pop","pres","prospero","proxy","pwid","psyc","pttp","qb","query","redis","rediss","reload","res","resource","rmi","rsync","rtmfp","rtmp","rtsp","rtsps","rtspu","secondlife","service","session","sftp","sgn","shttp","sieve","simpleledger","sip","sips","skype","smb","sms","smtp","snews","snmp","soap.beep","soap.beeps","soldat","spiffe","spotify","ssh","steam","stun","stuns","submit","svn","tag","teamspeak","tel","teliaeid","telnet","tftp","things","thismessage","tip","tn3270","tool","turn","turns","tv","udp","unreal","urn","ut2004","v-event","vemmi","ventrilo","videotex","vnc","view-source","wais","webcal","wpid","ws","wss","wtai","wyciwyg","xcon","xcon-userid","xfire","xmlrpc.beep","xmlrpc.beeps","xmpp","xri","ymsgr","z39.50","z39.50r","z39.50s"];
    
    const SCHEMES_WITH_SECURE_TRANSPORT = [
        ["aaa"          => "aaas"],
        ["cast"         => "casts"],
        ["coap"         => "coaps"],
        ["coap+tcp"     => "coaps+tcp"],
        ["coap+ws"      => "coaps+ws"],
        ["ftp"          => "sftp"],
        ["http"         => "https"],
        ["hxxp"         => "hxxps"],
        ["ipp"          => "ipps"],
        ["irc"          => "ircs"],
        ["ldap"         => "ldaps"],
        ["msrp"         => "msrps"],
        ["redis"        => "rediss"],
        ["rtsp"         => "rtsps"],
        ["sip"          => "sips"],
        ["stun"         => "stuns"],
        ["turn"         => "turns"],
        ["ws"           => "wss"],
        ["xmlrpc.beep"  => "xmlrpc.beeps"]
    ];

    const MD5 = "md5";
    const SHA1 = "sha1";

    /** @var string */
    private $uri = '';

    /** @var string */
    private $identifier = '';

    /** @var string */
    private $locator = '';

    /** @var string */
    private $name = '';

    /** @var string */
    private $hash = '';

    /** @var string */
    private $finalUri = '';

    /** @var string */
    private $scheme = '';

    /** @var bool */
    private $isSecured = false;

    /** @var string */
    private $protocol = '';

    /** @var string */
    private $user = '';

    /** @var string|null */
    private $pass = null;

    /** @var string */
    private $host = '';

    /** @var string */
    private $domain = '';

    /** @var string */
    private $registrableDomain = '';

    /** @var string */
    private $subdomain = '';

    /** @var string */
    private $tld = '';

    /** @var bool */
    private $isValidDomain = false;

    /** @var bool */
    private $isIp = false;

    /** @var int|string */
    private $port = null;

    /** @var string */
    private $path = '';

    /** @var string */
    private $dirname = '';

    /** @var string */
    private $filename = '';

    /** @var string */
    private $extension = '';

    /** @var array */
    private $file = '';

    /** @var array */
    private $segments = [];
    private $_segments = false;

    /** @var string */
    private $query = '';

    /** @var array */
    private $parameters = [];
    private $_parameters = false;

    /** @var string */
    private $fragment = '';

    /** @var array */
    private $fragments = [];
    private $_fragments = false;


    public function __construct($uri, $hash_mode = self::MD5)
    {
        if (is_array($uri))
        {
            isset($uri['scheme']) ? $this->setScheme($uri['scheme']) : null;
            isset($uri['protocol']) ? $this->setProtocol($uri['protocol']) : null;
            isset($uri['user']) ? $this->setUser($uri['user']) : null;
            isset($uri['pass']) ? $this->setPass($uri['pass']) : null;
            isset($uri['host']) ? $this->setHost($uri['host']) : null;
            isset($uri['hostname']) ? $this->setHostname($uri['hostname']) : null;
            isset($uri['subdomain']) ? $this->setSubdomain($uri['subdomain']) : null;
            isset($uri['tld']) ? $this->setTld($uri['tld']) : null;
            isset($uri['port']) ? $this->setPort($uri['port']) : null;
            isset($uri['segments']) ? $this->setSegments($uri['segments']) : null;
            // isset($uri['path']) ? $this->setPath($uri['path']) : null;
            isset($uri['query']) ? $this->setQuery($uri['query']) : null;
            isset($uri['parameters']) ? $this->setParameters($uri['parameters']) : null;
            isset($uri['fragments']) ? $this->setFragments($uri['fragments']) : null;
        }

        else
        {
            $this
                ->setUri($uri)
                ->setHash($hash_mode)
            ;
    
            $this
                ->parseScheme()
                ->parseUser()
                ->parsePass()
                ->parseHost()
                ->parsePort()
                ->parsePath()
                ->parseSegments()
                ->parseQuery()
                ->parseParameters()
                ->parseFragment()
                ->parseFragments()
            ;

            $this->toString();

        }
    }

    
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    // Output

    public function parameters()
    {
        $this->isSecured();

        return [
            'original' => $this->getUri(),
            'hash' => $this->getHash(),
            'secured' => $this->getIsSecured(),

            'uri' => $this->getIdentifier(),
            'url' => $this->getLocator(),
            'urn' => $this->getName(),

            'scheme' => $this->getScheme(),
            'protocol' => $this->getProtocol(),
            'user' => $this->getUser(),
            'pass' => $this->getPass(),

            'host' => $this->getHost(),
            'registrable_domain' => $this->getRegistrableDomain(),
            'subdomain' => $this->getSubdomain(),
            'hostname' => $this->getHostname(),
            'tld' => $this->getTld(),
            'isValidDomain' => $this->getIsValidDomain(),
            'isIp' => $this->getIsIp(),

            'port' => $this->getPort(),
            'path' => $this->getPath().$this->getFile(),
            'segments' => $this->getSegments(),
            'file' => $this->getFile(),
            'dirname' => $this->getDirname(),
            'filename' => $this->getFilename(),
            'extension' => $this->getExtension(),
            // 'segment_1' => $this->getSegment(1),
            // 'segment_2' => $this->getSegment(2),
            // 'segment_4' => $this->getSegment(4),

            'query' => $this->getQuery(),
            'parameters' => $this->getParameters(),
            // 'parameters_p2' => $this->getParameter('p2'),

            'fragment' => $this->getFragment(),
            'fragments' => $this->getFragments(),
            // 'fragmentsParameter_p2' => $this->getFragmentsParameter('p2'),
        ];
    }

    public function toString()
    {
        $uri = '';
        $url = '';
        $urn = '';

        // $this->finalUri = '';

        // Scheme
        $scheme = $this->getScheme();
        // $this->finalUri.= $scheme;
        $uri.= $scheme;
        $url.= $scheme;

        // Context
        $context = "://";
        // $this->finalUri.= $context;
        $uri.= $context;
        $url.= $context;

        // User
        $user = $this->getUser();
        $user = $user ?? null;
        // $this->finalUri.= $user;
        $uri.= $user;
        $url.= $user;
        $urn.= $user;

        // Pass
        $pass = $this->getPass();
        $pass = $pass ? ":".$pass : null;
        $this->finalUri.= $pass;
        $uri.= $pass;
        $url.= $pass;
        $urn.= $pass;

        // Host
        $host = $user ? "@" : null;
        // $this->finalUri.= $user ? "@" : null;
        // $this->finalUri.= $this->getHost();
        $uri.= $host;
        $url.= $host;
        $urn.= $host;

        // SubDomain
        $subdomain = $this->getSubdomain();
        // $this->finalUri.= $subdomain;
        $uri.= $subdomain;
        $url.= $subdomain;
        $urn.= $subdomain;

        // Hostname
        $hostname = $subdomain ? "." : null;
        $hostname.= $this->getHostname();
        // $this->finalUri.= $subdomain ? "." : null;
        // $this->finalUri.= $this->getHostname();
        $uri.= $hostname;
        $url.= $hostname;
        $urn.= $hostname;

        // TLD
        $tld = ".".$this->getTld();
        // $this->finalUri.= ".".$this->getTld();
        $uri.= $tld;
        $url.= $tld;
        $urn.= $tld;

        // Port
        $port = $this->getPort();
        $port = $port ? ":".$port : null;
        // $this->finalUri.= $port ? ":".$port : null;
        $uri.= $port;
        $url.= $port;
        $urn.= $port;

        // Path
        $segments = $this->getSegments();
        $segments = !empty($segments) ? \implode(self::SLASHE, $segments) : null;
        $segments = $segments ? self::SLASHE.$segments : null;
        // $segments = $segments ? self::SLASHE.$segments.self::SLASHE : null;
        // $this->finalUri.= $segments ? self::SLASHE.$segments.self::SLASHE : null;
        $uri.= $segments;
        $url.= $segments;
        $urn.= $segments;

        // File Name
        // $file = $this->getFile('basename');
        // $file = is_string($file) ? self::SLASHE.$file : null;
        // // $this->finalUri.= is_string($file) ? $file : null;
        // $uri.= $file;
        // $url.= $file;
        // $urn.= $file;

        $filename = $this->getFilename();
        $filename = !empty($filename) ? self::SLASHE.$filename : null;
        // $this->finalUri.= is_string($file) ? $file : null;
        $uri.= $filename;
        $url.= $filename;
        $urn.= $filename;

        // File extension
        if ($filename) 
        {
            $extension = $this->getExtension();
            $extension = !empty($extension) ? ".".$extension : null;
            // $this->finalUri.= is_string($file) ? $file : null;
            $uri.= $extension;
            $url.= $extension;
            $urn.= $extension;
        }

        // Query
        $parameters = $this->getParameters();
        $parameters = !empty($parameters) ? \http_build_query($parameters) : null;
        $parameters = $parameters ? "?".$parameters : null;
        // $this->finalUri.= $parameters ? "?".$parameters : null;
        $uri.= $parameters;
        $urn.= $parameters;

        // Fragment
        $fragments = $this->getFragments();
        $fragments = !empty($fragments) ? \http_build_query($fragments) : null;
        $fragments = $fragments ? "#".$fragments : null;
        // $this->finalUri.= $fragments ? "#".$fragments : null;
        $uri.= $fragments;
        $urn.= $fragments;

        $this->setIdentifier($uri);
        $this->setLocator($url);
        $this->setName($urn);

        // $this->finalUri = $uri;

        return $this;
    }

    public function print($type = "uri")
    {
        $this->toString();

        switch ($type)
        {
            case 'url':
                $x = $this->getLocator();
                break;

            case 'urn':
                $x = $this->getName();
                break;

            case 'uri':
            default:
                $x = $this->getIdentifier();
        }

        return urldecode($x['text']);
    }

    // Input

    public function secure(bool $secure)
    {
        $scheme = $this->getScheme();

        foreach (self::SCHEMES_WITH_SECURE_TRANSPORT as $scheme_st) 
        {
            if (!$secure && array_search($scheme, $scheme_st))
            {
                $scheme = array_search($scheme, $scheme_st);
                $this->setScheme($scheme);
                return $this;
            }
            else if ($secure && array_key_exists($scheme, $scheme_st))
            {
                $scheme = $scheme_st[$scheme];
                $this->setScheme($scheme);
                return $this;
            }
        }

        return $this;
    }
    public function toggleSecure()
    {
        $this->secure( !$this->getIsSecured() );

        return $this;
    }

    public function changeScheme(string $scheme)
    {
        $this->setScheme($scheme);

        return $this;
    }

    public function addUser(string $user)
    {
        if (empty($this->getUser()))
        {
            $this->changeUser($user);
        }

        return $this;
    }
    public function changeUser(string $user)
    {
        $this->setUser($user);

        return $this;
    }

    public function addPass(string $pass)
    {
        if (empty($this->getPass()))
        {
            $this->changePass($pass);
        }

        return $this;
    }
    public function changePass(string $pass)
    {
        $this->setPass($pass);

        return $this;
    }

    public function changeHost(string $host)
    {
        $this->setHost($host);

        return $this;
    }

    public function addPort(int $port)
    {
        if (empty($this->getPort())) 
        {
            $this->changePort($port);
        }

        return $this;
    }
    public function changePort(int $port)
    {
        $this->setPort($port);

        return $this;
    }

    public function addSubdomain(string $subdomain)
    {
        if (empty($this->getSubdomain()))
        {
            $this->changeSubdomain($subdomain);
        }

        return $this;
    }
    public function changeSubdomain(string $subdomain)
    {
        $this->setSubdomain($subdomain);

        return $this;
    }
    public function removeSubdomain()
    {
        $this->setSubdomain('');

        return $this;
    }

    public function changeHostname(string $hostname)
    {
        $this->setHostname($hostname);

        return $this;
    }

    public function changeTld(string $tld)
    {
        $db = new TLDDatabase;

        if ($db->isExists($tld))
        {
            $this->setTld($tld);
        }
        
        return $this;
    }



    public function addSegment(string $segment)
    {
        array_push($this->segments, $segment);

        return $this;
    }
    public function replaceSegment($segment, string $replacement)
    {
        $segments = $this->getSegments();

        $key = is_int($segment) ? ($segment-1) : array_search($segment, $segments);

        if ($key !== false)
        {
            $segments[$key] = $replacement;
            $this->setSegments($segments);
        }

        return $this;
    }
    public function removeSegment(string $segment)
    {
        $segments = $this->getSegments();

        $key = array_search($segment, $segments);

        if ($key !== false)
        {
            unset($segments[$key]);
            $this->setSegments($segments);
        }

        return $this;
    }
    public function removeSegments()
    {
        $this->setSegments([]);

        return $this;
    }
    public function resetSegments()
    {
        if ($this->_segments !== false)
        {
            $this->setSegments($this->_segments);
        }

        return $this;
    }



    public function addParameter(string $parameter, $value)
    {
        if (!isset($this->parameters[$parameter]))
        {
            $this->replaceParameter($parameter, $value);
        }

        return $this;
    }
    public function replaceParameter(string $parameter, $value)
    {
        $this->parameters[$parameter] = $value;

        return $this;
    }
    public function removeParameter(string $parameter)
    {
        if (isset($this->parameters[$parameter]))
        {
            unset($this->parameters[$parameter]);
        }

        return $this;
    }
    public function removeParameters()
    {
        $this->setParameters([]);

        return $this;
    }
    public function resetParameters()
    {
        if ($this->_parameters !== false)
        {
            $this->setParameters($this->_parameters);
        }

        return $this;
    }



    public function addFragment(string $parameter, $value)
    {
        if (!isset($this->fragments[$parameter]))
        {
            $this->replaceFragment($parameter, $value);
        }

        return $this;
    }
    public function replaceFragment(string $parameter, $value)
    {
        $this->fragments[$parameter] = $value;

        return $this;
    }
    public function removeFragment(string $parameter)
    {
        if (isset($this->fragments[$parameter]))
        {
            unset($this->fragments[$parameter]);
        }

        return $this;
    }
    public function removeFragments()
    {
        $this->setFragments([]);

        return $this;
    }
    public function resetFragments()
    {
        if ($this->_fragments !== false)
        {
            $this->setFragments($this->_fragments);
        }

        return $this;
    }



    



    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =


    private function parseScheme()
    {
        $scheme = parse_url($this->uri, PHP_URL_SCHEME);
        
        $this->setScheme($scheme);

        return $this;
    }

    private function parseUser()
    {
        $user = parse_url($this->uri, PHP_URL_USER);
        
        $this->setUser($user);

        return $this;
    }

    private function parsePass()
    {
        $pass = parse_url($this->uri, PHP_URL_PASS);
        
        $this->setPass($pass);

        return $this;
    }

    private function parseHost()
    {
        $uri = $this->xUri();
        
        $host = parse_url($uri, PHP_URL_HOST);
        
        $this->setHost($host);

        return $this;
    }

    private function parsePort()
    {
        $port = parse_url($this->uri, PHP_URL_PORT);
        
        $this->setPort($port);

        return $this;
    }

    private function parsePath()
    {
        $uri = $this->xUri();

        $path = parse_url($uri, PHP_URL_PATH);
        
        $this->setPath($path);

        return $this;
    }

    private function parseSegments()
    {
        $path = $this->getPath(true);

        if (!empty($path)) 
        {
            $segments = explode(self::SLASHE, $path);
            $this->setSegments($segments);

            if ($this->_segments === false) 
            {
                $this->_segments = $segments;
            }
        }

        return $this;
    }

    private function parseQuery()
    {
        $query = parse_url($this->uri, PHP_URL_QUERY);
        
        $this->setQuery($query);

        return $this;
    }

    private function parseParameters()
    {
        $query = $this->getQuery();

        parse_str($query, $parameters);

        $this->setParameters($parameters);

        if ($this->_parameters === false) 
        {
            $this->_parameters = $parameters;
        }
        return $this;
    }

    private function parseFragment()
    {
        $fragment = parse_url($this->uri, PHP_URL_FRAGMENT);
        
        $this->setFragment($fragment);

        return $this;
    }

    private function parseFragments()
    {
        $fragments = $this->getFragment();

        parse_str($fragments, $parameters);

        $this->setFragments($parameters);

        if ($this->_fragments === false) 
        {
            $this->_fragments = $parameters;
        }

        return $this;
    }

    private function parseProtocol()
    {
        $scheme = $this->getScheme();

        if (empty($scheme)) 
        {
            $scheme = 'http';
            $this->setScheme($scheme);
        }

        $protocol = $scheme."://";

        $this->setProtocol($protocol);

        return $this;
    }

    private function isSecured()
    {
        $scheme = $this->getScheme();

        foreach (self::SCHEMES_WITH_SECURE_TRANSPORT as $scheme_st) 
        {
            if (array_search($scheme, $scheme_st))
            {
                $this->setIsSecured(true);
                return $this;
            }
        }

        $this->setIsSecured(false);
        return $this;
    }


    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =


    private function xUri()
    {
        $uri = $this->scheme === null ? 'x' : null;
        $uri.= $this->uri;

        return $uri;
    }


    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    
    public function getUri()
    {
        return $this->uri;
    }
    private function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function getHash()
    {
        return $this->hash;
    }
    private function setHash($hash_mode)
    {
        switch ($hash_mode)
        {
            case self::SHA1:
                $this->hash = sha1($this->uri);
                break;

            default:
            case self::MD5:
                $this->hash = md5($this->uri);
        }

        return $this;
    }

    public function getScheme()
    {
        return $this->scheme;
    }
    private function setScheme($scheme)
    {
        $this->scheme = $scheme;

        $this->parseProtocol();

        return $this;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }
    private function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getIsSecured()
    {
        return $this->isSecured;
    }
    private function setIsSecured($isSecured)
    {
        $this->isSecured = $isSecured;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
    private function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }
    private function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }
    private function setHost($host)
    {
        $this->host = $host;

        $extract = new Extract;
        $x = $extract->parse($host);

        $this->setHostname($x['hostname']);
        $this->setRegistrableDomain($x->getRegistrableDomain());
        $this->setSubdomain($x['subdomain']);
        $this->setTld($x['suffix']);
        $this->setIsValidDomain($x->isValidDomain());
        $this->setIsIp($x->isIp());

        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }
    private function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    public function getPath($trimSlashes = false)
    {
        $path = $this->path;

        if ($path && $trimSlashes)
        {
            $firstChar = substr($path, 0, 1);

            if ($firstChar === self::SLASHE)
            {
                $path = substr($path, 1);
            }

            $lastChar = substr($path, -1);

            if ($lastChar === self::SLASHE)
            {
                $path = substr($path, 0, -1);
            }
        }

        return $path;
    }
    private function setPath($path)
    {
        $pathinfo = pathinfo($path);
        
        if (isset($pathinfo['extension'])) 
        {
            $this->setFile($pathinfo['basename']);
            $this->setDirname($pathinfo['dirname']);
            $this->setFilename($pathinfo['filename']);
            $this->setExtension($pathinfo['extension']);

            $path = preg_replace("#".$pathinfo['basename']."$#", "", $path);
        }
        
        $this->path = $path;

        return $this;
    }

    public function getSegment(int $segment = null)
    {
        $segments = $this->getSegments();
        $index = $segment-1;

        return $segments[$index] ?? null;
    }
    public function getSegments()
    {
        return $this->segments;
    }
    private function setSegments($segments)
    {
        $this->segments = $segments;

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }
    private function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function getParameter($parameter = null)
    {
        $parameters = $this->getParameters();

        if (isset($parameters[$parameter]))
        {
            return $parameters[$parameter];
        }

        return null;
    }
    public function getParameters()
    {
        return $this->parameters;
    }
    private function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getFragment()
    {
        return $this->fragment;
    }
    private function setFragment($fragment)
    {
        $this->fragment = $fragment;

        return $this;
    }


    public function getFragmentsParameter($parameter = null)
    {
        $fragments = $this->getFragments();

        if (isset($fragments[$parameter]))
        {
            return $fragments[$parameter];
        }

        return null;
    }
    public function getFragments()
    {
        return $this->fragments;
    }
    private function setFragments($fragments)
    {
        $this->fragments = $fragments;

        return $this;
    }

    public function getHostname()
    {
        return $this->domain;
    }
    private function setHostname($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function getSubdomain()
    {
        return $this->subdomain;
    }
    private function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;

        return $this;
    }

    public function getTld()
    {
        return $this->tld;
    }
    private function setTld($tld)
    {
        $this->tld = $tld;

        return $this;
    }

    public function getRegistrableDomain()
    {
        return $this->registrableDomain;
    }
    private function setRegistrableDomain($registrableDomain)
    {
        $this->registrableDomain = $registrableDomain;

        return $this;
    }

    public function getIsValidDomain()
    {
        return $this->isValidDomain;
    }
    private function setIsValidDomain($isValidDomain)
    {
        $this->isValidDomain = $isValidDomain;

        return $this;
    }

    public function getIsIp()
    {
        return $this->isIp;
    }
    private function setIsIp($isIp)
    {
        $this->isIp = $isIp;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getDirname()
    {
        return $this->dirname;
    }
    public function setDirname($dirname)
    {
        $this->dirname = $dirname;

        return $this;
    }

    public function getFilename()
    {
        return $this->filename;
    }
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function getExtension()
    {
        return $this->extension;
    }
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
    public function setIdentifier($identifier)
    {
        // $this->identifier = $identifier;
        $this->identifier = [
            'text' => $identifier,
            'md5' => md5($identifier),
            'sha1' => sha1($identifier),
        ];

        return $this;
    }

    public function getLocator()
    {
        return $this->locator;
    }
    public function setLocator($locator)
    {
        // $this->locator = $locator;
        $this->locator = [
            'text' => $locator,
            'md5' => md5($locator),
            'sha1' => sha1($locator),
        ];

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = [
            'text' => $name,
            'md5' => md5($name),
            'sha1' => sha1($name),
        ];

        return $this;
    }
}