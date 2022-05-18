<?php

namespace Eutranet\MySpace\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine;

class LanguageLineSeeder extends Seeder
{
	public array $lls = [
		//
	];

	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		static::saveTranslations($this->lls);
	}

	public static function saveTranslations($lls)
	{

		if (\Schema::hasTable('language_lines')) {
			foreach ($lls as $ll) {
				if (!LanguageLine::where([
					'group' => $ll['group'],
					'key' => $ll['key']
				])->get()->first()) {
					LanguageLine::create([
						'group' => $ll['group'],
						'key' => $ll['key'],
						'text' => json_decode($ll['text'], true)
					]);
				};
			}
		}
	}

}
