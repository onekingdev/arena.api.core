<?php

namespace Database\Factories\Support\Ticket;

use App\Helpers\Util;
use App\Models\Support\Ticket\SupportTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupportTicket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            "ticket_uuid" => Util::uuid(),
            "ticket_title" => "Test",
            "flag_status" => "Open"
        ];
    }
}
