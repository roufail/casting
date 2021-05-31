<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WorkImage;
use Storage;
class DeleteUnusedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:unusedfiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command to delete files not related to posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $urls_array = WorkImage::pluck('image_url')->toArray();
        $dir_images = Storage::disk("work_images")->allFiles("/");
        foreach ($dir_images as $image_url) {
            if(!in_array($image_url,$urls_array)) {
                Storage::disk("work_images")->delete($image_url);
            }
        }
    }
}
