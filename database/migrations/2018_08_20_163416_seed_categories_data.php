<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => '分享',
                'description' => '分享创造，分享发现',
            ],
            [
                'name'        => '服务器',
                'description' => '网站部署等',
            ],
            [
                'name'        => 'Laravel',
                'description' => '我们都在Laravel，互帮互助',
            ],
            [
                'name'        => 'PHP',
                'description' => '关于PHP的一切学术问题',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::table('categories')->truncate();
    }
}
