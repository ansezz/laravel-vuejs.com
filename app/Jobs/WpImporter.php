<?php

namespace LaravelVueJs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

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
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name);
        Artisan::call('wp:import', ['file' => $path]);
    }
}
