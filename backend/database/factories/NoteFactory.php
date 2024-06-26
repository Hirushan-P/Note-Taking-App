<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = $this->faker->randomElement(['Personal', 'Work', 'Other']);
    
        return [
            'title' => $this->faker->sentence(),
            'category' => $category,
            'description' => $this->faker->paragraph(),
            'completed' => false
        ];
    }
}
