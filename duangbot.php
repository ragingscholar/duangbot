<?php
error_reporting(E_ALL);

require_once("./vendor/autoload.php");

const NAME = "DuangBot";
const URL = "http://cmx.im";
const PROTOCOL = "https";
const DOMAIN = "cmx.im";
const TOKENFILE = "token";
const USERNAME = "duangbot@cmx.im";
const PASSWORD = "a06748b9c7ff";

$t = new \theCodingCompany\Mastodon();
$t->setMastodonDomain(DOMAIN);

/*
if (!file_exists(TOKENFILE))
{
    $tokenInfo = $t->createApp(NAME, URL);
    file_put_contents(TOKENFILE, serialize($tokenInfo));
}
*/
//$tokenInfo = unserialize(file_get_contents(TOKENFILE));
$tokenInfo = $t->createApp(NAME, URL);
var_dump($tokenInfo);
$t->setCredentials($tokenInfo);
$auth_url = $t->getAuthUrl();
var_dump($auth_url);
die();

$client = new \GuzzleHttp\Client();
$res = $client->request('POST', PROTOCOL . '://' . DOMAIN . '/oauth/token', [
    'allow_redirects' => false,
    'form_params' => [
        'client_id' => $tokenInfo['client_id'],
        'client_secret' => $tokenInfo['client_secret'],
        'grant_type' => 'authorization_code',
        'username' => USERNAME,
        'password' => PASSWORD,
    ],
]);

//echo $res->getBody();

switch ($res->getStatusCode())
{
    case '500':
        throw new \Exception("The remote server has encountered unexpected error");
    case '301':
        throw new \Exception("The username or password supplied in the config is not valid");
    default:
        throw new \Exception("UNKNOWN error: " . $res->getStatusCode());
    case '200':
        break;
}


$accessToken = json_decode($res->getBody(), true)['access_token'];
//print_r(json_decode($res->getBody(), true));
//print_r($accessToken);

var_dump($tokenInfo);
$tokenInfo = $t->getAccessToken($accessToken);

var_dump($tokenInfo);
/*
//curl -X POST -d "client_id=4b4df1cf334904d81d1271dbc3fe0a9829376ca5eb63a3295a82fe0067da1e16&client_secret=003a99ac77be058831c744950303344daeed03a454702bd073f5df79ae18d87e&grant_type=password&username=hailang@outlook.com&password=a06748b9c7ff" -Ss https://mastodon.social/oauth/token

echo $res->getStatusCode();
// 200
echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
*/
?>
