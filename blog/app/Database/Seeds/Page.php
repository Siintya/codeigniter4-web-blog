<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Page extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $aboutData = [
            'title' => 'About Us',
            'content' => $faker->paragraphs(5, true), // Generate 5 paragraphs of text
            'slug' => 'about-us',
        ];

        $contactData = [
            'title' => 'Contact Us',
            'content' => $faker->text(200), // Generate 200 characters of text for contact information
            'slug' => 'contact-us',
        ];

        // Insert data into the pages table
        $this->db->table('pages')->insertBatch([$aboutData, $contactData]);
    }
}
