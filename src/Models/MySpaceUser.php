<?php

namespace Eutranet\MySpace\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Eutranet\Corporate\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * GeneralTerm and its table are to store laravel-corporate general terms.
 * This should implement HasMedia in order to retrieve PDF
 */
class MySpaceUser extends User
{
    use Notifiable;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users';
        $this->mergeFillable([
            'nif',
            'user_status_id',
            'phone',
            'has_accepted_general_terms_on',
            'has_accepted_my_space_general_terms_on',
            'is_valid',
            'is_locked',
        ]);
    }

    /**
     * @return string[][]
     */
    #[ArrayShape(['email' => "string[]", 'name' => "string[]", 'phone' => "string[]", 'nif' => "string[]", 'country_id' => "string[]"])]
    public static function getFields(): array
    {
        return [
            'nif' => ['input', 'pttaxid', 'required', 'Tax ID', 'You tax id number', 'readonly'],
            'email' => ['input', 'email', 'required', 'Account email', 'This MUST NOT be deleted or updated', 'readonly'],
            'name' => ['input', 'text', 'required', 'Account Name', 'This is the account name', 'readonly'],
            'phone' => ['input', 'phone', 'required', 'Phone', 'Enter or update a phone number'],
        ];
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
     * This static function is essential for the documentation service provider
     * The namespace is saved into doc_models table
     * @return string
     */
    public static function getClassLead(): string
    {
        return trans('my-space.My space user.');
    }

    /**
     * @return MorphToMany
     */
    public function mySpaceGeneralTerms(): MorphToMany
    {
        return $this->morphedByMany(MySpaceGeneralTerm::class, 'contractable', 'contractables', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function socialMedias(): HasOne
    {
        return $this->hasOne(UserSocialMedia::class, 'user_id');
    }

    /**
     * @return HasOne
     */
    public function userInfos(): HasOne
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }
}
