<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Charge;

/**
 * @phpstan-type TModel \Workbench\App\Models\Charge
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class ChargeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Charge::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => CustomerFactory::new()->create(),
            'amount' => 1000,
        ];
    }
}
