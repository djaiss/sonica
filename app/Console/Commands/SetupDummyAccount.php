<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Models\User;
use App\Services\AddUserToTeam;
use App\Services\CreateAccount;
use App\Services\CreateTeam;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SetupDummyAccount extends Command
{
    use ConfirmableTrait;

    protected ?\Faker\Generator $faker;

    protected User $user;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sonica:dummy
                            {--migrate : Use migrate command instead of migrate:fresh.}
                            {--force : Force the operation to run.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare an account with fake data so users can play with it';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // remove queue
        config(['queue.default' => 'sync']);

        $this->start();
        $this->wipeAndMigrateDB();
        $this->clearCache();
        $this->createFirstUser();
        $this->createOtherUsers();
        $this->addTeams();
        $this->createAnotherAccount();

        $this->stop();
    }

    private function start(): void
    {
        if (! $this->confirmToProceed('Are you sure you want to proceed? This will delete ALL data in your environment.', true)) {
            exit;
        }

        $this->line('This process will take a few minutes to complete. Be patient and read a book in the meantime.');
        $this->faker = Faker::create();
    }

    private function wipeAndMigrateDB(): void
    {
        if ($this->option('migrate')) {
            $this->artisan('☐ Migration of the database', 'migrate', ['--force' => true]);
        } else {
            $this->artisan('☐ Migration of the database', 'migrate:fresh', ['--force' => true]);
        }
    }

    private function clearCache(): void
    {
        $this->artisan('☐ Clear cache', 'cache:clear');
    }

    private function stop(): void
    {
        $this->line('');
        $this->line('-----------------------------');
        $this->line('|');
        $this->line('| Welcome to Bivouac');
        $this->line('|');
        $this->line('-----------------------------');
        $this->info('| You can now sign in with one of these two accounts:');
        $this->line('| An account with a lot of data:');
        $this->line('| username: admin@admin.com');
        $this->line('| password: admin123');
        $this->line('|------------------------–––-');
        $this->line('|A blank account:');
        $this->line('| username: blank@blank.com');
        $this->line('| password: blank123');
        $this->line('|------------------------–––-');
        $this->line('| URL:      ' . config('app.url'));
        $this->line('-----------------------------');

        $this->info('Setup is done. Have fun.');
    }

    private function createFirstUser(): void
    {
        $this->info('☐ Create first user of the account');

        $this->user = (new CreateAccount(
            email: 'admin@admin.com',
            password: 'admin123',
            firstName: 'Michael',
            lastName: 'Scott',
            organizationName: 'Bivouac',
        ))->execute();
        $this->user->email_verified_at = Carbon::now();
        $this->user->save();

        Auth::login($this->user);
    }

    private function createOtherUsers(): void
    {
        $this->info('☐ Create users');

        for ($i = 0; $i < rand(3, 15); $i++) {
            User::create([
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
                'permissions' => User::ROLE_ACCOUNT_MANAGER,
                'name_for_avatar' => $this->faker->firstName,
                'password' => Hash::make('blank123'),
                'organization_id' => $this->user->organization_id,
            ]);
        }
    }

    private function addTeams(): void
    {
        $this->info('☐ Create teams');

        $teamNames = [
            'Frontend Development Team',
            'Backend Development Team',
            'Full Stack Development Team',
            'Quality Assurance (QA) Team',
            'User Experience (UX) Team',
            'DevOps Team',
            'Systems Administration Team',
            'Data Engineering Team',
            'Data Science Team',
            'Mobile App Development Team',
            'Security Team',
            'Technical Support Team',
            'Project Management Team',
            'Sales and Marketing Team',
            'Product Management Team',
            'User Research Team',
            'Human Resources Team',
            'Finance and Accounting Team',
            'Customer Support Team',
            'IT Operations Team',
        ];

        for ($i = 0; $i < rand(3, 20); $i++) {
            $team = (new CreateTeam(
                name: $teamNames[array_rand($teamNames)],
                isPublic: rand(1, 2) == false,
            ))->execute();

            $this->addUsersToTeam($team);
        }
    }

    private function addUsersToTeam(Team $team): void
    {
        $this->info('☐ Add user to team ' . $team->name);

        User::inRandomOrder()->limit(rand(3, 15))->get()
            ->map(fn (User $user) => (new AddUserToTeam(
                team: $team,
                user: $user,
            ))->execute());
    }

    private function createAnotherAccount(): void
    {
        $this->info('☐ Create another account');

        $this->user = (new CreateAccount(
            email: 'blank@blank.com',
            password: 'blank123',
            firstName: 'Dwight',
            lastName: 'Schrute',
            organizationName: 'Shelter',
        ))->execute();
        $this->user->email_verified_at = Carbon::now();
        $this->user->save();
    }

    private function artisan(string $message, string $command, array $arguments = []): void
    {
        $this->info($message);
        $this->callSilent($command, $arguments);
    }
}
