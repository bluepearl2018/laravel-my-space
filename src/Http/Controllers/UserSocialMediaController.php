<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use function redirect;
use function view;
use Illuminate\Support\Facades\Auth;
use Eutranet\MySpace\Models\MySpaceUser;
use Eutranet\MySpace\Models\UserSocialMedia;

class UserSocialMediaController extends Controller
{

	public function __construct()
	{
		$this->middleware(['auth']);
		// $this->authorizeResource(App\Models\UserSocialMedia::class);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param MySpaceUser|null $user
	 * @return Application|Factory|View
	 */
	public function index(?MySpaceUser $user): View|Factory|Application
	{
		$userSocialMedias = UserSocialMedia::paginate(10);
		return view('my-space::user-social-medias.index', ['userSocialMedias' => $userSocialMedias, 'user' => $user]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View
	 */
	public function create(): View|Factory|Application
	{
		return view('my-space::user-social-medias.create');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View
	 */
	public function show(): View|Factory|Application
	{
		$userSocialMedias = MySpaceUser::find(Auth::id())->socialMedias()->get();
		return view('my-space::user-social-medias.show', ['userSocialMedias' => $userSocialMedias, 'user' => Auth::user()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$rules = [];
		$request->validate($rules);
		$userSocialMedia = UserSocialMedia::firstOrCreate($request->except('_token'));
		return redirect()->route('admin.users.refresh-selu', ['user_id' => $request->user_id]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View
	 */
	public function edit(): View|Factory|Application
	{
		$userSocialMedias = MySpaceUser::find(Auth::id())->socialMedias()->get();
		return view('my-space::user-social-medias.edit', ['userSocialMedias' => $userSocialMedias, 'user' => Auth::user()]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param MySpaceUser $user
	 * @param UserSocialMedia $userSocialMedia
	 * @return RedirectResponse
	 */
	public function update(Request $request, MySpaceUser $user, UserSocialMedia $userSocialMedia): RedirectResponse
	{
		$userSocialMedia->update($request->except('_token'));
		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param UserSocialMedia $userSocialMedia
	 * @return Application|Factory|View
	 */
	public function destroy(UserSocialMedia $userSocialMedia): View|Factory|Application
	{
		$userSocialMedia->delete();
		return $this->index(NULL);
	}
}
