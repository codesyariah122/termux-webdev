<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
$administrator = new User;
        $administrator->name = "admin talkies";
        $administrator->email = "talkies@mail.id";
        $administrator->phone = "6288222668778";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->photo = NULL;
        $administrator->password = \Hash::make("123654Bismillah");
        $administrator->status = "ACTIVE";
        $administrator->city = "Bandung";
        $administrator->province = "Jawa Barat";
        $administrator->login = 0;
        $administrator->username = trim(preg_replace('/\s+/', '_', $administrator->name));
        $administrator->save();
        $administrator_profile = new Profile;
        $administrator_profile->address = 'Jl. Kebun kacang No.2777';
        $administrator_profile->post_code = '40218';
        $administrator_profile->save();
        $administrator->profiles()->sync($administrator_profile->id);
        $this->command->info("User admin created successfully");
    }
}
