<?php

namespace App\Http\Middleware;

use App\Models\Configuration;
use App\Models\Inquiry\InquiryForm;
use App\Models\Language;
use App\Models\Menu\MenuCategory;
use App\Models\Page\Page;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PassingDataToView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        View::share([
            'bg' => [
                'login' => config('custom.files.banner_login.file'),
            ],
            'counter' => [
                'inquiry_form' => InquiryForm::where('status', 0)->count(),
            ],
            'config' => [
                //group 1
                'logo' => Configuration::file('logo',),
                'logo_2' => Configuration::file('logo_2'),
                'logo_small' => Configuration::file('logo_small'),
                'logo_small_2' => Configuration::file('logo_small_2'),
                'logo_mail' => Configuration::file('logo_mail'),
                'open_graph' => Configuration::file('open_graph'),
                'banner_default' => Configuration::file('banner_default'),
                //group 2
                'website_name' => Configuration::value('website_name'),
                'website_description' => Configuration::value('website_description'),
                'address' => Configuration::value('address'),
                'email' => Configuration::value('email'),
                'email_2' => Configuration::value('email_2'),
                'fax' => Configuration::value('fax'),
                'phone' => Configuration::value('phone'),
                'phone_2' => Configuration::value('phone_2'),
                'phone_whatsapp' => Configuration::value('phone_whatsapp'),
                //group 3
                'meta_title' => Configuration::value('meta_title') ?? 
                    Configuration::value('website_name'),
                'meta_description' => Configuration::value('meta_description'),
                'meta_keywords' => Configuration::value('meta_keywords'),
                'google_analytics' => Configuration::value('google_analytics'),
                'google_verification' => Configuration::value('google_verification'),
                'domain_verification' => Configuration::value('domain_verification'),
                //group 4
                'twitter' => Configuration::value('twitter'),
                'youtube' => Configuration::value('youtube'),
                'facebook' => Configuration::value('facebook'),
                'linkedin' => Configuration::value('linkedin'),
                'whatsapp' => Configuration::value('whatsapp'),
                'app_store' => Configuration::value('app_store'),
                'instagram' => Configuration::value('instagram'),
                'pinterest' => Configuration::value('pinterest'),
                'youtube_id' => Configuration::value('youtube_id'),
                'website' => Configuration::value('website'),
                'google_play_store' => Configuration::value('google_play_store'),
            ],
            'languages' => Language::active()->get(),
            'menu' => [
                'header' => MenuCategory::find(1),
            ],
            'linkModule' => [
                'bidang' => Page::where('id', 3)->publish()->first(),
            ],
        ]);

        return $next($request);
    }
}
