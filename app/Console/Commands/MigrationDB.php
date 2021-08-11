<?php

namespace App\Console\Commands;

use App\Models\Content\Section;
use App\Models\Master\Tags\Tag;
use App\Services\IndexUrlService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        //tags
        // $tags = $dbConnect->table('gmbuy_categories')->whereIn('extension', ['com_content'])->get();
        // foreach ($tags as $key => $value) {
        //     Tag::create([
        //         'name' => $value->title,
        //         'description' => $value->description,
        //         'flags' => $value->published,
        //         'standar' => 0,
        //         'created_at' => Carbon::parse($value->created_time)->format('Y-m-d H:i:s'),
        //         'updated_at' => Carbon::parse($value->modified_time)->format('Y-m-d H:i:s'),
        //     ]);
        // }

        //section
        $sections = $dbConnect->table('gmbuy_categories')->whereIn('extension', ['com_content'])
            ->whereNotIn('alias', ['uncategorised'])->get();

        foreach ($sections as $key => $value) {
            Section::create([
                'name' => [
                    'id' => $value->title,
                    'en' => $value->title
                ],
                'slug' => $value->alias,
                'description' => [
                    'id' => $value->description,
                    'en' => $value->description,
                ],
                'public' => 1,
                'extra' => null,
                
            ]);
        }
    }
}
