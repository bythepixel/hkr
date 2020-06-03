<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create a user';

    public function handle()
    {
        $request = [
            'name' => $this->ask('What is the name?'),
            'email' => $this->ask('What is the email?'),
            'password' => $this->secret('What is the password?')
        ];

        $validator = Validator::make($request, [
            'name' => 'required|min:3|max:255',
            'email' => 'required|min:3|max:255',
            'password' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        $this->info('User created');
    }
}
