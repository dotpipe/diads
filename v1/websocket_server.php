<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
use MyApp\Encryption\ServerEncryption;

require dirname(__DIR__) . '/vendor/autoload.php';

 = new ServerEncryption();
 = new Chat();

 = IoServer::factory(
    new HttpServer(
        new WsServer()
    ),
    8080
);

->run();
