<?php

namespace App\Entities;

use App\Entities\CustomEntity; 

class Logins extends CustomEntity
{
    protected string $encryptionKey;

    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->encryptionKey = 'pGLbMbfW2B1e6jHSLh05ldA3MkxUNPdF';
    }

    public function setPassword(string $pass): self
    {
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($pass, 'aes-256-cbc', $this->encryptionKey, 0, $iv);

        if ($encrypted === false) {
            throw new \RuntimeException('Encryption failed');
        }

        $this->attributes['password'] = base64_encode($iv . $encrypted);
        return $this;
    }

    public function getPassword(): ?string
    {
        if (empty($this->attributes['password'])) {
            return null;
        }

        $data = base64_decode($this->attributes['password'], true);
        if ($data === false) {
            return null; // decode failed
        }

        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivLength);
        $cipherText = substr($data, $ivLength);

        $decrypted = openssl_decrypt($cipherText, 'aes-256-cbc', $this->encryptionKey, 0, $iv);

        if ($decrypted === false) {
            return ''; // decryption failed
        }

        return $decrypted;
    }
}