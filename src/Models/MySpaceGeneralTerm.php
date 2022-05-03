<?php

namespace Eutranet\MySpace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Eutranet\Setup\Models\Admin;
use Eutranet\MySpace\Database\Factories\MySpaceGeneralTermFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Eutranet\Corporate\Models\User;

/**
 * GeneralTerm and its table are to store laravel-corporate general terms.
 * This should implement HasMedia in order to retrieve PDF
 */
class MySpaceGeneralTerm extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    /**
     * @var string
     */
    protected $table = "my_space_general_terms";
    /**
     * @var string[]
     */
    protected $fillable = [
        'corporate_id',
        'title',
        'description',
        'lead',
        'body',
        'admin_id'
    ];

    /**
     * @var array|string[]
     */
    protected array $translatable = [
        'title',
        'description',
        'lead',
        'body'
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
        return 'These general terms and conditions of service and use of "my space" apply to all operations carried out under this part of the portal.';
    }

    /**
     * @return \string[][]
     */
    #[ArrayShape(['corporate_id' => "string[]", 'title' => "string[]", 'description' => "string[]", 'lead' => "string[]", 'body' => "string[]", 'file_path' => "string[]"])]
    public function getFields(): array
    {
        // field, type, required, placeholder, tip, model for select
        return [
            'corporate_id' => ['select', 'list', 'required', 'Corporate', 'Select the laravel-corporate', 'Eutranet\Corporate\Models\Corporate'],
            'title' => ['input', 'textarea', 'required', 'Title', 'Enter the title'],
            'description' => ['input', 'textarea', 'required', 'Description', 'Enter the description'],
            'lead' => ['input', 'textarea', 'required', 'Lead', 'Enter the lead / intro'],
            'body' => ['input', 'textarea', 'required', 'Body', 'Enter the body'],
            'file_path' => ['input', 'file', 'optional', 'PDF version', 'Get a PDF from you preferred folder'],
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
     * @return MySpaceGeneralTermFactory
     */
    protected static function newFactory(): MySpaceGeneralTermFactory
    {
        return MySpaceGeneralTermFactory::new();
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

    /**
     * @return MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'contractable');
    }
}
