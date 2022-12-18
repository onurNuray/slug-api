<?php

namespace App\Console\Commands;

use App\Models\Slug;
use App\Models\User;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {user_email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send slug reports email to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('user_email', $this->argument('user_email'))->first();
        $slugs = Slug::where('user_id', $user->id)->get();

        $info = [];
        foreach ($slugs as $slug) {
            $info[] = [
                'slug' => $slug->slug,
                'count' => $slug->counter,
            ];
        }

        // Send slug reports email to user with $imfo
        // ....... Send Email Actions - Eg:Mail::to($this->argument('user_email'))->send($info) ......

        return 0;
    }
}
