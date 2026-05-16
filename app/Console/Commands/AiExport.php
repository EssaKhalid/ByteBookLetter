<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AiExport extends Command
{
    // The command name you will type in terminal
    protected $signature = 'ai:export';

    protected $description = 'Export project files to a .txt file for AI debugging';

    public function handle()
    {
        // Name of the file that will be created in your root folder
        $fileName = 'ai_project_export.txt';

        // Folders and files to include
        $paths = [
            'app/Livewire',
            'app/Models',
            'app/Http/Controllers',
            'resources/views/livewire',
            'resources/views/layouts',
            'resources/views/components',
            'routes/web.php',
            'app/View/Components', // Some layout classes live here
        ];

        $content = "--- PROJECT EXPORT FOR AI DEBUGGING ---\n";
        $content .= "Generated at: " . now()->toDateTimeString() . "\n\n";

        foreach ($paths as $path) {
            $fullPath = base_path($path);

            if (File::exists($fullPath)) {
                if (File::isDirectory($fullPath)) {
                    $files = File::allFiles($fullPath);
                    foreach ($files as $file) {
                        // Skip non-blade/php files if they exist
                        if (!in_array($file->getExtension(), ['php', 'html'])) continue;

                        $content .= "========================================\n";
                        $content .= "FILE: " . $file->getRelativePathname() . "\n";
                        $content .= "PATH: " . $path . "/" . $file->getRelativePathname() . "\n";
                        $content .= "========================================\n";
                        $content .= $file->getContents() . "\n\n";
                    }
                } else {
                    $content .= "========================================\n";
                    $content .= "FILE: " . $path . "\n";
                    $content .= "========================================\n";
                    $content .= File::get($fullPath) . "\n\n";
                }
            }
        }

        $content .= "\n--- END OF EXPORT ---";

        // Create the file in the root directory
        File::put(base_path($fileName), $content);

        $this->info("Successfully exported! Check the file: {$fileName}");
    }
}
