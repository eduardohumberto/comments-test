<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    protected $maxLayer = 3;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($allow_child = true)
    {
        $comments = Comment::factory(config('comments.items_per_page'))->create();

        if($allow_child) {
            foreach ($comments as $comment) {
                $this->createChild(0, $comment->id);
            }
        }

    }

    function createChild($currentLayer, $comment_id) {
        $layer = $currentLayer + 1;
        if($this->maxLayer > $layer) {
            $comments = Comment::factory(config('comments.items_per_page'))->state([
                'comment_id' => $comment_id
            ])->create();

            foreach ($comments as $comment) {
                $this->createChild($layer, $comment->id);
            }
        }
    }
}
