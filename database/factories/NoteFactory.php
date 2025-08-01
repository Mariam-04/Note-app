<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use App\Models\Picture;

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

    public function definition(){
        return [
    'user_id' => User::inRandomOrder()->first()?->id,
    'pic_id' => fn () => Picture::factory()->create()->id,
    'content' => fake()->paragraph(3),
    ];
}

}
