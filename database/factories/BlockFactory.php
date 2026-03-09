<?php

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Block>
 */
class BlockFactory extends Factory
{
    protected $model = Block::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'file_name' => $this->faker->unique()->slug(2),
            'block_name' => $name,
            'variant' => null,
            'avg_color_srgb' => null,
            'avg_color_linear' => null,
            'category' => $this->faker->randomElement(['Building', 'Redstone', 'Decoration']),
            'family' => $this->faker->randomElement(['Stone', 'Wood', 'Metal']),
            'material' => $this->faker->randomElement(['Stone', 'Wood', 'Metal']),
            'is_transparent' => false,
            'is_solid' => true,
            'detail_form' => null,
            'detail_flammable' => false,
            'detail_interactive' => false,
        ];
    }
}
