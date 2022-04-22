<?php

namespace Eutranet\MySpace\Models;

use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

/**
 * User can conclude agreements of several types...
 * For instance, all contracts of all types concluded between
 * the team and the user can be found in the 'user contracts'.
 */
class Contractable extends MorphPivot implements HasMedia
{

	use HasTranslations;
	use InteractsWithMedia;
	use SoftDeletes;

	/**
	 * Agreements are UNSIGNED PDF agreement templates
	 */
	protected $table = "contractables";
	/**
	 * @var string[]
	 */
	protected $fillable = ['user_id', 'contractable_type', 'contractable_id'];

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
	 * @return string
	 */
	public static function getClassLead(): string
	{
		return 'All contracts of all types concluded between the team and the user can be found in the "user contracts."';
	}

	/**
	 * To be able to instantiate the right Model from our laravel-init
	 * with the factory() method, we need to add the following
	 * method to our model:
	 * @return UserHasAgreementFactory
	 */
	protected static function newFactory(): UserHasAgreementFactory
	{
		return UserHasAgreementFactory::new();
	}

}
