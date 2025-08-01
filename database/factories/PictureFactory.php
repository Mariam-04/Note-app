<?php

namespace Database\Factories;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class PictureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'filename' => fake()->word() . '.png',
            'path' => 'storage/uploads/' . fake()->uuid() . '.png',
        ];

    }
}
