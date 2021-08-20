<?php

namespace App\Console\Commands;

use App\Models\Content\Category;
use App\Models\Content\Post\Post;
use App\Models\Content\Post\PostEvent;
use App\Models\Content\Section;
use App\Models\Document\Document;
use App\Models\Document\DocumentCategory;
use App\Models\Gallery\Album;
use App\Models\Gallery\AlbumCategory;
use App\Models\Gallery\AlbumPhoto;
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
        // $this->berita($dbConnect);
        // $this->siaran($dbConnect);
        // $this->opini($dbConnect);
        // $this->inovasi($dbConnect);
        // $this->press($dbConnect);
        $this->agenda($dbConnect);
        // $this->album($dbConnect);
        // $this->photo($dbConnect);
        // $this->document($dbConnect);
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
    
    public function berita($dbConnect)
    {
        $categoryId = [20, 44, 42, 40, 36, 38, 67, 105, 106];
        $posts = $dbConnect->table('gmbuy_content')->whereIn('catid', $categoryId)->get();
        $sectionId = 1;

        foreach ($posts as $key => $value) {

            if ($value->catid == 20) {
                $categoryId = 1;
            }

            if ($value->catid == 44) {
                $categoryId = 2;
            }

            if ($value->catid == 42) {
                $categoryId = 3;
            }

            if ($value->catid == 40) {
                $categoryId = 4;
            }

            if ($value->catid == 36) {
                $categoryId = 5;
            }

            if ($value->catid == 38) {
                $categoryId = 6;
            }

            if ($value->catid == 67) {
                $categoryId = 7;
            }

            if ($value->catid == 105) {
                $categoryId = 8;
            }

            if ($value->catid == 106) {
                $categoryId = 9;
            }

            $cover = null;
            if (!empty($value->images)) {
                
                $img = json_decode($value->images);
                if (isset($img->image_intro) && !empty($img->image_intro)) {
                    $cover = '/filemanager/'.$img->image_intro;
                } else {
                    $cover = null;
                }
            }

            $checkPost = Post::where('id', $value->id)->count();
            if ($checkPost == 0) {
                Post::create([
                    'id' => $value->id,
                    'section_id' => $sectionId,
                    'category_id' => $categoryId,
                    'title' => [
                        'id' => $value->title,
                        'en' => $value->title,
                    ],
                    'slug' => Str::slug($value->alias, '-'),
                    'intro' => [
                        'id' => $value->introtext,
                        'en' => $value->introtext,
                    ],
                    'content' => [
                        'id' => $value->fulltext,
                        'en' => $value->fulltext,
                    ],
                    'cover' => [
                        'file_path' => $cover,
                        'title' => null,
                        'alt' => null
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish_year' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y') : Carbon::parse($value->created)->format('Y'),
                    'publish_month' => $value->created == '0000-00-00 00:00:00' ? now()->format('m') : Carbon::parse($value->created)->format('m'),
                    'publish' => $value->state == 1 ? 1 : 0,
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
                    'created_at' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function siaran($dbConnect)
    {
        $posts = $dbConnect->table('gmbuy_content')->where('catid', 120)->get();
        $sectionId = 2;
        $categoryId = 10;

        foreach ($posts as $key => $value) {

            $cover = null;
            if (!empty($value->images)) {
                
                $img = json_decode($value->images);
                if (isset($img->image_intro) && !empty($img->image_intro)) {
                    $cover = '/filemanager/'.$img->image_intro;
                } else {
                    $cover = null;
                }
            }

            $checkPost = Post::where('id', $value->id)->count();
            if ($checkPost == 0) {
                Post::create([
                    'id' => $value->id,
                    'section_id' => $sectionId,
                    'category_id' => $categoryId,
                    'title' => [
                        'id' => $value->title,
                        'en' => $value->title,
                    ],
                    'slug' => Str::slug($value->alias, '-'),
                    'intro' => [
                        'id' => $value->introtext,
                        'en' => $value->introtext,
                    ],
                    'content' => [
                        'id' => $value->fulltext,
                        'en' => $value->fulltext,
                    ],
                    'cover' => [
                        'file_path' => $cover,
                        'title' => null,
                        'alt' => null
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish_year' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y') : Carbon::parse($value->created)->format('Y'),
                    'publish_month' => $value->created == '0000-00-00 00:00:00' ? now()->format('m') : Carbon::parse($value->created)->format('m'),
                    'publish' => $value->state == 1 ? 1 : 0,
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
                    'created_at' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function opini($dbConnect)
    {
        $posts = $dbConnect->table('gmbuy_content')->where('catid', 86)->get();
        $sectionId = 3;
        $categoryId = 11;

        foreach ($posts as $key => $value) {

            $cover = null;
            if (!empty($value->images)) {
                
                $img = json_decode($value->images);
                if (isset($img->image_intro) && !empty($img->image_intro)) {
                    $cover = '/filemanager/'.$img->image_intro;
                } else {
                    $cover = null;
                }
            }

            $checkPost = Post::where('id', $value->id)->count();
            if ($checkPost == 0) {
                Post::create([
                    'id' => $value->id,
                    'section_id' => $sectionId,
                    'category_id' => $categoryId,
                    'title' => [
                        'id' => $value->title,
                        'en' => $value->title,
                    ],
                    'slug' => Str::slug($value->alias, '-'),
                    'intro' => [
                        'id' => $value->introtext,
                        'en' => $value->introtext,
                    ],
                    'content' => [
                        'id' => $value->fulltext,
                        'en' => $value->fulltext,
                    ],
                    'cover' => [
                        'file_path' => $cover,
                        'title' => null,
                        'alt' => null
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish_year' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y') : Carbon::parse($value->created)->format('Y'),
                    'publish_month' => $value->created == '0000-00-00 00:00:00' ? now()->format('m') : Carbon::parse($value->created)->format('m'),
                    'publish' => $value->state == 1 ? 1 : 0,
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
                    'created_at' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function inovasi($dbConnect)
    {
        $posts = $dbConnect->table('gmbuy_content')->where('catid', 116)->get();
        $sectionId = 4;
        $categoryId = 12;

        foreach ($posts as $key => $value) {

            $cover = null;
            if (!empty($value->images)) {
                
                $img = json_decode($value->images);
                if (isset($img->image_intro) && !empty($img->image_intro)) {
                    $cover = '/filemanager/'.$img->image_intro;
                } else {
                    $cover = null;
                }
            }

            $checkPost = Post::where('id', $value->id)->count();
            if ($checkPost == 0) {
                Post::create([
                    'id' => $value->id,
                    'section_id' => $sectionId,
                    'category_id' => $categoryId,
                    'title' => [
                        'id' => $value->title,
                        'en' => $value->title,
                    ],
                    'slug' => Str::slug($value->alias, '-'),
                    'intro' => [
                        'id' => $value->introtext,
                        'en' => $value->introtext,
                    ],
                    'content' => [
                        'id' => $value->fulltext,
                        'en' => $value->fulltext,
                    ],
                    'cover' => [
                        'file_path' => $cover,
                        'title' => null,
                        'alt' => null
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish_year' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y') : Carbon::parse($value->created)->format('Y'),
                    'publish_month' => $value->created == '0000-00-00 00:00:00' ? now()->format('m') : Carbon::parse($value->created)->format('m'),
                    'publish' => $value->state == 1 ? 1 : 0,
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
                    'created_at' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function press($dbConnect)
    {
        $categoryId = [93, 94, 95, 96, 100];
        $posts = $dbConnect->table('gmbuy_content')->whereIn('catid', $categoryId)->get();
        $sectionId = 5;

        foreach ($posts as $key => $value) {

            if ($value->catid == 93) {
                $categoryId = 13;
            }

            if ($value->catid == 94) {
                $categoryId = 14;
            }

            if ($value->catid == 95) {
                $categoryId = 15;
            }

            if ($value->catid == 96) {
                $categoryId = 16;
            }

            if ($value->catid == 100) {
                $categoryId = 17;
            }

            $cover = null;
            if (!empty($value->images)) {
                
                $img = json_decode($value->images);
                if (isset($img->image_intro) && !empty($img->image_intro)) {
                    $cover = '/filemanager/'.$img->image_intro;
                } else {
                    $cover = null;
                }
            }

            $checkPost = Post::where('id', $value->id)->count();
            if ($checkPost == 0) {
                Post::create([
                    'id' => $value->id,
                    'section_id' => $sectionId,
                    'category_id' => $categoryId,
                    'title' => [
                        'id' => $value->title,
                        'en' => $value->title,
                    ],
                    'slug' => Str::slug($value->alias, '-'),
                    'intro' => [
                        'id' => $value->introtext,
                        'en' => $value->introtext,
                    ],
                    'content' => [
                        'id' => $value->fulltext,
                        'en' => $value->fulltext,
                    ],
                    'cover' => [
                        'file_path' => $cover,
                        'title' => null,
                        'alt' => null
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish_year' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y') : Carbon::parse($value->created)->format('Y'),
                    'publish_month' => $value->created == '0000-00-00 00:00:00' ? now()->format('m') : Carbon::parse($value->created)->format('m'),
                    'publish' => $value->state == 1 ? 1 : 0,
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
                    'created_at' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function agenda($dbConnect)
    {
        $agenda = $dbConnect->table('gmbuy_dpcalendar_events')->where('catid', 124)->get();
        $sectionId = 6;
        $categoryId = 18;

        foreach ($agenda as $key => $value) {

            $cover = null;
            if (!empty($value->images)) {
                
                $img = json_decode($value->images);
                if (isset($img->image_intro) && !empty($img->image_intro)) {
                    $cover = '/filemanager/'.$img->image_intro;
                } else {
                    $cover = null;
                }
            }

            $slug = Str::slug($value->alias, '-');

            $checkPost = Post::where('id', $value->id)->where('slug', $slug)->count();
            if ($checkPost == 0) {
                $post = Post::create([
                    'section_id' => $sectionId,
                    'category_id' => $categoryId,
                    'title' => [
                        'id' => $value->title,
                        'en' => $value->title,
                    ],
                    'slug' => $slug,
                    'intro' => [
                        'id' => null,
                        'en' => null,
                    ],
                    'content' => [
                        'id' => null,
                        'en' => null,
                    ],
                    'cover' => [
                        'file_path' => $cover,
                        'title' => null,
                        'alt' => null
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish_year' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y') : Carbon::parse($value->created)->format('Y'),
                    'publish_month' => $value->created == '0000-00-00 00:00:00' ? now()->format('m') : Carbon::parse($value->created)->format('m'),
                    'publish' => $value->state == 1 ? 1 : 0,
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
                    'created_at' => $value->created == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created)->format('Y-m-d H:i:s'),
                ]);

                $event = PostEvent::create([
                    'post_id' => $post->id,
                    'start_date' => $value->start_date == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->start_date)->format('Y-m-d H:i:s'),
                    'end_date' => $value->end_date == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->end_date)->format('Y-m-d H:i:s'),
                    'location' => null,
                ]);
            }

        }
    }

    public function album($dbConnect)
    {
        $categories = $dbConnect->table('gmbuy_bwg_album')->get();
        foreach ($categories as $key => $value) {
           
            AlbumCategory::create([
                'id' => $value->id,
                'name' => [
                    'id' => $value->name,
                    'en' => $value->name,
                ],
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'slug' => Str::slug($value->name, '-'),
                'position' => ($key+1),
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        $albums = $dbConnect->table('gmbuy_bwg_album_gallery')->whereIn('album_id', [1, 4])->get();
        foreach ($albums as $key => $value) {
            
            $alb = $dbConnect->table('gmbuy_bwg_gallery')->where('id', $value->alb_gal_id)->first();

            $checkAlbum = Album::where('id', $value->alb_gal_id)->count();

            if ($checkAlbum == 0) {
                Album::create([
                    'id' => $value->alb_gal_id,
                    'category_id' => $value->album_id,
                    'name' => [
                        'id' => $alb->name,
                        'en' => $alb->name,
                    ],
                    'slug' => Str::slug($alb->name, '-'),
                    'description' => [
                        'id' => $alb->description,
                        'en' => $alb->description,
                    ],
                    'banner' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null
                    ],
                    'publish' => $alb->published,
                    'photo_limit' => null,
                    'is_detail' => 1,
                    'position' => $alb->order,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function photo($dbConnect)
    {
        $photos = $dbConnect->table('gmbuy_bwg_image')->get();

        foreach ($photos as $key => $value) {
            
            $checkAlbum =  Album::where('id', $value->gallery_id)->count();

            if ($checkAlbum > 0) {
                
                AlbumPhoto::create([
                    'id' => $value->id,
                    'album_id' => $value->gallery_id,
                    'file' => $value->image_url,
                    'file_type' => $value->filetype,
                    'file_size' => 0,
                    'title' => [
                        'id' => null,
                        'en' => null,
                    ],
                    'description' => [
                        'id' => $value->description,
                        'en' => $value->description,
                    ],
                    'alt' => $value->alt,
                    'publish' => $value->published,
                    'position' => $value->order,
                    'flags' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function document($dbConnect)
    {
        $categories = $dbConnect->table('gmbuy_edocman_categories')->get();
        foreach ($categories as $key => $value) {
            
            DocumentCategory::create([
                'id' => $value->id,
                'parent' => $value->parent_id,
                'name' => [
                    'id' => $value->title,
                    'en' => $value->title,
                ],
                'slug' => Str::slug($value->alias),
                'description' => [
                    'id' => $value->description,
                    'en' => $value->description,
                ],
                'publish' => $value->published == 1 ? 1 : 0,
                'public' => 1,
                'banner' => [
                    'file_path' => null,
                    'title' => null,
                    'alt' => null,
                ],
                'position' => $value->ordering,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $value->created_time == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($value->created_time)->format('Y-m-d H:i:s'),
            ]);
        }

        $catDoc = $dbConnect->table('gmbuy_edocman_document_category')->get();
        foreach ($catDoc as $key => $value) {
            
            $doc = $dbConnect->table('gmbuy_edocman_documents')->where('id', $value->document_id)->first();
            $checkDoc = Document::where('id', $value->document_id)->count();

            if (!empty($doc) && $checkDoc == 0) {
                
                Document::create([
                    'id' => $doc->id,
                    'category_id' => $value->category_id,
                    'title' => [
                        'id' => $doc->title,
                        'en' => $doc->title,
                    ],
                    'slug' => Str::slug($doc->alias),
                    'description' => [
                        'id' => $doc->description,
                        'en' => $doc->description,
                    ],
                    'from' => !empty($doc->filename) ? 0 : 1,
                    'file' => $doc->filename,
                    'file_type' => null,
                    'file_size' => 0,
                    'document_url' => $doc->document_url,
                    'cover' => [
                        'file_path' => null,
                        'title' => null,
                        'alt' => null,
                    ],
                    'publish' => $doc->published == 1 ? 1 : 0,
                    'public' => 1,
                    'position' => $doc->ordering,
                    'download' => $doc->downloads,
                    'viewer' => $doc->hits,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => $doc->created_time == '0000-00-00 00:00:00' ? now()->format('Y-m-d H:i:s') : Carbon::parse($doc->created_time)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
