<?php

namespace App\Console;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketActivity;
use App\Models\Ticket\TicketStatus;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;
use Webklex\IMAP\Facades\Client;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $seconds = 5;
            $x=60/$seconds;
            do{
                sleep(3);
                $oClient = Client::account('default');
                $oClient->connect();
                $oFolder = $oClient->getFolder('INBOX');
                $aMessage = $oFolder->query()->since(now()->subDays(1))->setFetchFlags(false)->get();
                foreach($aMessage as $oMessage) {
                    if (Ticket::where('title', '=', $oMessage->getSubject())->exists()) {
                        // ticket found
                    }
                    else
                    {
                        $ticket = Ticket::create([
                            'ticket_number' => Ticket::orderBy('ticket_number', 'desc')->first()->ticket_number + 1,
                            'title' => $oMessage->getSubject(),
                            'client_name' => $oMessage->getFrom()[0]->personal,
                            'client_email' => $oMessage->getFrom()[0]->mail,
                            'details' => $oMessage->getTextBody(),
                            'source_id' => 1,
                            'severity_id' => 1,
                            'current_status_id' => 1,
                        ]);

                        TicketActivity::create([
                            'ticket_id' => $ticket->id,
                            'status_id' => TicketStatus::where('name', 'New')->first()->id,
                            'assignee_id' =>null,
                            'reporter_id' => null,
                            'remarks' => $oMessage->getTextBody()
                        ]);
                    }
                }
                sleep(3);
            } while($x-- > 0);

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
