<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ticket\TicketStatus;

class TicketStatusTests extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function create_ticket_status_test()
    {
        $status = new TicketStatus();
        $status->name = 'Test Status';

        $this->assertInstanceOf(TicketStatus::class, $status);
        $this->assertEquals('Test Status', $status->name);
    }
}
