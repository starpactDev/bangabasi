<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of sample data
        $messages = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'message' => 'Hello, this is the first message.',
                'responsed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'message' => 'This is the second message.',
                'responsed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'message' => 'Here is the third message.',
                'responsed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob@example.com',
                'message' => 'Fourth message for testing.',
                'responsed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie@example.com',
                'message' => 'Fifth message added.',
                'responsed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eve White',
                'email' => 'eve@example.com',
                'message' => 'Sixth message for the database.',
                'responsed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Frank Wilson',
                'email' => 'frank@example.com',
                'message' => 'Seventh message here.',
                'responsed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grace Lee',
                'email' => 'grace@example.com',
                'message' => 'Eighth message for testing.',
                'responsed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Henry Harris',
                'email' => 'henry@example.com',
                'message' => 'Ninth message added.',
                'responsed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ivy Clark',
                'email' => 'ivy@example.com',
                'message' => 'Tenth and final message.',
                'responsed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the data into the messages table
        DB::table('messages')->insert($messages);
    }
}
