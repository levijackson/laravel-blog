<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Anyone can view the list of blog posts
     *
     * @return void
     */
    public function testBlogPageLoadAnonymousUser(): void
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    public function testBlogPostLoadAnonymousUser(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->get('/blog/post/laravel-test-post-1');
        $response->assertStatus(200);
    }

    /**
     * Draft posts should not load for anonymous users
     *
     * @return void
     */
    public function testDraftBlogPostDoesNotLoadAnonymousUser(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->get('/blog/post/laravel-test-post-2');
        $response->assertStatus(302);
    }

    /**
     * Draft posts SHOULD load for authors
     *
     * @return void
     */
    public function testDraftBlogPostDoesLoadAnonymousUser(): void
    {
        $this->seed(PostSeeder::class);

        $user = User::factory()->create();
        $user->role = 'author';

        $response = $this->actingAs($user)
            ->get('/blog/post/laravel-test-post-2');
        $response->assertStatus(200);
    }

    /**
     * New blog post URLs should not be loadable by an
     * anonymous user
     *
     * @return void
     */
    public function testNewBlogPostLoadAnonymousUser(): void
    {
        $response = $this->get('/admin/blog/post');
        $response->assertStatus(500);
    }

    /**
     * Authors can load the new blog post page
     *
     * @return void
     */
    public function testNewBlogPostLoadAuthor(): void
    {
        $user = User::factory()->create();
        $user->role = 'author';

        $response = $this->actingAs($user)
            ->get('/admin/blog/post');
            $response->assertStatus(200);
    }
}
