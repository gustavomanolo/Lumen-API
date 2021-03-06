<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Estudiante;
use App\Profesor;
use App\Curso;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Estudiante::truncate();
        Profesor::truncate();
        Curso::truncate();
        DB::table('curso_estudiante')->truncate();

        DB::table('curso_estudiante')->truncate();
        DB::table('oauth_clients')->truncate();

        //-> *** Create tables and seed them *** <-//
        factory(Profesor::class, 50)->create();
        factory(Estudiante::class, 500)->create();
        
        //factory(Curso::class, 40)->create()
        //factory(Curso::class, 40)->create(['profesor_id' => mt_rand(1,50)])
        factory(Curso::class, 40)->create()
        ->each(function($curso)
        {
            $curso->estudiantes()->attach(array_rand(range(1, 500),40));
        });



        $this->call('OAuthClientSeeder');

        //Model::unguard();
        // $this->call('UserTableSeeder');
        //Model::reguard();
    }
}
