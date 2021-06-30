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

        $response = $this->get('/blog/post/' . PostSeeder::POST_1_SLUG);
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

        $response = $this->get('/blog/post/' . PostSeeder::POST_2_SLUG);
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
            ->get('/blog/post/' . PostSeeder::POST_2_SLUG);
        $response->assertStatus(200);
    }

    /**
     * Anaonymous users can not load new blog post page
     *
     * @return void
     */
    public function testNewBlogPostDoesNotLoadAnonymousUser(): void
    {
        $response = $this->get('/admin/blog/post');
        $response->assertStatus(302);
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
     * Authors can save a new blog post
     *
     * @return void
     */
    public function testNewBlogPostCreatedByAuthor(): void
    {
        $user = User::factory()->create();
        $user->role = 'author';
        $user->id = '1';

        $data = [
            'title' => 'Test new post by author',
            'metaTitle' => '',
            'body' => 'a blog post',
            'metaDescription' => '',
            'slug' => 'test-new-post-by-author'
        ];

        $response = $this->actingAs($user)
            ->post('/admin/blog/post', $data);
        $response->assertStatus(302);
        $this->assertGreaterThan(0, strpos($response->getTargetUrl(), $data['slug']));
    }

    /**
     * Anonymous users can not load a blog post edit page
     *
     * @return void
     */
    public function testEditBlogPostDoesNotLoadAnonymousUser(): void
    {
        $this->seed(PostSeeder::class);

        $response = $this->get('/admin/blog/post/' . PostSeeder::POST_1_SLUG);
        $response->assertStatus(302);
    }

    /**
     * Authors can load the edit blog post page
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
            ->get('/admin/blog/post/' . PostSeeder::POST_1_SLUG);
        $response->assertStatus(200);
    }

    /**
     * Authors can save an edit to a blog post
     *
     * @return void
     */
    public function testEditBlogPostSavedByAuthor(): void
    {
        $this->seed(PostSeeder::class);

        $user = User::factory()->create();
        $user->role = 'author';
        $user->id = '1';

        $data = [
            'title' => 'Test new post by author',
            'metaTitle' => '',
            'body' => 'a blog post',
            'metaDescription' => '',
            'slug' => 'test-edit-post-by-author'
        ];

        $response = $this->actingAs($user)
            ->put('/admin/blog/post/' . PostSeeder::POST_1_SLUG, $data);
        $response->assertStatus(302);
        $this->assertGreaterThan(0, strpos($response->getTargetUrl(), $data['slug']));
    }

    /**
     * Authors can delete posts
     *
     * @return void
     */
    public function testAuthorCanDeletePost(): void
    {
        $this->seed(PostSeeder::class);

        $user = User::factory()->create();
        $user->role = 'author';
        $user->id = '1';

        $data = [
            'title' => 'Test post by author',
            'metaTitle' => '',
            'body' => 'a blog post',
            'metaDescription' => '',
            'delete' => 1
        ];

        $response = $this->actingAs($user)
            ->put('/admin/blog/post/' . PostSeeder::POST_2_SLUG, $data);
        $response->assertStatus(302);
        $this->assertGreaterThan(0, strpos($response->getTargetUrl(), '/admin/blog/post'));
    }
}
