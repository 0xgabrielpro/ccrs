<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Issue;
use App\Models\IssueChat;
use Faker\Factory as Faker;

class IssuesChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();
        $issues = Issue::all();

        if ($users->isEmpty() || $issues->isEmpty()) {
            // $this->command->info('No users or issues found. Skipping seeding of issue chats.');
            return;
        }

        foreach ($issues as $issue) {
            $messageCount = rand(3, 10);

            for ($i = 0; $i < $messageCount; $i++) {
                $randomUser = $users->random();

                IssueChat::create([
                    'user_id' => $randomUser->id,
                    'issue_id' => $issue->id,
                    'msg' => $faker->sentence,
                ]);

                // $this->command->info("Created IssueChat for Issue ID {$issue->id} with User ID {$randomUser->id}");
            }
        }
    }
}
