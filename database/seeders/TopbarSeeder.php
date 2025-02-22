<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('topbars')->insert([
            [
                'layout_type' => 'layout1',
                'banner_image' => '/images/black_fabric.jpg',  // Image for the first layout
                'overlay_text_heading' => 'Fabric Sheet',
                'overlay_text_body' => 'Step inside to the zone of ethnicity in diversity.',
                'category_1_id' => 1,  // These are category IDs; ensure categories exist in the table.
                'category_2_id' => 2,
                'category_3_id' => 3,
                'category_4_id' => 4,
                'section_1_image' => null,  // Not relevant for layout1, so null
                'section_2_image' => null,  // Not relevant for layout1, so null
                'description_head' => 'Find What Exactly You Need',  // Not relevant for layout1, so null
                'description_text' => 'Just roll your eyes into the Bangabasi and pick up the best design to cut short your monotonous fashion life. Give a pinch of aestheticism to your thoughts.',  // Not relevant for layout1, so null
            ],
            [
                'layout_type' => 'layout2',
                'banner_image' => null,  // Not relevant for layout2, so null
                'overlay_text_heading' => null,  // Not relevant for layout2, so null
                'overlay_text_body' => null,  // Not relevant for layout2, so null
                'category_1_id' => null,  // Not relevant for layout2
                'category_2_id' => null,  // Not relevant for layout2
                'category_3_id' => null,  // Not relevant for layout2
                'category_4_id' => null,  // Not relevant for layout2
                'section_1_image' => 'sale_banner.jpg',  // Image for layout2
                'section_2_image' => 'sale_banner_1.jpg',  // Image for layout2
                'description_head' => null,  // Add relevant text for layout2
                'description_text' => null,  // Add relevant text for layout2
            ],
        ]);
    }
}
