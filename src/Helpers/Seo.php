<?php

namespace BoomDraw\Helpers\Helpers;

use Illuminate\Database\Schema\Blueprint;

class Seo
{
    /**
     * Add default seo columns to the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $type
     */
    public function columns(Blueprint $table, $type = 'string')
    {
        $table->$type('meta_keywords')->nullable();
        $table->$type('meta_description')->nullable();
        $table->enum('robots', ['index,follow', 'noindex,nofollow', 'noindex,follow', 'index,nofollow'])->default('index,follow');
    }
}
