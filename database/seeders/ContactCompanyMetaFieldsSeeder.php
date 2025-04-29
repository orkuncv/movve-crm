<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Movve\Crm\Models\TeamMetaField;
use App\Models\Team;

class ContactCompanyMetaFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Company Name',
                'key' => 'company_name',
                'type' => 'text',
                'description' => 'Contact company name',
            ],
            [
                'name' => 'Company Tax Number',
                'key' => 'company_taxnumber',
                'type' => 'text',
                'description' => 'Contact company tax number',
            ],
            [
                'name' => 'Company Address',
                'key' => 'company_adress',
                'type' => 'text',
                'description' => 'Contact company address',
            ],
            [
                'name' => 'Company Email',
                'key' => 'company_email',
                'type' => 'text',
                'description' => 'Contact company email',
            ],
        ];

        $teams = Team::all();
        foreach ($teams as $team) {
            foreach ($fields as $field) {
                TeamMetaField::firstOrCreate([
                    'team_id' => $team->id,
                    'key' => $field['key'],
                ], [
                    'name' => $field['name'],
                    'type' => $field['type'],
                    'description' => $field['description'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
