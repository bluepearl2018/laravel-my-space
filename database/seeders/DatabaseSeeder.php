<?php

namespace Eutranet\MySpace\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Eutranet\MySpace\Models\DashboardMenu;
use Eutranet\MySpace\Models\MySpaceGeneralTerm;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		DashboardMenu::factory(5)->create();
		MySpaceGeneralTerm::factory(1)->create();

		Model::reguard();

	}
}
