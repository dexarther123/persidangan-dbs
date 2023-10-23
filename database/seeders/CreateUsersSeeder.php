<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
               'name'=>'President',
               'email'=>'president@mbs.com',
               'type'=>0,
               'password'=> bcrypt('12345678'),
            ],
            [
               'name'=>'Bendahari',
               'email'=>'bendahari@mbs.com',
               'type'=> 1,
               'password'=> bcrypt('12345678'),
            ],
            [
               'name'=>'EXCO',
               'email'=>'exco@mbs.com',
               'type'=>2,
               'password'=> bcrypt('12345678'),
            ],
            [
               'name'=>'NON-EXCO',
               'email'=>'nonexco@mbs.com',
               'type'=>3,
               'password'=> bcrypt('12345678'),
            ],
            [
               'name'=>'Gabungan',
               'email'=>'gabungan@mbs.com',
               'type'=>4,
               'password'=> bcrypt('12345678'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
