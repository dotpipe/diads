<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
use MyApp\Encryption\ServerEncryption;

require dirname(__DIR__) . '/vendor/autoload.php';

$encryption = new ServerEncryption();
$chat = new Chat($encryption);

$server = IoServer::factory(
    new HttpServer(
        new WsServer($chat)
    ),
    8080
);

$server->run();
