<?php

namespace Haxibiao\Tag\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{

    /**
     * The name and signature of the Console command.
     *
     * @var string
     */
    protected $signature = 'tag:install';

    /**
     * The Console command description.
     *
     * @var string
     */
    protected $description = '安装 haxibiao/tag';

    /**
     * Execute the Console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('发布资源');

        $this->call('vendor:publish', [
            '--tag'   => 'tag-graphql',
        ]);

        $this->comment("复制 stubs ...");
        copy(__DIR__ . '/stubs/Tag.stub', app_path('Tag.php'));
    }
}
