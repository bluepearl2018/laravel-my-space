<?php

namespace Eutranet\MySpace\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;
use Eutranet\MySpace\Models\MySpaceGeneralTerm;

/**
 * @extends Factory
 */
class MySpaceGeneralTermFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MySpaceGeneralTerm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['description' => "string", 'title' => "string", 'lead' => "array|string", 'body' => "array|string", 'file_path' => "null", 'admin_id' => "int"])]
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'lead' => $this->faker->paragraphs(1, true),
            'body' => $this->faker->paragraphs(5, true),
            'file_path' => null,
            'admin_id' => 1,
        ];
    }
}
