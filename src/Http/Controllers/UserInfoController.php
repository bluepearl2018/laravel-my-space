<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Session;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use function redirect;
use function view;
use Eutranet\MySpace\Models\UserInfo;

class UserInfoController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param User|null $user
	 * @return Application|Factory|View
	 */
	public function index(?User $user): View|Factory|Application
	{
		$userInfos = UserInfo::all();
		if ($user) {
			$userInfos = $user->userInfos ?? $userInfos;
		}
		return view('my-space::user-infos.index',
			[
				'userInfos' => $userInfos,
				'user' => $user
			]
		);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View
	 */
	public function create(): View|Factory|Application
	{
		$selu = Session::get('users.selectedUser');
		$aResource = NULL;
		$bResource = NULL;
		if (isset($selu)) {
			$aResource = UserInfo::where('user_id', $selu->id)->where('a_or_b', 'a')->get()->first();
			$bResource = UserInfo::where('user_id', $selu->id)->where('a_or_b', 'b')->get()->first();
			return view('my-space::user-infos.create', [
				'aResource' => $aResource,
				'bResource' => $bResource
			]);
		}
		return view('back.user-infos.create', ['aResource' => $aResource, 'bResource' => $bResource]);
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
			'user_id' => 'exists:users,id',
			'gender_id' => 'nullable|exists:genders,id',
			'appellative_id' => 'nullable|exists:appellatives,id',
			'first_name' => 'nullable|max:50',
			'last_name' => 'nullable|max:50',
			'date_of_birth' => 'nullable|date_format:Y-m-d|before:105 years ago|nullable',
			'function' => 'nullable|max:255',
			'lead' => 'nullable',
			'resume' => 'nullable',
			'address1' => 'nullable|max:38',
			'address2' => 'nullable|max:38',
			'postal_code' => 'nullable|max:12',
			'city' => 'nullable|max:50',
			'council' => 'nullable|max:50',
			'district' => 'nullable|max:50',
			'country_id' => 'nullable|exists:countries,id|numeric',
			'phone' => 'nullable', // |regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:16
			'mobile' => 'nullable', // |regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:16
			'email_private' => 'nullable|email:rfc,dns,strict,filter',
			'staff_id' => 'exists:staffs,id',
			'a_or_b' => 'in:a,b',
		];
		$request->validate($rules);
		$newUserInfo = [
			'user_id' => $request->user_id,
			'staff_id' => $request->staff_id,
//			'country_id' => $request->a_or_b === 'a' ? $user->country_id : $request->country_id ?? NULL
		];

		$userInfo = UserInfo::firstOrCreate($newUserInfo);
		return redirect()->route('admin.users.user-infos.index', $user);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param User|null $user
	 * @param UserInfo $userInfo
	 * @return Application|Factory|View
	 */
	public function show(?User $user, UserInfo $userInfo): Application|Factory|View
	{
		$qcs = [];
		$qcs['nif'] = $user->nif;
		return view('my-space::user-infos.show', ['user' => $userInfo->user, 'userInfo' => $userInfo, 'qcs' => $qcs]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param User|null $user
	 * @param UserInfo $userInfo
	 * @return Application|Factory|View
	 */
	public function edit(?User $user, UserInfo $userInfo): View|Factory|Application
	{
		return view('my-space::user-infos.show', ['userInfo' => $userInfo]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param User $user
	 * @param UserInfo $userInfo
	 * @return RedirectResponse
	 */
	public function update(Request $request, User $user, UserInfo $userInfo): RedirectResponse
	{
		$rules = [
			// The dns and spoof validators require the PHP intl extension.
			'user_id' => 'exists:users,id',
			'gender_id' => 'nullable|exists:genders,id',
			'appellative_id' => 'nullable|exists:appellatives,id',
			'first_name' => 'nullable|max:50',
			'last_name' => 'nullable|max:50',
			'date_of_birth' => 'nullable|date_format:Y-m-d|before:16 years ago|nullable',
			'function' => 'nullable|max:255',
			'lead' => 'nullable',
			'resume' => 'nullable',
			'address1' => 'nullable|max:38',
			'address2' => 'nullable|max:38',
			'postal_code' => 'nullable|max:12',
			'city' => 'nullable|max:50',
			'council' => 'nullable|max:50',
			'district' => 'nullable|max:50',
			'country_id' => 'nullable|exists:countries,id|numeric',
			'phone' => 'nullable', // |regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:16
			'mobile' => 'nullable', // |regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:16
			'email_private' => 'nullable|email',
			'staff_id' => 'exists:staffs,id'
		];
		$request->validate($rules);
		$userInfo->update($request->except('_token'));
//
//		// If A, make sure the TAX ID is the same as the user account TAX ID
//		if ($userInfo->a_or_b === 'a') {
//			$userInfo->update(['nif' => $userInfo->user->nif]);
//			$userInfo->update(['country_id' => $userInfo->user->country->id]);
//		}

		return redirect()->route('my-space.user-infos.index', [$user]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param User $user
	 * @param UserInfo $userInfo
	 * @return RedirectResponse
	 */
	public function destroy(User $user, UserInfo $userInfo): RedirectResponse
	{
		$userInfo->delete();
		return redirect()->route('my-space.user-infos.index', [$user]);
	}

	/**
	 * Call the printable template.
	 *
	 * @param User $user
	 * @return Application|Factory|View
	 * @throws CouldNotTakeBrowsershot
	 */
	public function createPDF(User $user)
	{
		// an image will be saved
		// Browsershot::url('http://127.0.0.1:8000/admin/users/1/user-infos')->save($user->nif.'-infos.pdf');
		// retreive all records from db
		$data = $user->userInfos->toArray() ?? NULL;
//        // share data to view
//        if($data){
//            view()->share('back.user-infos.printable',$data);
//            $pdf = PDF::loadView('back.user-infos.printable', $data);
//            // download PDF file with download method
//            return $pdf->download($user->nif.'-infos.pdf');
//        }
//        Flash::error('No information to print. Please, fill forms first.');
		return view('my-space::user-printables.user-infos');
	}
}
