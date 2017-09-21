<?php

require_once("./vendor/autoload.php");

const NAME = "DuangBot";
const URL = "http://cmx.im";
const PROTOCOL = "https";
const DOMAIN = "cmx.im";
const TOKENFILE = "token";
const USERNAME = "duangbot@cmx.im";
const PASSWORD = "aoeu";

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
echo $res->getStatusCode();
// 200
echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
?>
