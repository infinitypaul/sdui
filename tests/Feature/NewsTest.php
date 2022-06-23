<?php

namespace Tests\Feature;

use App\Events\NewsCreated;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NewsTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user  = User::factory()->create();
        Sanctum::actingAs(
            $this->user,
            ['*']
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_we_can_create_news()
    {
        $response = $this->postJson('/api/news', [
            'title' => 'Paul Edward',
            'content' => 'World Best'
        ]);

        $response->assertStatus(201)->assertJson([
            'data' => [
                'title' => 'Paul Edward',
            'content' => 'World Best',
            'user' => [
                'id' => $this->user->id
            ]
        ]]);
    }

    public function test_we_can_read_news(){
        //$me = User::factory()->has(News::factory()->count(5), 'news')->create();
        News::factory()->count(5)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->getJson('/api/news');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'title', 'content', 'user' => ['id']
                ]
            ]
        ]);
    }

    public function test_we_can_update_news(){
        $news = News::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->patchJson('/api/news/'.$news->id, [
            'title' => 'Paul Edward',
            'content' => $news->content
        ]);

        $response->assertStatus(200)->assertJson([
            'data' => [
                'title' => 'Paul Edward',
                'content' => $news->content,
                'user' => [
                    'id' => $this->user->id
                ]
            ]]);
    }

    public function test_we_can_delete_news(){
        $news = News::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->deleteJson("api/news/$news->id");

        $this->assertDatabaseMissing('news', $news->toArray());
    }

    public function test_unauthorized_user_cannot_update_news(){
        $news = News::factory()->create();
        $response = $this->patchJson('/api/news/'.$news->id, [
            'title' => 'Paul Edward',
            'content' => $news->content
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_delete_news(){
        $news = News::factory()->create();

        $response = $this->deleteJson("api/news/$news->id");

        $response->assertStatus(403);
    }


    public function test_event_fired_on_news_created()
    {
        Event::fake();

        $this->postJson('/api/news', [
            'title' => 'Paul Edward',
            'content' => 'World Best'
        ]);

        Event::assertDispatched(NewsCreated::class);

    }
}
