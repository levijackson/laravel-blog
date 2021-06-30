<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Anonymous users can not comment on a post
     *
     * @return void
     */
    public function testAnonymousUsersCanNotComment(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->post('/admin/blog/comment', ['post_id' => '1', 'comment' => 'test comment']);
        $response->assertStatus(403);
    }
    /**
     * Anonymous users can not delete a comment on a post
     *
     * @return void
     */
    public function testAnonymousUsersCanNotDeleteComment(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->delete('/admin/blog/comment/1');
        $response->assertStatus(403);
    }
}
