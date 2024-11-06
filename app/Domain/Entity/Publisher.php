<?php

namespace App\Domain\Entity;

// 戻り値や引数を指定するクラス (Repositoryを抽象化する)
class Publisher
{
    protected $id;
    protected $name;
    protected $address;

    public function __construct(?int $id, string $name, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getAddress(): String
    {
        return $this->address;
    }
}
