<?php

namespace Eutranet\MySpace\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;
use Eutranet\MySpace\Models\DashboardMenu;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class DashboardMenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DashboardMenu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    #[ArrayShape(['label' => "array|string"])]
    public function definition(): array
    {
        $array =  [
            'label' => 'Check installation',
            'menu_code' => 'my-space-installer',
            'package' => 'my-space',
            'route' => 'setup.installation.my-space',
            'is_active' => true
        ];
        return $array;
    }
}
