<?php

namespace Tests\Unit;

use App\Models\Comment;
use Database\Seeders\CommentSeeder;
use Database\Seeders\DatabaseSeeder;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private $faker;
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_should_not_allow_empty_fields()
    {
        $data = [
            'name' => '',
            'comment' => ''
        ];

        $response = $this->post('/comments', $data);

        $this->assertNotEquals(200, $response->status(), 'Comment should not allow empty fields');
    }

    public function test_should_not_allow_insert_invalid_parent() {
        $data = [
            'name' => $this->faker->name(),
            'comment' => $this->faker->text(),
            'comment_id' => $this->faker->numberBetween(1000, 9999)
        ];

        $response = $this->post('/comments', $data);

        $this->assertNotEquals($response->status(), 200, 'The comment should not accept a invalid comment id');
    }

    public function test_should_fetch_root_comments() {
        $items = 5;
        Comment::factory($items)->create();

        $response = $this->get('/comments');

        $this->assertEquals($items, count($response['data']));
    }

    public function test_should_fetch_child_comments() {
        $items = 3;
        $comment = Comment::factory()->create();
        Comment::factory($items)
            ->state([
                'comment_id' => $comment->id
            ])
            ->create();


        $response = $this->get("/comments?comment_id=$comment->id");

        $this->assertEquals($items, count($response['data']));
    }

    public function test_should_fetch_child_comments_from_invalid_comment_id() {
        $comment_id = 'test';
        $response = $this->get("/comments?comment_id=$comment_id");

        $this->assertNotEquals($response->status(), 200, 'There is no comment child for invalid comment id');
    }
}
