<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inquiry\InquiryFormRequest;
use App\Services\ConfigurationService;
use App\Services\Inquiry\InquiryService;
use App\Services\NotificationService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InquiryViewController extends Controller
{
    private $service, $config, $notif, $user;

    public function __construct(
        InquiryService $service,
        ConfigurationService $config,
        NotificationService $notif,
        UserService $user
    )
    {
        $this->service = $service;
        $this->config = $config;
        $this->notif = $notif;
        $this->user = $user;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');

        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['inquiries'] = $this->service->getInquiry($request, 'paginate', $limit);

        return view('frontend.inquiries.list', compact('data'), [
            'title' => 'Inquiries',
            'breadcrumbs' => [
                'Inquiries' => '',
            ],
        ]);
    }

    public function read(Request $request)
    {
        $slug = $request->route('slug');
        
        $data['read'] = $this->service->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        $this->service->recordViewer($data['read']->id);

        //data
        $data['inquiry_fields'] = $data['read']->inquiryField()->orderBy('position', 'ASC')->get();
        $data['fields'] = $data['read']->custom_field;

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = Str::limit(strip_tags($data['read']->meta_data['title']), 69);
        }

        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && 
            !empty($data['read']->fieldLang('body'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('body')), 155);
        } elseif (empty($data['read']->meta_data['description']) && 
            empty($data['read']->fieldLang('body')) && !empty($data['read']->fieldLang('body'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('body')), 155);
        }

        $data['meta_keywords'] = $this->config->getValue('meta_keywords');
        if (!empty($data['read']->meta_data['keywords'])) {
            $data['meta_keywords'] = $data['read']->meta_data['keywords'];
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        return view('frontend.inquiries.'.$slug, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                $data['read']->fieldLang('name') => ''
            ]
        ]);
    }

    public function submitForm(InquiryFormRequest $request, $id)
    {
        $inquiry = $this->service->find($id);

        $data = [
            'title' => $inquiry->fieldLang('name'),
            'inquiry' => $inquiry,
            'request' => $request->all(),
        ];

        $this->service->submitForm($request, $id);
        
        
        if (config('custom.notification.email.inquiry') == true && !empty($inquiry->email)) {
            $mail = $this->user->getUserActive([1,2,3], true)->pluck('email')->toArray();
            Mail::to($mail)->send(new \App\Mail\InquiryFormMail($data));
        }

        if (config('custom.notification.app.inquiry') == true) {
            $user = $this->user->getUserActive([1,2,3], false)->pluck('id')->toArray();
            $this->notif->send(null, $user, [
                'icon' => 'las la-envelope',
                'color' => 'success',
                'title' => 'New Message From '.$inquiry->fieldLang('name'),
                'content' => $request->message,
            ], 'admin/inquiry/'.$id.'/detail?q='.$request->email.'&');
        }

        Cookie::queue($inquiry->slug, $inquiry->fieldLang('name'), 120);

        $message = 'Send message successfully';
        if (!empty($inquiry->fieldLang('after_body'))) {
            $message = strip_tags($inquiry->fieldLang('after_body'));
        }

        return back()->with('success', $message);
    }
}
