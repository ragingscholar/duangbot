<?php

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

if (!file_exists(TOKENFILE))
{
    $tokenInfo = $t->createApp(NAME, URL);
    file_put_contents(TOKENFILE, serialize($tokenInfo));
}

$tokenInfo = unserialize(file_get_contents(TOKENFILE));
$auth_url = $t->getAuthUrl();

$client = new \GuzzleHttp\Client();
$res = $client->request('POST', PROTOCTOL . '://' . DOMAIN . '/oauth/token', [
    'form_params' => [
        'client_id' => $tokenInfo['client_id'],
        'client_secret' => $tokenInfo['client_secret'],
        'grant_type' => 'password',
        'username' => USERNAME,
        'password' => PASSWORD,
    ]
]);
//curl -X POST -d "client_id=4b4df1cf334904d81d1271dbc3fe0a9829376ca5eb63a3295a82fe0067da1e16&client_secret=003a99ac77be058831c744950303344daeed03a454702bd073f5df79ae18d87e&grant_type=password&username=hailang@outlook.com&password=a06748b9c7ff" -Ss https://mastodon.social/oauth/token

echo $res->getStatusCode();
// 200
echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
?>
