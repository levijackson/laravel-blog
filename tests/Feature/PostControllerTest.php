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
    public function testBlogPageDoesLoadAnonymousUser(): void
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    /**
     * Anyone can view single blog posts
     *
     * @return void
     */
    public function testSingleBlogPostDoesLoadAnonymousUser(): void
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
    public function testDraftBlogPostDoesLoadAuthor(): void
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
    public function testNewBlogPostDoesNotLoadAnonymousUser(): void
    {
        $response = $this->get('/admin/blog/post');
        $response->assertStatus(500);
    }

    /**
     * Authors can load the new blog post page
     *
     * @return void
     */
    public function testNewBlogPostDoesLoadAuthor(): void
    {
        $user = User::factory()->create();
        $user->role = 'author';

        $response = $this->actingAs($user)
            ->get('/admin/blog/post');
            $response->assertStatus(200);
    }

    /**
     * Edit blog post URLs should not be loadable by an
     * anonymous user
     *
     * @return void
     */
    public function testEditBlogPostDoesNotLoadAnonymousUser(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->get('/admin/blog/post/laravel-test-post-1');
        $response->assertStatus(500);
    }

    /**
     * Authors can load the new blog post page
     *
     * @return void
     */
    public function testEditBlogPostDoesLoadAuthor(): void
    {
        $this->seed(PostSeeder::class);

        $user = User::factory()->create();
        $user->role = 'author';
        $user->id = '1';

        $response = $this->actingAs($user)
            ->get('/admin/blog/post/laravel-test-post-1');
            $response->assertStatus(200);
    }

    /**
     * Authors can load the draft blog post page
     *
     * @return void
     */
    public function testEditDraftBlogPostDoesLoadAuthor(): void
    {
        $this->seed(PostSeeder::class);

        $user = User::factory()->create();
        $user->role = 'author';
        $user->id = '2';

        $response = $this->actingAs($user)
            ->get('/admin/blog/post/laravel-test-post-2');
            $response->assertStatus(200);
    }


    // TODO
    /**
     * - Anonymyous users can not comment on a blog post
- Anonymous users can not delete blog posts
- Admins can add a new post
- Admins can edit a post
- Admins can delete a post
- Admins can view a draft blog post
- Authors can add a new post
- Authors can edit a post
- Authors can delete a post
     */


    /**
     * Anonymous users can not comment on a post
     *
     * @return void
     */
    public function testAnonymousUsersCanNotComment(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->post('/admin/blog/comment');
        $response->assertStatus(200);
    }
}
