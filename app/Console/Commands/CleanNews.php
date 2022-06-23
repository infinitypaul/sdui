<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class CleanNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete News Older Than 14 Days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $news = News::where('created_at', '<=', now()->subDays(14)->toDateTimeString());

        $bar = $this->output->createProgressBar($news->count());

        $news->cursor()->each(function (News $new) use ($bar) {
            $new->delete();
            $bar->advance();
        });

        $bar->finish();

    }
}
