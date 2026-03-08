<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Memo;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 認証ユーザーがメモを作成できること
     */
    public function test_user_can_create_memo(): void
    {
        $user = User::factory()->create();

        $payload = [
            'title' => '旅行メモ',
            'content' => '東京の回りかたをまとめる'
        ];

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/memos', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => '【メモ】旅行メモ']);

        $this->assertDatabaseHas('memos', [
            'user_id' => $user->id,
            'title' => '旅行メモ',
        ]);
    }

    /**
     * タイトルは必須であること
     */
    public function test_title_is_required(): void
    {
        $user = User::factory()->create();

        $payload = [
            'content' => '東京の回りかたをまとめる'
        ];

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/memos', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }

    /**
     * 未ログインユーザーはメモを作成できないこと
     */
    public function test_guest_cannot_create_memo(): void
    {
        $payload = [
            'title' => '旅行メモ',
            'content' => '東京の回りかたをまとめる'
        ];

        $response = $this->postJson('/api/memos', $payload);

        $response->assertUnauthorized();
    }

    /**
     * 自分のメモだけが取得できること
     */
    public function test_user_can_list_own_memos(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Memo::factory()->create([
            'user_id' => $user->id,
            'title' => '自分のメモA',
        ]);

        Memo::factory()->create([
            'user_id' => $user->id,
            'title' => '自分のメモB',
        ]);

        Memo::factory()->create([
            'user_id' => $otherUser->id,
            'title' => '他人のメモ',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/memos');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data')
                 ->assertJsonFragment(['title' => '【メモ】自分のメモA'])
                 ->assertJsonFragment(['title' => '【メモ】自分のメモB'])
                 ->assertJsonMissing(['title' => '【メモ】他人のメモ']);
    }
}
