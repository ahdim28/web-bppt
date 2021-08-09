<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationUploadRequest;
use App\Services\ConfigurationService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Spatie\Analytics\Period;
use Analytics;
use App\Services\BackupService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{
    private $service, $serviceBackup, $serviceLang;

    public function __construct(
        ConfigurationService $service,
        BackupService $serviceBackup,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceBackup = $serviceBackup;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

     /**
     * extras
     */
    public function visitor(Request $request)
    {
        if (!empty(env('ANALYTICS_VIEW_ID'))) {

            if ($request->f == 'today') {

                $start = now()->today();
                $end = now()->today();
                $periode = Period::create($start, $end);
    
            } elseif ($request->f == 'current-week') {

                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $periode = Period::create($start, $end);
    
            } elseif ($request->f == 'latest-week') {

                $start = now()->subWeek()->startOfWeek();
                $end = now()->subWeek()->endOfWeek();
                $periode = Period::create($start, $end);
    
            } elseif ($request->f == 'current-month') {

                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $periode = Period::create($start, $end);

    
            } elseif ($request->f == 'latest-month') {

                $start = now()->parse('-1 months')->startOfMonth();
                $end = now()->parse('-1 months')->endOfMonth();
                $periode = Period::create($start, $end);
                
    
            } elseif ($request->f == 'current-year') {

                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $periode = Period::create($start, $end);
                
    
            } elseif ($request->f == 'latest-year') {

                $start = now()->parse('-1 years')->startOfYear();
                $end = now()->parse('-1 years')->endOfYear();
                $periode = Period::create($start, $end);
                
            } else {
                $periode = Period::days(7);
            }

            $data['total'] = Analytics::fetchTotalVisitorsAndPageViews($periode);
            $data['n_visitor'] = Analytics::fetchUserTypes($periode);
            $data['browser'] = Analytics::fetchTopBrowsers($periode);
            $data['refe'] = Analytics::fetchTopReferrers($periode);
            $data['top'] = Analytics::fetchMostVisitedPages($periode);
            $data['vp'] = Analytics::fetchVisitorsAndPageViews($periode);
            $data['aa'] = Analytics::performQuery(Period::years(1),
            'ga:sessions', [
                'metrics' => 'ga:sessions, ga:pageviews',
                'dimensions' => 'ga:yearMonth'
            ]);

            //session
            $sessionLabel = [];
            $sessionTotal = [];
            foreach ($data['n_visitor'] as $key => $value) {
                $sessionLabel[$key] = $value['type'];
                $sessionTotal[$key] = $value['sessions'];
            }

            $data['session_visitor'] = [
                'label' => $sessionLabel,
                'total' => $sessionTotal
            ];

            //browser
            $browserLabel = [];
            $browserTotal = [];
            foreach ($data['browser'] as $key => $value) {
                $browserLabel[$key] = $value['browser'];
                $browserTotal[$key] = $value['sessions'];
            }

            $data['browser_visitor'] = [
                'label' => $browserLabel,
                'total' => $browserTotal
            ];

            //visitor total
            $visitorLabel = [];
            $visitorTotal = [];
            foreach ($data['total'] as $key => $value) {
                $visitorLabel[$key] = Carbon::parse($value['date'])->format('d F Y');
                $visitorTotal[$key] = $value['visitors'];
            }

            $data['total_visitor'] = [
                'label' => $visitorLabel,
                'total' => $visitorTotal
            ];

        } else {
            $data['visitor'] = '';
        }

        return view('backend.configurations.visitor', compact('data'), [
            'title' => __('mod/setting.visitor.title'),
            'breadcrumbs' => [
                __('mod/setting.visitor.title') => ''
            ],
        ]);
    }

    public function filemanager()
    {
        return view('backend.configurations.filemanager', [
            'title' => __('mod/setting.filemanager.title'),
            'breadcrumbs' => [
                __('mod/setting.filemanager.title') => '',
            ],
        ]);
    }

    public function backup(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['backups'] = $this->serviceBackup->getBackupList($request);
        $data['no'] = $data['backups']->firstItem();
        $data['backups']->withPath(url()->current().$param);

        return view('backend.configurations.backup', compact('data'), [
            'title' => __('mod/setting.backup.title'),
            'breadcrumbs' => [
                __('mod/setting.backup.title') => '',
            ],
        ]);
    }

    public function backupDownload($id)
    {
        $backup = $this->serviceBackup->find($id);

        return Storage::download($backup->file_path);
    }

    /**
     * configuration
     */
    public function website(Request $request)
    {
        $data['upload'] = $this->service->getConfigIsUpload();
        $data['general'] = $this->service->getConfig(2);
        $data['meta_data'] = $this->service->getConfig(3);
        $data['social_media'] = $this->service->getConfig(4);

        return view('backend.configurations.website', compact('data'), [
            'title' => __('mod/setting.config.caption').' - '.__('mod/setting.config.caption_web'),
            'breadcrumbs' => [
                __('mod/setting.config.caption') => 'javascript:;',
                __('mod/setting.config.caption_web') => ''
            ],
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->name as $key => $value) {
            $this->service->updateConfig($key, $value);
        }

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/setting.config.caption')
        ]));
    }

    public function upload(ConfigurationUploadRequest $request, $name)
    {
        $this->service->uploadFile($request, $name);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/setting.config.caption')
        ]));
    }

    public function common(Request $request, $lang)
    {
        if ($request->has('lang')) {
            $data = "<?php \n\nreturn [\n";
            foreach ($request->lang as $key => $value) {
                $data .= "\t'$key' => '$value',\n";
            }
            $data .= "];";
            File::put(base_path('resources/lang/'.$lang.'/common.php'), $data);
            return back()->with('success', __('alert.update_success', [
                'attribute' => __('mod/setting.config.caption_common')
            ]));
        }

        $data['files'] = Lang::get('common', [], $lang);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['country'] = $this->serviceLang->findByIsoCode($lang);

        return view('backend.configurations.common', compact('data'), [
            'title' => __('mod/setting.config.caption').' - '.__('mod/setting.config.caption_common'),
            'breadcrumbs' => [
                __('mod/setting.config.caption') => 'javascript:;',
                __('mod/setting.config.caption_common') => ''
            ],
        ]);
    }

    public function maintenance(Request $request)
    {
        if ($request->input()) {
            $data = "<?php \n\nreturn [\n";
            if ($request->mode == 1) {
                $data .= "\t 'mode' => TRUE,\n";
            } else {
                $data .= "\t 'mode' => FALSE,\n";
            }
            $data .= "];";
            File::put(base_path('config/custom/maintenance.php'), $data);
            return back()->with('success', __('alert.update_success', [
                'attribute' => __('mod/setting.maintenance.title')
            ]));

        }

        $data['maintenance'] = config('custom.maintenance');

        return view('backend.configurations.maintenance', compact('data'), [
            'title' => __('mod/setting.maintenance.title'),
            'breadcrumbs' => [
                __('mod/setting.maintenance.title') => ''
            ],
        ]);
    }
}
