<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Admin',
            'company_id' => 1,
            'email' => 'josipa.beslic@gmail.com',
            'password' => bcrypt('admin'),
        ]);
        //
        DB::table('clients')->insert([
            'company_id' => 1,
            'name' => 'beDev, obrt za računalne djelatnosti',
            'address' => 'Trnjanska cesta 59',
            'zip_code' => '10000',
            'city' => 'Zagreb',
            'oib' => '00460997027',
        ]);
        DB::table('companies')->insert([
            'name' => 'beDev, obrt za računalne djelatnosti',
            'owner' => 'Josipa Bešlić',
            'address' => 'Trnjanska cesta 59',
            'zip_code' => '10000',
            'city' => 'Zagreb',
            'oib' => '00460997027',
            'iban' => 'HR4023400091160517112',
            'bank_info' => 'Privredna banka Zagreb, SWIFT CODE: PBZGHR2X',
            'activity' => 'RAČUNALNE DJELATNOSTI',
        ]);
        DB::table('remarks')->insert([
            [   'company_id' => 1,
                'description' => 'usluge za domaće klijente',
                'output' => 'Oslobođeno PDV-a temeljem članka 90. Zakona o PDV-u'],
            [   'company_id' => 1,
                'description' => 'usluge za inozemne klijente',
                'output' => 'Oslobođeno PDV-a temeljem članka 17.točka 1 Zakona o PDV-u - reverse charge'],
            [   'company_id' => 1,
                'description' => 'roba za domaće klijente ',
                'output' => 'Oslobođeno PDV-a temeljem članka 90. Zakona o PDV-u'],
            [   'company_id' => 1,
                'description' => 'roba za inozemne klijente',
                'output' => 'Oslobođeno PDV-a temeljem članka 90. Zakona o PDV-u'],
        ]);
        DB::table('units')->insert([
            [   'company_id' => 1,
                'name' => 'sat'],
            [   'company_id' => 1,
                'name' => 'kom'],
        ]);
        DB::table('products')->insert([
            [   'company_id' => 1,
                'description' => 'Usluge programiranja',
                'code' => 'DEV'],
            [   'company_id' => 1,
                'description' => 'Savjetovanje u vezi s računalima',
                'code' => 'CONS'],
            [   'company_id' => 1,
                'description' => 'Upravljanje računalnom opremom i sustavom',
                'code' => 'MANG'],
        ]);
    }
}
