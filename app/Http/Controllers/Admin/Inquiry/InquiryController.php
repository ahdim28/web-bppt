<?php

namespace App\Http\Controllers\Admin\Inquiry;

use App\Exports\InquiryFormExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inquiry\InquiryRequest;
use App\Services\Inquiry\InquiryService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InquiryController extends Controller
{
    private $service, $serviceLang, $serviceField, $notif;

    public function __construct(
        InquiryService $service,
        LanguageService $serviceLang,
        FieldCategoryService $serviceField,
        NotificationService $notif
    )
    {
        $this->service = $service;
        $this->serviceLang = $serviceLang;
        $this->serviceField = $serviceField;
        $this->notif = $notif;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['inquiries'] = $this->service->getInquiryList($request);
        $data['no'] = $data['inquiries']->firstItem();
        $data['inquiries']->withPath(url()->current().$param);

        return view('backend.inquiries.index', compact('data'), [
            'title' => 'Inquiries',
            'breadcrumbs' => [
                'Inquiries' => '',
            ]
        ]);
    }

    public function detail(Request $request, $id)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['forms'] = $this->service->getFormList($request, $id);
        $data['no'] = $data['forms']->firstItem();
        $data['forms']->withPath(url()->current().$param);
        $data['inquiry'] = $this->service->find($id);

        if ($request->notif_id != '') {
            $this->notif->read(auth()->user()->id, $request->notif_id);
        }

        return view('backend.inquiries.forms.detail', compact('data'), [
            'title' => 'Inquiry - Form',
            'routeBack' => route('inquiry.index'),
            'breadcrumbs' => [
                'Inquiry' => route('inquiry.index'),
                'Form' => ''
            ]
        ]);
    }

    public function create()
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.inquiries.form', compact('data'), [
            'title' => 'Add New Inquiry',
            'routeBack' => route('inquiry.index'),
            'breadcrumbs' => [
                'Inquiry' => route('inquiry.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(InquiryRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'inquiry successfully added');
    }

    public function edit($id)
    {
        $data['inquiry'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.inquiries.form-edit', compact('data'), [
            'title' => 'Edit Inquiry',
            'routeBack' => route('inquiry.index'),
            'breadcrumbs' => [
                'Inquiry' => route('inquiry.index'),
                'Edit' => '',
            ],
        ]);
    }

    public function update(InquiryRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'inquiry successfully updated');
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', 'status inquiry changed');
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position inquiry changed');
    }

    public function statusForm($inquiryId, $id)
    {
        $this->service->statusForm($id, 1);
        
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function exportForm(Request $request, $id)
    {
        $inquiry = $this->service->find($id);
        $form = $this->service->exportForm($request, $id);

        if ($form->count() == 0) {
            return back()->with('warning', 'data is empty');
        }

        $export = Excel::download(new InquiryFormExport($inquiry, $form), $inquiry->slug.'.xlsx');

        $update = $inquiry->forms()->where('exported', 0)->update([
            'exported' => 1
        ]);

        return $export;
    }

    public function destroy($id)
    {
        $delete = $this->service->delete($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Cannot delete inquiry, Because this inquiry still has form / field',
            ], 200);
        }
    }

    public function destroyForm($inquiryId, $id)
    {
        $this->service->deleteForm($id);
        
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('inquiry.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
