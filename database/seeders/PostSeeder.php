<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    const POST_1_SLUG = 'laravel-test-post-1';
    const POST_1_USER_ID = '1';
    const POST_2_SLUG = 'laravel-test-post-2';
    const POST_2_USER_ID = '2';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => self::POST_1_USER_ID,
            'title' => 'Test Post 1',
            'body' => 'Test Body 1',
            'slug' => self::POST_1_SLUG,
            'active' => '1',
            'metaDescription' => '',
            'metaTitle' => ''
        ]);

        DB::table('posts')->insert([
            'user_id' => self::POST_2_USER_ID,
            'title' => 'Test Post 2',
            'body' => 'Test Body 2',
            'slug' => self::POST_2_SLUG,
            'active' => '0',
            'metaDescription' => '',
            'metaTitle' => ''
        ]);
    }
}
