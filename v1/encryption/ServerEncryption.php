<?php
namespace MyApp\Encryption;

class ServerEncryption {
    private ;
    private ;

    public function __construct() {
         = [
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
         = openssl_pkey_new();
        openssl_pkey_export(, ->privateKey);
        ->publicKey = openssl_pkey_get_details()['key'];
    }

    public function getPublicKey() {
        return ->publicKey;
    }

    public function decrypt() {
        openssl_private_decrypt(base64_decode(), , ->privateKey);
        return ;
    }
}
