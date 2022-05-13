<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
        $users = array(
            array(
                'name' => 'Jose Eduardo Huerta Olguin',
                'email' => 'jose.huerta@morelos.gob.mx',
                'password' => Hash::make('Jose230192'), 
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Leslie García',
                'email' => 'leslie.garcia@morelos.gob.mx',
                'password' => Hash::make('MNab3C'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Rodrigo Hernández',
                'email' => 'rodrigohernandez.sedeso@gmail.com',
                'password' => Hash::make('RB6g7Q'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Genaro Vázquez',
                'email' => 'gtlatenchi.85@gmail.com',
                'password' => Hash::make('t3gGcw'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Avril Garcia',
                'email' => 'avril.garcia.sedeso@gmail.com',
                'password' => Hash::make('HYzp9B'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Rafael López',
                'email' => 'rafaellopez.sedeso@gmail.com',
                'password' => Hash::make('zTJc8t'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Efrain Arizmendi',
                'email' => 'efraave@gmail.com',
                'password' => Hash::make('YDeD8N'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Norma Maldonado',
                'email' => 'norma.maldonado@morelos.gob.mx',
                'password' => Hash::make('wMH3tp'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Shirley Diaz',
                'email' => 'shirley.diaz.sedeso@gmail.com',
                'password' => Hash::make('nTv9C2'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Edgar López',
                'email' => 'edgarlm033@gmail.com',
                'password' => Hash::make('7y7Zb4'),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'Cinthia Hernandez',
                'email' => 'chintia.hernandez@morelos.gob.mx',
                'password' => Hash::make('JhNG6m'),
                'created_at' => date('Y-m-d H:i:s')
            )
        );
    
        foreach ($users as $user) {
            $new_user = new \App\User;
            $new_user->name = $user['name'];
            $new_user->email = $user['email'];
            $new_user->password = $user['password'];
            $new_user->save();
    
        }

    }
}
