<?php

namespace Eutranet\MySpace\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Flash;

/**
 * The User Social Media is directly related to a user ID.
 * Entries are for 'A' only.
 * Entries are created for all available social medias.
 */
class UserSocialMedia extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "user_social_medias";
    /**
     * @var string[]
     */
    protected $fillable = [
        'facebook',
        'tiktok',
        'youtube',
        'linkedin',
        'twitter',
        'instagram',
        'blog',
        'user_id',
        'socializable_id',
        'socializable_type',
    ];

    /**
     * Social medias that are not useful for the site should be commented
     * @return string[][]
     */
    #[ArrayShape(['tiktok' => "string[]", 'youtube' => "string[]", 'twitter' => "string[]", 'facebook' => "string[]", 'linkedin' => "string[]", 'blog' => "string[]", 'instagram' => "string[]"])]
    public static function getFields(): array
    {
        // field, type, required, placeholder, tip, model for select
        return [
            'tiktok' => ['input', 'text', 'optional', 'Tiktok account', 'Just enter the "name" in "https://www.tiktok.com/username"'],
            'youtube' => ['input', 'text', 'optional', 'Youtube account', 'Just enter the "name" in "https://www.youtube.com/username"'],
            'twitter' => ['input', 'text', 'optional', 'Twitter account', 'Just enter the "username" in "https://www.twitter.com/username"'],
            'facebook' => ['input', 'text', 'optional', 'Facebook account', 'Just enter the "username" in "https://www.facebook.com/username"'],
            'linkedin' => ['input', 'text', 'optional', 'Linkedin account', 'Just enter the "username" in "https://www.linkedin.com/username"'],
            'blog' => ['input', 'text', 'optional', 'Blog url', 'Enter the full url of your blog like in "https://www.myblog.blog'],
            'instagram' => ['input', 'text', 'optional', 'Instagram account', 'Just enter the "username" in "https://www.instagram.com/username"'],
        ];
    }

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
        });

        static::created(function ($item) {
            Flash::success('User social medias successfully created.');
        });

        static::updating(function ($item) {
        });

        static::updated(function ($item) {
            Flash::success('User social medias successfully updated.');
        });

        static::deleting(function ($item) {
        });

        static::deleted(function ($item) {
            Flash::success('User social medias successfully deleted.');
        });
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
        return "Social medias extend the user account.";
    }

    /**
     * Get the user where the soc medias belong to
     *
     * @return MorphTo
     */
    public function socializable(): MorphTo
    {
        return $this->morphTo();
    }
}
