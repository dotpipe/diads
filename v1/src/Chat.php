<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use MyApp\Encryption\ServerEncryption;

class Chat implements MessageComponentInterface {
    protected ;
    protected ;

    public function __construct(ServerEncryption ) {
        ->clients = new \SplObjectStorage;
        ->encryption = ;
    }

    public function onOpen(ConnectionInterface ) {
        ->clients->attach();
        ->send(json_encode(['type' => 'key', 'key' => ->encryption->getPublicKey()]));
    }

    public function onMessage(ConnectionInterface , ) {
         = json_decode(, true);
        if (['type'] === 'message') {
             = ->encryption->decrypt(['content']);
            foreach (->clients as ) {
                if ( !== ) {
                    ->send(json_encode(['type' => 'message', 'content' => ['content']]));
                }
            }
        }
    }

    public function onClose(ConnectionInterface ) {
        ->clients->detach();
    }

    public function onError(ConnectionInterface , \Exception ) {
        ->close();
    }
}
