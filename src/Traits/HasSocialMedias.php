<?php

namespace Eutranet\MySpace\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Eutranet\MySpace\Models\UserSocialMedia;

trait HasSocialMedias
{

	/**
	 * Get the user social Medias
	 *
	 * @return MorphOne
	 */
	public function socialMedias(): MorphOne
	{
		return $this->morphOne(UserSocialMedia::class, 'socializable');
	}

}