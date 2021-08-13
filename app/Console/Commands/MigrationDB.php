<?php

namespace App\Console\Commands;

use App\Models\Content\Category;
use App\Models\Content\Post\Post;
use App\Models\Content\Section;
use App\Models\IndexUrl;
use App\Models\Master\Tags\Tag;
use App\Services\IndexUrlService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrationDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database Migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $indexUrl;

    public function __construct(
        IndexUrlService $indexUrl
    )
    {
        $this->indexUrl = $indexUrl;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dbConnect = DB::connection('mysql2');

        // $this->tags($dbConnect);
        // $this->sections($dbConnect);
        // $this->categories($dbConnect);
        $this->posts($dbConnect);
    }

    public function tags($dbConnect)
    {
        $tags = $dbConnect->table('gmbuy_tags')->where('level', 1)->get();
        foreach ($tags as $key => $value) {
            Tag::create([
                'id' => $value->id,
                'name' => $value->title,
                'description' => $value->description,
                'flags' => $value->published,
                'standar' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::parse($value->created_time)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($value->modified_time)->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function sections($dbConnect)
    {
        $sections = $dbConnect->table('gmbuy_categories')->where('parent_id', 1)->whereIn('extension', ['com_content'])
            ->whereNotIn('alias', ['uncategorised', 'unused1'])->get();

        foreach ($sections as $key => $value) {
            $slug = Str::limit(Str::slug($value->alias, '-'), 50);

            $checkIndex = IndexUrl::where('slug', $slug)->count();
            if ($checkIndex == 0) {
                
                $section = Section::create([
                    'id' => $value->id,
                    'name' => [
                        'id' => $value->title,
                        'en' => $value->title
                    ],
                    'slug' => $slug,
                    'description' => [
                        'id' => $value->description,
                        'en' => $value->description,
                    ],
                    'public' => 1,
                    'extra' => 0,
                    'is_detail' => 1,
                    'order_field' => 4,
                    'order_by' => 'DESC',
                    'list_view_id' => null,
                    'detail_view_id' => null,
                    'limit_category' => null,
                    'limit_post' => null,
                    'post_selection' => null,
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null,
                    ],
                    'field_category_id' => null,
                    'custom_field' => null,
                    'position' => ($key+1),
                    'created_by' => 1,
                    'updated_by' => 1,
                    // 'created_at' => Carbon::parse($value->created_time)->format('Y-m-d H:i:s'),
                    // 'updated_at' => Carbon::parse($value->modified_time)->format('Y-m-d H:i:s'),
                ]);

                $this->indexUrl->store($slug, $section);
            }
        }
    }

    public function categories($dbConnect)
    {
        $categories = $dbConnect->table('gmbuy_categories')->where('parent_id', '>=', 2)->whereIn('extension', ['com_content'])
            ->whereNotIn('alias', ['uncategorised', 'unused1'])->get();

        foreach ($categories as $key => $value) {

            $section = Section::where('id', $value->parent_id);
            $slug = Str::limit(Str::slug($value->alias, '-'), 50);
            $check = $dbConnect->table('gmbuy_categories')->where('id', $value->parent_id)->whereIn('extension', ['com_content'])
                ->whereNotIn('alias', ['uncategorised', 'unused1'])->count();

            if ($check > 0) {
                Category::create([
                    'id' => $value->id,
                    'section_id' => $section->count() > 0 ? $section->first()->id : $value->parent_id,
                    'parent' => $section->count() > 0 ? 0 : $value->parent_id,
                    'name' => [
                        'id' => $value->title,
                        'en' => $value->title
                    ],
                    'slug' => $slug,
                    'description' => [
                        'id' => $value->description,
                        'en' => $value->description,
                    ],
                    'public' => 1,
                    'is_detail' => 1,
                    'list_view_id' => null,
                    'detail_view_id' => null,
                    'list_limit' => null,
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null,
                    ],
                    'field_category_id' => null,
                    'custom_field' => null,
                    'position' => ($key+1),
                    'created_by' => 1,
                    'updated_by' => 1,
                    // 'created_at' => Carbon::parse($value->created_time)->format('Y-m-d H:i:s'),
                    // 'updated_at' => Carbon::parse($value->modified_time)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function posts($dbConnect)
    {
        $posts = $dbConnect->table('gmbuy_content')->where('catid', 120)->get();
        $sectionId = 2;
        $categoryId = 9;

        foreach ($posts as $key => $value) {
            
            Post::create([
                'id' => $value->id,
                'section_id' => $sectionId,
                'category_id' => $categoryId,
                'title' => [
                    'id' => $value->title,
                    'en' => $value->title,
                ],
                'slug' => Str::replace('...', '', Str::limit(Str::slug($value->alias, '-'), 50)),
                'intro' => [
                    'id' => $value->introtext,
                    'en' => $value->introtext,
                ],
                'content' => [
                    'id' => $value->fulltext,
                    'en' => $value->fulltext,
                ],
                'cover' => [
                    'file_path' => null,
                    'title' => null,
                    'alt' => null
                ],
                'banner' => [
                    'file_path' => null,
                    'title' => null,
                    'alt' => null
                ],
                'publish_year' => Carbon::parse($value->created)->format('Y'),
                'publish_month' => Carbon::parse($value->created)->format('m'),
                'publish' => 1,
                'public' => 1,
                'is_detail' => 1,
                'selection' => 0,
                'meta_data' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null,
                ],
                'position' => ($key+1),
                'viewer' => $value->hits,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::parse($value->created)->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
