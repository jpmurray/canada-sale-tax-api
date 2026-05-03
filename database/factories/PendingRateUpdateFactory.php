<?php

namespace Database\Factories;

use App\Models\PendingRateUpdate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PendingRateUpdate>
 */
class PendingRateUpdateFactory extends Factory
{
    protected $model = PendingRateUpdate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $provinces = ['FE', 'AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'ON', 'PE', 'QC', 'SK', 'NT', 'NU', 'YT'];

        return [
            'user_id' => User::factory(),
            'province' => fake()->randomElement($provinces),
            'pst' => fake()->randomFloat(5, 0, 0.15),
            'gst' => 0.05,
            'hst' => fake()->randomFloat(5, 0, 0.15),
            'applicable' => fake()->randomFloat(5, 0, 0.15),
            'type' => fake()->randomElement(['GST', 'HST', 'GST+PST']),
            'start' => fake()->dateTimeBetween('now', '+1 year'),
            'source' => fake()->url(),
            'status' => 'pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
            'review_notes' => null,
        ];
    }

    /**
     * Indicate that the pending rate update has been approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'reviewed_by' => User::factory()->state(['is_admin' => true]),
            'reviewed_at' => now(),
            'review_notes' => 'Approved',
        ]);
    }

    /**
     * Indicate that the pending rate update has been rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'reviewed_by' => User::factory()->state(['is_admin' => true]),
            'reviewed_at' => now(),
            'review_notes' => 'Rejected due to insufficient source information.',
        ]);
    }
}
