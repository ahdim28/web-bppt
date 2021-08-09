<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ProfilePhotoRequest;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Users\UserRequest;
use App\Mail\VerificationMail;
use App\Services\Users\ACL\RoleService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $service, $serviceRole;

    public function __construct(
        UserService $service,
        RoleService $serviceRole
    )
    {
        $this->service = $service;
        $this->serviceRole = $serviceRole;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['users'] = $this->service->getUserList($request);
        $data['no'] = $data['users']->firstItem();
        $data['users']->withPath(url()->current().$param);
        $data['roles'] = $this->serviceRole->getRoleByUser();

        return view('backend.users.index', compact('data'), [
            'title' => __('mod/users.user.title'),
            'breadcrumbs' => [
                __('mod/users.user.title') => '',
            ]
        ]);
    }

    public function trash(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['users'] = $this->service->getUserList($request, true);
        $data['no'] = $data['users']->firstItem();
        $data['users']->withPath(url()->current().$param);
        $data['roles'] = $this->serviceRole->getRoleByUser();

        return view('backend.users.trash', compact('data'), [
            'title' => __('mod/users.user.caption').' '.__('lang.trash'),
            'routeBack' => route('user.index'),
            'breadcrumbs' => [
                __('mod/users.user.title') => route('user.index'),
                __('lang.trash') => '',
            ]
        ]);
    }

    public function log(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['logs'] = $this->service->getLog($request);
        $data['no'] = $data['logs']->firstItem();
        $data['logs']->withPath(url()->current().$param);

        return view('backend.users.log-all', compact('data'), [
            'title' => __('mod/users.user.log.title'),
            'breadcrumbs' => [
                __('mod/users.user.log.title') => '',
            ]
        ]);
    }

    public function logByUser(Request $request, $userId)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['logs'] = $this->service->getLog($request, $userId);
        $data['no'] = $data['logs']->firstItem();
        $data['logs']->withPath(url()->current().$param);
        $data['user'] = $this->service->find($userId);

        if ($data['user']->roles[0]->id < Auth::user()->roles[0]->id) {
            return abort(403);
        }

        return view('backend.users.log', compact('data'), [
            'title' => __('mod/users.user.log.caption'),
            'routeBack' => route('user.index'),
            'breadcrumbs' => [
                __('mod/users.user.title') => route('user.index'),
                __('mod/users.user.log.caption') => '',
            ]
        ]);
    }

    public function create()
    {
        $data['roles'] = $this->serviceRole->getRoleByUser(false);

        return view('backend.users.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/users.user.caption')
            ]),
            'routeBack' => route('user.index'),
            'breadcrumbs' => [
                __('mod/users.user.caption') => route('user.index'),
                __('lang.add') => '',
            ]
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->service->store($request, $request->roles, true, false);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/users.user.caption')
        ]));
    }

    public function edit($id)
    {
        $data['user'] = $this->service->find($id);
        $data['roles'] = $this->serviceRole->getRoleByUser(false);

        if (($data['user']->roles[0]->id <= Auth::user()->roles[0]->id ) || 
            ($id == Auth::user()->id)) {
            return abort(403);
        }

        return view('backend.users.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/users.user.caption')
            ]),
            'routeBack' => route('user.index'),
            'breadcrumbs' => [
                __('mod/users.user.caption') => route('user.index'),
                __('lang.edit') => '',
            ]
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/users.user.caption')
        ]));
    }

    public function activate($id)
    {
        $this->service->activate($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/users.user.caption')
        ]));
    }

    public function softDelete($id)
    {
        $delete = $this->service->trash($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => __('alert.delete_failed_used', [
                    'attribute' => __('mod/users.user.caption')
                ])
            ], 200);

        }
    }

    public function permanentDelete(Request $request, $id)
    {
        $delete = $this->service->delete($request, $id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => __('alert.delete_failed_used', [
                    'attribute' => __('mod/users.user.caption')
                ])
            ], 200);

        }
    }

    public function restore($id)
    {
        $this->service->restore($id);

        return back()->with('success', __('alert.restore_success', [
            'attribute' => __('mod/users.user.caption')
        ]));
    }

    public function logDelete($id)
    {
        $this->service->logDelete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('user.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }

    /**
     * profile
     */
    public function profile()
    {
        $data['user'] = $this->service->find(Auth::user()->id);

        return view('backend.users.profile.index', compact('data'), [
            'title' => __('mod/users.user.profile.title'),
            'breadcrumbs' => [
                __('mod/users.user.profile.title') => 'javascript:;',
                '#'.$data['user']->name => '',
            ],
        ]);
    }

    public function updateProfile(ProfileRequest $request)
    {
        if (!empty($request->old_password) && !Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with('warning', __('mod/users.user.alert.warning_password'));
        }

        $this->service->updateProfile($request, Auth::user()->id);

        if (!empty($request->old_password) && Hash::check($request->old_password, Auth::user()->password)) { 
            if (Auth::attempt([
                'email' => Auth::user()->email,
                'password' => $request->password
            ])) {
                return back()->with('success', __('mod/users.user.alert.success_password'));
            }
        }

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/users.user.profile.title')
        ]));
    }

    public function sendMailVerification()
    {
        if (config('custom.notification.email.verification') == true) {
            $encrypt = Crypt::encrypt(Auth::user()->email);
            $data = [
                'title' => __('mod/users.user.verification.title'),
                'email' => Auth::user()->email,
                'link' => route('profile.mail.verification', ['email' => $encrypt]),
            ];

            Mail::to(Auth::user()->email)->send(new VerificationMail($data));

            return back()->with('info', __('mod/users.user.alert.info_verification'));
        } else {
            return back()->with('warning', __('mod/users.user.alert.warning_verification'));
        }
    }

    public function verified($email)
    {
        $this->service->verificationEmail($email);

        return redirect()->route('profile')->with('success', 
            __('mod/users.user.profile.alert.success_verification'));
    }

    public function changePhoto(ProfilePhotoRequest $request)
    {
        $this->service->changePhoto($request, Auth::user()->id);

        return back()->with('success', 
            __('mod/users.user.alert.success_photo'));
    }

    public function removePhoto()
    {
        $this->service->removePhoto(Auth::user()->id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
