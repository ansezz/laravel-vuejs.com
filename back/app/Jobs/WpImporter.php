<?php

namespace LaravelVueJs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelVueJs\Models\Post;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Storage;

class WpImporter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file_name;

    /**
     * Create a new job instance.
     *
     * @param $file_name
     */
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        echo 'start  ';

        /** @var string $path */
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name);

        if (file_exists($path)) {
            echo $path . '  ';
            $xml = simplexml_load_file($path);

            foreach ($xml->channel->item as $item) {
                echo (string)$item->title . ' ';
                $categories = [];
                $tags = [];
                foreach ($item->category as $cat) {
                    if ($cat['domain'] == 'category') {
                        $categories[] = (string)$cat['nicename'];
                    }

                    if ($cat['domain'] == 'post_tag') {
                        $tags[] = (string)$cat['nicename'];
                    }
                }

                $e_content = $item->children("content", true);
                $e_excerpt = $item->children("excerpt", true);
                $wp = $item->children("wp", true);

                /** @var Post $post */
                $post = Post::create([
                    'user_id' => 1,
                    'title' => (string)$item->title,
                    'slug' => (string)$wp->post_name,
                    'excerpt' => (string)$e_excerpt->encoded,
                    'content' => (string)$e_content->encoded,
                    'type' => 1,
                    'status' => 1,
                    'comment_status' => 1,
                ]);

                preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', (string)$e_content->encoded, $image);

                try {
                    $post->addMediaFromUrl($image['src'])
                        ->toMediaCollection(Post::MEDIA_COLLECTION);
                } catch (FileCannotBeAdded $e) {
                }

                $post->attachTags($tags);
                $post->attachCategories($categories);
            }

            Storage::disk('local')->move(
                'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name,
                'wp-importer' . DIRECTORY_SEPARATOR . 'done' . DIRECTORY_SEPARATOR . $this->file_name
            );

        }

    }
}
