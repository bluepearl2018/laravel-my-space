<?php

namespace Eutranet\MySpace\Models;

use App\Models\User;
use Flash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use Session;
use Spatie\Translatable\HasTranslations;
use Spatie\TranslationLoader\LanguageLine;
use Eutranet\Commons\Models\Gender;
use Eutranet\Commons\Models\Appellative;
use Eutranet\Commons\Models\Country;
use Eutranet\Be\Models\Staff;

/**
 * UserInfo is essential part of the user profile.
 * Data are used in almost all report templates and very useful to
 * staffs, admins and third parties.
 * A parallel entry can be created for B, the spouse, the partner of A : user_d,
 * which ownns the account.
 */
class UserInfo extends Model
{
	use HasTranslations;
	use SoftDeletes;

	/**
	 * @var string
	 */
	protected $table = "user_infos";
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'user_id',
		'nif', // Cos of B
		'gender_id',
		'appellative_id',
		'first_name',
		'last_name',
		'date_of_birth',
		'function',
		'lead',
		'resume',
		'address1',
		'address2',
		'postal_code',
		'city',
		'council',
		'district',
		'country_id',
		'phone',
		'mobile',
		'email_private'
	];

	/**
	 * @var array|string[]
	 */
	protected array $translatable = [
		'lead', 'resume'
	];

	/**
	 * @var array|string[]
	 */
	protected $dates = [
//        'date_of_birth'
	];

	/**
	 * @return string[][]
	 */

	public static function getFields(): array
	{
		return [
			'nif' => ['input', 'pttaxid', 'required', trans('user-infos.Tax ID'), trans('user-infos.Enter the portuguese Tax ID')],

			'gender_id' => ['select', 'list', 'required', trans('user-infos.Gender'), trans('user-infos.Select the gender'), 'App\Models\Commons\Gender'],
			'appellative_id' => ['select', 'list', 'required', trans('user-infos.Appellative'), trans('user-infos.Select the title'), 'App\Models\Commons\Appellative'],
			'first_name' => ['input', 'text', 'required', trans('user-infos.First Name'), trans('user-infos.Enter a first name')],
			'last_name' => ['input', 'text', 'required', trans('user-infos.Last Name'), trans('user-infos.Enter a last name')],
			'function' => ['input', 'text', 'optional', trans('user-infos.Function'), trans('user-infos.Enter a function')],

			'date_of_birth' => ['dates', 'date', 'required', trans('user-infos.Date of Birth'), trans('user-infos.Select date of birth')],

			'address1' => ['input', 'text', 'required', trans('user-infos.Address First Line'), trans('user-infos.Max. 35 characters"')],
			'address2' => ['input', 'text', 'optional', trans('user-infos.Address Second Line'), trans('user-infos.Max. 35 characters"')],
			'postal_code' => ['input', 'text', 'required', trans('user-infos.Postal code'), trans('user-infos.Enter a postal code')],
			'city' => ['input', 'text', 'required', trans('user-infos.City'), trans('user-infos.Enter a city')],
			'council' => ['input', 'text', 'required', trans('user-infos.Council'), trans('user-infos.Enter a council')],
			'district' => ['input', 'text', 'required', trans('user-infos.District'), trans('user-infos.Enter a district')],

			'country_id' => ['select', 'list', 'required', trans('user-infos.Country'), trans('user-infos.Select a country'), '\Eutranet\Commons\Models\Country'],

			'phone' => ['input', 'phone', 'required', trans('user-infos.Phone'), trans('user-infos.Should be formatted like +351.999123456')],
			'mobile' => ['input', 'phone', 'required', trans('user-infos.Mobile phone'), trans('user-infos.Should be formatted like +351.999123456')],

			'email_private' => ['input', 'email', 'required', trans('user-infos.Private Email'), trans('user-infos.Enter private email (max. 255 chars)')],
//            'lead' => ['input', 'textarea', 'optional', 'Short presentation', 'Presentação corta'],
//            'resume' => ['input', 'textarea', 'optional', 'Long presentation', 'Presentação longa']
		];
	}

	/**
	 * @return void
	 */
	public static function boot()
	{

		parent::boot();
		static::saveTranslations();

		static::creating(function ($item) {
			Flash::warning('Selected User : ' . $item->user->name . ' is being refreshed.');
			$user = User::findOrFail($item->user_id);
			Session::forget('users.selectedUser');
			Session::put('users.selectedUser', $user);
		});

		static::created(function ($item) {
			Flash::success('User info successfully created.');
		});

		static::updating(function ($item) {
			Flash::warning('Selected User : ' . $item->user->name . ' is being refreshed.');
			$user = User::findOrFail($item->user_id);
			Session::forget('users.selectedUser');
			Session::put('users.selectedUser', $user);
		});

		static::updated(function ($item) {
			Flash::success('User info successfully updated.');
		});

		static::deleting(function ($item) {
			Flash::warning('Selected User : ' . $item->user->name . ' is being refreshed.');
			$user = User::findOrFail($item->user_id);
			Session::forget('users.selectedUser');
			Session::put('users.selectedUser', $user);
		});

		static::deleted(function ($item) {
			Flash::success('User info successfully deleted.');
		});
	}

	/**
	 * Fields and class translations are saved into language lines table.
	 * This function is called from the static boot.
	 * @return void
	 */
	public static function saveTranslations()
	{
		$lls = array(
			array('group' => 'fields', 'key' => 'gender_id', 'text' => '{"en":"Gender", "pt":"Gênero"}'),
			array('group' => 'fields', 'key' => 'appellative_id', 'text' => '{"en":"Appellative", "pt":"Titulo"}'),
			array('group' => 'fields', 'key' => 'first_name', 'text' => '{"en":"First Name", "pt":"Nome proprio"}'),
			array('group' => 'fields', 'key' => 'last_name', 'text' => '{"en":"Last Name", "pt":"Nome"}'),
			array('group' => 'fields', 'key' => 'function', 'text' => '{"en":"Function", "pt":"Função"}'),
			array('group' => 'fields', 'key' => 'date_of_birth', 'text' => '{"en":"Date of birth", "pt":"Data de nascimento"}'),
			array('group' => 'fields', 'key' => 'address1', 'text' => '{"en":"Address", "pt":"Morada"}'),
			array('group' => 'fields', 'key' => 'address2', 'text' => '{"en":"Address (suite)", "pt":"Morada (extra)"}'),
			array('group' => 'fields', 'key' => 'postal_code', 'text' => '{"en":"Postal code", "pt":"Codigo postal"}'),
			array('group' => 'fields', 'key' => 'city', 'text' => '{"en":"City", "pt":"Cidade"}'),
			array('group' => 'fields', 'key' => 'council', 'text' => '{"en":"Council", "pt":"Concelho"}'),
			array('group' => 'fields', 'key' => 'district', 'text' => '{"en":"District", "pt":"Distrito"}'),
			array('group' => 'fields', 'key' => 'country_id', 'text' => '{"en":"Country", "pt":"Pais"}'),
			array('group' => 'fields', 'key' => 'phone', 'text' => '{"en":"Phone", "pt":"Telefone"}'),
			array('group' => 'fields', 'key' => 'mobile', 'text' => '{"en":"Mobile", "pt":"Telemovel"}'),
			array('group' => 'fields', 'key' => 'email_private', 'text' => '{"en":"Email (private)", "pt":"Email (privado)"}'),


			array('group' => 'user-infos', 'key' => 'Enter the portuguese Tax ID', 'text' => '{"en":"Enter the portuguese Tax ID", "pt":"Indique o NIF"}'),
			array('group' => 'user-infos', 'key' => 'Select a gender', 'text' => '{"en":"Select the gender", "pt":"Indique o gênero"}'),
			array('group' => 'user-infos', 'key' => 'Select a title', 'text' => '{"en":"Select the title", "pt":"Indique o titulo"}'),
			array('group' => 'user-infos', 'key' => 'First Name', 'text' => '{"en":"First name", "pt":"Nome proprio"}'),
			array('group' => 'user-infos', 'key' => 'Enter a first name', 'text' => '{"en":"Enter first name", "pt":"Indique o nome proprio"}'),
			array('group' => 'user-infos', 'key' => 'Last Name', 'text' => '{"en":"Last name", "pt":"Nome"}'),
			array('group' => 'user-infos', 'key' => 'Enter a last name', 'text' => '{"en":"Enter last name", "pt":"Indique nome"}'),
			array('group' => 'user-infos', 'key' => 'Function', 'text' => '{"en":"Function", "pt":"Função"}'),
			array('group' => 'user-infos', 'key' => 'Phone', 'text' => '{"en":"Phone", "pt":"Telefone"}'),
			array('group' => 'user-infos', 'key' => 'Mobile phone', 'text' => '{"en":"Mobile", "pt":"Telemovel"}'),
			array('group' => 'user-infos', 'key' => 'Private Email', 'text' => '{"en":"Private email", "pt":"Email privado"}'),
			array('group' => 'user-infos', 'key' => 'Enter a function', 'text' => '{"en":"Enter function", "pt":"Indique uma função"}'),
			array('group' => 'user-infos', 'key' => 'Select a date of birth', 'text' => '{"en":"Select a date of birth", "pt":"Selecione uma data de nascimento"}'),
			array('group' => 'user-infos', 'key' => 'Max. 35 characters"', 'text' => '{"en":"Max. 35 characters", "pt":"Max. 35 car."}'),
			array('group' => 'user-infos', 'key' => 'Enter a postal code', 'text' => '{"en":"Enter your postal code", "pt":"Indique um codigo postal"}'),
			array('group' => 'user-infos', 'key' => 'Enter a city', 'text' => '{"en":"Enter city", "pt":"Indique uma cidade"}'),
			array('group' => 'user-infos', 'key' => 'Enter a council', 'text' => '{"en":"Enter a council", "pt":"Indique um concelho"}'),
			array('group' => 'user-infos', 'key' => 'Enter a district', 'text' => '{"en":"Enter a district", "pt":"Indique um distrito"}'),
			array('group' => 'user-infos', 'key' => 'Select a country', 'text' => '{"en":"Select a country", "pt":"Selecione um pais da lista"}'),
			array('group' => 'user-infos', 'key' => 'Should be formatted like +351.999123456', 'text' => '{"en":"Should be formatted like +351.999123456", "pt":"Tem de ser formatado como +351.999123456"}'),
			array('group' => 'user-infos', 'key' => 'Enter private email (max. 255 chars)', 'text' => '{"en":"Enter private email (max. 255 chars)", "pt":"Indique email privado (max. 255 car.)"}'),
			array('group' => 'user-infos', 'key' => 'Address First Line', 'text' => '{"en":"Enter the address (first line)", "pt":"Indique a morada (primeira parte)"}'),
			array('group' => 'user-infos', 'key' => 'Address Second Line', 'text' => '{"en":"Enter the address (second line)", "pt":"Indique a morada (segunda parte)"}'),
		);

		if (\Schema::hasTable('language_lines')) {
			foreach ($lls as $ll) {
				LanguageLine::firstOrCreate([
					'group' => $ll['group'],
					'key' => $ll['key'],
					'text' => json_decode($ll['text'], true)
				]);
			}
		}
	}

	/**
	 * This static function is essential for the documentation service provider
	 * The namespace is saved into doc_models table
	 * @return string
	 */
	public static function getNamespace(): string
	{
		return __NAMESPACE__;
	}

	/**
	 * The class lead
	 * @return string
	 */
	public static function getClassLead(): string
	{
		return trans('The user info page is an extension of your account.');
	}

	/**
	 * @return void
	 */
	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('user-infos');
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function staff(): BelongsTo
	{
		return $this->belongsTo(Staff::class, 'staff_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function gender(): BelongsTo
	{
		return $this->belongsTo(Gender::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function appellative(): BelongsTo
	{
		return $this->belongsTo(Appellative::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class);
	}

}
