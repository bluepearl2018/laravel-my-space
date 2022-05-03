<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mail;
use Eutranet\Corporate\Models\StaffMember;
use Eutranet\Setup\Models\Email;
use Eutranet\Frontend\Mail\EmailToStaff;
use function view;
use function redirect;

/**
 * The Front email controller is NOT the contact controller
 * This email controller is used within my space (dashboard, etc.)
 * Very strict EMAIL validation rules can be applied if needed
 * Todo test and define applicable validation rules
 */
class UserEmailController extends Controller
{
    /**
     * Make sure the user is logged in and account is verified,
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'has-accepted-my-space-general-terms-on']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User|null $user
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(?User $user): View|Factory|RedirectResponse|Application
    {
        if (Auth::id() === $user->id) {
            return view('my-space::emails.create', ['user' => $user]);
        }
        Flash::error('Operation not allowed');
        return redirect()->route('my-space.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'from' => 'required|exists:users,email',
            'subject' => 'required|min:5|max:120',
            'message_body' => 'required|min:24|max:1024',
            'file_path' => 'nullable|file|mimes:pdf|max:4096',
        ];

        $validated = $request->validate($rules);
        $staffMember = StaffMember::find(1);
        $email = Email::firstOrCreate($validated);
        $email->update(['staff_member_id' => 1, 'to' => $staffMember->email]);
        if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
            $email->addMedia($request->file_path)->toMediaCollection('attachments');
        }

        Mail::send(new EmailToStaff($email, $user, $staffMember));
        Flash::success('Email sent');
        return redirect()->route('my-space.emails.show', [$user, $email]);
    }

    /**
     * Display the specified resource.
     *
     * @param User|null $user
     * @param Email $email
     * @return Application|Factory|View
     */
    public function show(?User $user, Email $email): View|Factory|Application
    {
        $mediaItems = $email->getMedia('attachments');
        return view('my-space::emails.show', ['email' => $email, 'mediaItems' => $mediaItems]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Email $email
     * @return Application|Factory|View
     */
    public function destroy(Email $email): View|Factory|Application
    {
        $email->delete();
        return $this->index(null);
    }

    /**
     * @param User|null $user
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(?User $user): View|Factory|RedirectResponse|Application
    {
        if (Auth::user() === $user) {
            $emails = $user->emails ?? Email::all();
            return view('my-space::emails.index', ['emails' => $emails]);
        }
        Flash::error('You may not display someone else\'s emails.');
        return redirect()->route('my-space.dashboard');
    }
}
