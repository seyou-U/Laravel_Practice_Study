<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * トップ画面にアクセスした際のステータスコードが200番であること
     */
    public function testStatusCode(): void
    {
        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    /**
     * トップ画面に「こんにちは」という文字列が含まれていること
     */
    public function testBody(): void
    {
        $response = $this->get('/home');
        $response->assertSeeText("こんにちは");
    }
}
