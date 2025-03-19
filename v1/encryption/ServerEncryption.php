<?php
namespace MyApp\Encryption;

class ServerEncryption {
    private $privateKey;
    private $publicKey;

    public function __construct() {
        $config = [
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $this->privateKey);
        $this->publicKey = openssl_pkey_get_details($res)['key'];
    }

    public function getPublicKey() {
        return $this->publicKey;
    }

    public function decrypt($data) {
        openssl_private_decrypt(base64_decode($data), $decrypted, $this->privateKey);
        return $decrypted;
    }
}