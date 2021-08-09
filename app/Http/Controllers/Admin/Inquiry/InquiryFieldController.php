<?php

namespace App\Http\Controllers\Admin\Inquiry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inquiry\InquiryFieldRequest;
use App\Services\Inquiry\InquiryFieldService;
use App\Services\Inquiry\InquiryService;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class InquiryFieldController extends Controller
{
    private $service, $serviceInquiry, $serviceLang;

    public function __construct(
        InquiryFieldService $service,
        InquiryService $serviceInquiry,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceInquiry = $serviceInquiry;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $inquiryId)
    {
        $data['fields'] = $this->service->getFieldList($request, $inquiryId);
        $data['inquiry'] = $this->serviceInquiry->find($inquiryId);

        return view('backend.inquiries.fields.index', compact('data'), [
            'title' => 'Inquiry - Field',
            'routeBack' => route('inquiry.index'),
            'breadcrumbs' => [
                'Inquiry' => route('inquiry.index'),
                'Field' => ''
            ]
        ]);
    }

    public function create($inquiryId)
    {
        $data['inquiry'] = $this->serviceInquiry->find($inquiryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.inquiries.fields.form', compact('data'), [
            'title' => 'Add New Field',
            'routeBack' => route('inquiry.field.index', ['inquiryId' => $inquiryId]),
            'breadcrumbs' => [
                'Inquiry' => route('inquiry.index'),
                'Field' => route('inquiry.field.index', ['inquiryId' => $inquiryId]),
                'Add' => ''
            ]
        ]);
    }

    public function store(InquiryFieldRequest $request, $inquiryId)
    {
        $this->service->store($request, $inquiryId);

        $redir = $this->redirectForm($request, $inquiryId);
        return $redir->with('success', 'inquiry field successfully added');
    }

    public function edit($inquiryId, $id)
    {
        $data['field'] = $this->service->find($id);
        $data['inquiry'] = $this->serviceInquiry->find($inquiryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.inquiries.fields.form-edit', compact('data'), [
            'title' => 'Edit Field',
            'routeBack' => route('inquiry.field.index', ['inquiryId' => $inquiryId]),
            'breadcrumbs' => [
                'Inquiry' => route('inquiry.index'),
                'Field' => route('inquiry.field.index', ['inquiryId' => $inquiryId]),
                'Edit' => ''
            ]
        ]);
    }

    public function update(InquiryFieldRequest $request, $inquiryId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $inquiryId);
        return $redir->with('success', 'inquiry field successfully updated');
    }

    public function position($inquiryId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position inquiry field changed');
    }

    public function destroy($inquiryId, $id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $inquiryId)
    {
        $redir = redirect()->route('inquiry.field.index', ['inquiryId' => $inquiryId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
