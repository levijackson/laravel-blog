<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => '1',
            'title' => 'Test Post 1',
            'body' => 'Test Body 1',
            'slug' => 'laravel-test-post-1',
            'active' => '1',
            'metaDescription' => '',
            'metaTitle' => ''
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'title' => 'Test Post 2',
            'body' => 'Test Body 2',
            'slug' => 'laravel-test-post-2',
            'active' => '0',
            'metaDescription' => '',
            'metaTitle' => ''
        ]);
    }
}
