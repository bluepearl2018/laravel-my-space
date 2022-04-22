<?php

namespace Eutranet\MySpace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use Eutranet\Setup\Models\Admin;
use Eutranet\MySpace\Database\Factories\DashboardMenuFactory;
use Spatie\Translatable\HasTranslations;


/**
 * GeneralTerm and its table are to store laravel-corporate general terms.
 * This should implement HasMedia in order to retrieve PDF
 */
class DashboardMenu extends Model
{

	use HasFactory;
	use SoftDeletes;
	use HasTranslations;

	protected $table = "dashboard_menus";
	protected $fillable = [
		'label',
		'menu_code',
		'package',
		'params',
		'is_active',
		'route'
	];

	protected array $translatable = [
		'label'
	];

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
	 * This static function is essential for the documentation service provider
	 * The namespace is saved into doc_models table
	 * @return string
	 */
	public static function getClassLead(): string
	{
		return 'The dashboard menu is made available to users that have authenticated in My Space.';
	}

	public function getFields(): array
	{
		// field, type, required, placeholder, tip, model for select
		return [
			'corporate_id' => ['select', 'list', 'required', 'Corporate', 'Select the laravel-corporate', 'Eutranet\Corporate\Models\Corporate'],
			'label' => ['input', 'textarea', 'required', 'Title', 'Enter the title'],
			'menu_code' => ['input', 'text', 'required', 'Menu code', 'Slugified dashboard menu'],
			'package' => ['input', 'text', 'required', 'Package', 'Default package is my-space'],
			'is_active' => ['checkbox', 'option', 'optional', 'Link is active', 'True by default'],
			'params' => ['input', 'text', 'optional', 'Separated commas route param names', 'Singular class name'],
			'route' => ['input', 'text', 'required', 'Dot separated route', 'Like "my-space.dashboard"'],
		];
	}

	/**
	 * Create a media collection for general terms
	 * In other words, to attach A pdf or several versions to a genral term item
	 * @return void
	 */
	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('my-space-general-terms');
	}

	/**
	 * To be able to instantiate the right Model from our laravel-init
	 * with the factory() method, we need to add the following
	 * method to our model:
	 * @return DashboardMenuFactory
	 */
	protected static function newFactory(): DashboardMenuFactory
	{
		return DashboardMenuFactory::new();
	}
	/**
	 * Create a media collection for general terms
	 * In other words, to attach A pdf or several versions to a genral term item
	 * @return BelongsTo
	 */
	public function admin(): BelongsTo
	{
		return $this->belongsTo(Admin::class);
	}
}
