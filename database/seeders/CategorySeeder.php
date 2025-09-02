<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Remove all existing categories
        Category::query()->delete();
        // Seed subject names from /resources/views/video/ and /resources/views/classes/ excluding 'create'
        $videoViewsPath = base_path('resources/views/video');
        $classViewsPath = base_path('resources/views/classes');
        $files = array_merge(File::files($videoViewsPath), File::files($classViewsPath));
        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $subject = str_replace('.blade', '', $filename);
            if ($subject !== 'create') {
                Category::firstOrCreate(['name' => $subject]);
            }
        }
    }
}
