<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use MyApp\Encryption\ServerEncryption;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $encryption;

    public function __construct(ServerEncryption $encryption) {
        $this->clients = new \SplObjectStorage;
        $this->encryption = $encryption;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $conn->send(json_encode(['type' => 'key', 'key' => $this->encryption->getPublicKey()]));
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        if ($data['type'] === 'message') {
            $decryptedMessage = $this->encryption->decrypt($data['content']);
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send(json_encode(['type' => 'message', 'content' => $decryptedMessage]));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}
