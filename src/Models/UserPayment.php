<?php

namespace Eutranet\MySpace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use Spatie\Translatable\HasTranslations;

class UserPayment extends Model
{
	use HasFactory;
	use SoftDeletes;
	use HasTranslations;

	protected $table = "user_payments";
	protected $visible = ['amount'];
	protected $dateFormat = ['created_at:H:m'];
	protected $dates = ['created_at'];

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
		return 'User payments.';
	}
}
