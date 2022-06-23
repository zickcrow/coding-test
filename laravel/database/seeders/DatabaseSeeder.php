<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $john = \App\Models\User::factory()->create([
            'name' => 'Mr. John',
            'email' => 'mr.john@coding.test',
            'password' => Hash::make('password')
        ]);

        $lee = \App\Models\User::factory()->create([
            'name' => 'Mrs. Lee',
            'email' => 'mrs.lee@coding.test',
            'password' => Hash::make('password')
        ]);

        $positions = [
            [ 'name' => 'Senior PHP Developer' ],
            [ 'name' => 'CEO', 'description' => 'Chief Executive Officer' ],
            [ 'name' => 'CTO', 'description' => 'Chief Technology Officer' ],
        ];

        $skills = [
            [ 'name' => 'Laravel' ],
            [ 'name' => 'MySQL' ],
            [ 'name' => 'Postgresql' ],
            [ 'name' => 'Java' ],
            [ 'name' => 'Codeigniter' ],
        ];

        $institutions = [
            [ 'name' => 'UGM Yogyakarta' ],
            [ 'name' => 'Universitas Indonesia' ],
            [ 'name' => 'Universitas Brawijaya' ],
            [ 'name' => 'UIN Syarif Hidayatullah' ],
        ];

        $scopes = [
            [ 'code' => 'view-candidate', 'name' => 'View Candidate', 'description' => 'View list of Candidates' ],
            [ 'code' => 'read-candidate', 'name' => 'Read Candidate', 'descripton' => 'Read one Candidate entity' ],
            [ 'code' => 'edit-candidate', 'name' => 'Edit Candidate', 'description' => 'Edit on Candidate entity' ],
            [ 'code' => 'add-candidate', 'name' => 'Add Candidate', 'description' => 'Add new Candidate' ],
            [ 'code' => 'delete-candidate', 'name' => 'Delete Candidate', 'description' => 'Delete one Candidate entity' ],
        ];

        foreach($positions as $position) {
            \App\Models\Position::create([
                'name' => $position['name'],
                'description' => $position['description'] ?? null
            ]);
        }

        foreach($skills as $skill) {
            \App\Models\Skill::create([
                'name' => $skill['name'],
                'description' => $skill['description'] ?? null
            ]);
        }

        foreach($institutions as $institution) {
            \App\Models\EducationInstitution::create([
                'name' => $institution['name'],
                'description' => $institution['description'] ?? null
            ]);
        }

        foreach($scopes as $scope) {
            \App\Models\Scope::create([
                'code' => $scope['code'],
                'name' => $scope['name'],
                'description' => $scope['description'] ?? null
            ]);
        }

        \App\Models\Candidate::factory(20)->create();

        $skillModels = \App\Models\Skill::all();
        \App\Models\Candidate::all()->each(function ($candidate) use($skillModels) {
            $candidate->skills()->attach($skillModels->random(rand(1, 3))->pluck('id')->toArray());
        });

        $john->scopes()->sync([
            \App\Models\Scope::where('code', 'view-candidate')->first()->id,
            \App\Models\Scope::where('code', 'read-candidate')->first()->id,
            \App\Models\Scope::where('code', 'edit-candidate')->first()->id,
            \App\Models\Scope::where('code', 'add-candidate')->first()->id,
            \App\Models\Scope::where('code', 'delete-candidate')->first()->id,
        ]);

        $lee->scopes()->sync([
            \App\Models\Scope::where('code', 'view-candidate')->first()->id,
            \App\Models\Scope::where('code', 'read-candidate')->first()->id,
        ]);
    }
}
