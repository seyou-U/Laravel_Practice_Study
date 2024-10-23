<?php

declare(strict_types=1);

namespace App;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use phpseclib3\Crypt\Blowfish;

class BlowfishEncrypter implements EncrypterContract
{
    protected $encrypter;
    protected $key;

    /**
     * コンストラクタ
     * @param string $key
     * @return void
     */
    public function __construct(string $key)
    {
        $this->key = $key;
        $this->encrypter = new Blowfish('ecb');
        $this->encrypter->setKey($this->key);
    }

    /**
     * 暗号化処理を行うメソッド
     *
     * @param  mixed  $value
     * @param  bool  $serialize
     * @return string
     */
    public function encrypt($value, $serialize = true): string
    {
        return $this->encrypter->encrypt($value);
    }

    /**
     * 復号化を行うメソッド
     *
     * @param  string  $payload
     * @param  bool  $unserialize
     * @return mixed
     */
    public function decrypt($payload, $unserialize = true): mixed
    {
        return $this->encrypter->decrypt($payload);
    }

    /**
     * Get the encryption key that the encrypter is currently using.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * interfaceで定義されているため記述
     *
     */
    public function getAllKeys(){
        //
    }

    /**
     * interfaceで定義されているため記述
     *
     */
    public function getPreviousKeys(){
        //
    }
}
