<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProjectFactory extends Factory
{
    /**
     * The name of the model that this factory belongs to.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'creator_id' => function () {
                // Assuming you have a User model and corresponding UserFactory
                return User::factory()->create()->id;
            }
        ];
    }
}
