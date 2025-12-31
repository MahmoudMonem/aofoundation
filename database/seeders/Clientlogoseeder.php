<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientLogo;

class ClientLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed if table is empty
        if (ClientLogo::count() > 0) {
            $this->command->info('ClientLogo table is not empty. Skipping seeder.');
            return;
        }

        $this->command->info('Seeding client logos...');

        // Row 1 Logos
        $row1Logos = [
            ['name' => 'Novartis', 'logo' => 'logos/Novartis.png'],
            ['name' => 'Novo Nordisk', 'logo' => 'logos/novo.png'],
            ['name' => 'Sabah Al Ahmad', 'logo' => 'logos/sabahalahmad.png'],
            ['name' => 'Ministry of Health', 'logo' => 'logos/mohealth.png'],
            ['name' => 'Servier', 'logo' => 'logos/Servier.png'],
            ['name' => 'Hamed Saleh', 'logo' => 'logos/hamdsaleh.png'],
            ['name' => 'Sanofi', 'logo' => 'logos/sanofi.png'],
            ['name' => 'Algo', 'logo' => 'logos/Algo.png'],
            ['name' => 'Amryt', 'logo' => 'logos/amryt.png'],
            ['name' => 'Amgen', 'logo' => 'logos/AMGEN.png'],
            ['name' => 'Boubyan Bank', 'logo' => 'logos/Boubyan.png'],
            ['name' => 'Viatris', 'logo' => 'logos/Viatris.png'],
        ];

        // Row 2 Logos
        $row2Logos = [
            ['name' => 'AAW', 'logo' => 'logos/AAW.png'],
            ['name' => 'AstraZeneca', 'logo' => 'logos/Az.png'],
            ['name' => 'KIMS', 'logo' => 'logos/KIMS.png'],
            ['name' => 'Bayer', 'logo' => 'logos/Bayer.png'],
            ['name' => 'BLGX', 'logo' => 'logos/BLGX.png'],
            ['name' => 'Boehringer Ingelheim', 'logo' => 'logos/boehringer.png'],
            ['name' => 'Genpharm', 'logo' => 'logos/genpharm.png'],
            ['name' => 'Organon', 'logo' => 'logos/organon.png'],
            ['name' => 'Kuwait Heart Foundation', 'logo' => 'logos/KHF.png'],
            ['name' => 'Eli Lilly', 'logo' => 'logos/Lilly.png'],
            ['name' => 'Bristol Myers Squibb', 'logo' => 'logos/bristol.png'],
        ];

        // Insert Row 1
        foreach ($row1Logos as $index => $logo) {
            ClientLogo::create([
                'name' => $logo['name'],
                'logo' => $logo['logo'],
                'row' => 1,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Insert Row 2
        foreach ($row2Logos as $index => $logo) {
            ClientLogo::create([
                'name' => $logo['name'],
                'logo' => $logo['logo'],
                'row' => 2,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        $this->command->info('Successfully seeded ' . (count($row1Logos) + count($row2Logos)) . ' client logos.');
    }
}