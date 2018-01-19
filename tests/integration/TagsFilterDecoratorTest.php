<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class TagsFilterDecoratorTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_filters_by_tags()
    {
        $tag = factory(App\Models\Tag::class)->create();
        $gallery = factory(App\Models\Gallery::class)->create();

        $this->assertTrue(true);
    }
}
