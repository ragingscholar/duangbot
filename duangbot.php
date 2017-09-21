<?php
error_reporting(E_ALL);
date_default_timezone_set('PRC');

require_once("./vendor/autoload.php");

const NAME = "DuangBot";
const URL = "http://cmx.im";
const PROTOCOL = "https";
const DOMAIN = "cmx.im";
const TOKENFILE = "token";
const AUTHCODE = "aaef67f955b7a05b37f978772185b148426befc6f6388ff0f59b077f0b8bdd81";
const USERNAME = "duangbot@cmx.im";
const PASSWORD = "a06748b9c7ff";
const APIPOST = "/api/v1/statuses";

$t = new \theCodingCompany\Mastodon();
$t->setMastodonDomain(DOMAIN);

if (!file_exists(TOKENFILE))
{
    $tokenInfo = $t->createApp(NAME, URL);
    file_put_contents(TOKENFILE, serialize($tokenInfo));
}
$tokenInfo = unserialize(file_get_contents(TOKENFILE));
$t->setCredentials($tokenInfo);

/*
$auth_url = $t->getAuthUrl();
echo $auth_url;
die();
*/
$token_info = $t->getAccessToken(AUTHCODE);

$message = "";
$currentHour = (int)date("h");
for ($i = 0; $i < $currentHour; $i++)
{
    $message = $message . 'duang~';
}
$status = $t->authenticate(USERNAME, PASSWORD)
            ->postStatus($message);
//$auth_url = $t->getAuthUrl();

/*
$client = new \GuzzleHttp\Client();
$res = $client->request('POST', PROTOCOL . '://' . DOMAIN . '/oauth/token', [
    'allow_redirects' => false,
    'form_params' => [
        'client_id' => $tokenInfo['client_id'],
        'client_secret' => $tokenInfo['client_secret'],
        'grant_type' => 'password',
        'username' => USERNAME,
        'password' => PASSWORD,
    ],
]);

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
*/



//$accessToken = json_decode($res->getBody(), true)['access_token'];

//$tokenInfo = $t->getAccessToken($accessToken);
//$tokenInfo['access_token'] = $accessToken;

/*
$res = $client->request('POST', PROTOCOL . '://' . DOMAIN . APIPOST, [
    'headers' => [
        'Authorization' => 'Bearer ' . $accessToken,
    ],
    'form_params' => [
        'status' => 'This is a new duang bot',
    ],
]);
*/

/*
//curl -X POST -d "client_id=4b4df1cf334904d81d1271dbc3fe0a9829376ca5eb63a3295a82fe0067da1e16&client_secret=003a99ac77be058831c744950303344daeed03a454702bd073f5df79ae18d87e&grant_type=password&username=hailang@outlook.com&password=a06748b9c7ff" -Ss https://mastodon.social/oauth/token

echo $res->getStatusCode();
// 200
echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
*/
?>
