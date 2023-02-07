<?php

namespace Database\Factories\Vehicle;

use App\Models\Vehicle\CostCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CostCenter::class;

    public function definition()
    {
        return [
            'name_ar' =>   $this->faker->name('ar'),
            'name_en' => $this->faker->name('en'),
            'code' => $this->faker->numberBetween(11111,55555),
        ];
    }
}
