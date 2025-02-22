<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'blog_head' => 'Pottery Mastery: From Clay to Art',
                'image' => '3.png',
                'blog_description' => 'Journey through the process of transforming raw clay into stunning pottery. Explore different pottery styles and the artistic vision behind each unique piece.',
                'slug' => 'pottery-mastery-from-clay-to-art',
                'author_name' => 'Bangabasi India',
                'tags' => 'pottery, art, craftsmanship',
                'view_count' => rand(1, 100), // Random view count
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Eco-Crafts: Sustainable Handmade Art',
                'image' => '4.png',
                'blog_description' => 'Discover how artisans are embracing eco-friendly materials and techniques in their crafts. Explore innovative approaches to creating sustainable, handmade art.',
                'slug' => 'eco-crafts-sustainable-handmade-art',
                'author_name' => 'Bangabasi India',
                'tags' => 'eco-friendly, crafts, sustainability',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Terracotta Art: Ancient Craft Revived',
                'image' => '1.png',
                'blog_description' => 'Explore the resurgence of terracotta artistry, blending traditional techniques with modern aesthetics. Discover how artisans are breathing new life into this timeless craft.',
                'slug' => 'terracotta-art-ancient-craft-revived',
                'author_name' => 'Bangabasi India',
                'tags' => 'terracotta, revival, art',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Handwoven Wonders: Textile Traditions',
                'image' => '2.png',
                'blog_description' => 'Delve into the intricate world of handwoven textiles, showcasing the skill and creativity of artisans. Learn about various weaving techniques and their cultural significance.',
                'slug' => 'handwoven-wonders-textile-traditions',
                'author_name' => 'Bangabasi India',
                'tags' => 'textiles, weaving, tradition',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Ceramic Innovations: Modern Techniques',
                'image' => '5.png',
                'blog_description' => 'Uncover the latest advancements in ceramic art. From cutting-edge materials to innovative techniques, see how modern technology is transforming traditional ceramic practices.',
                'slug' => 'ceramic-innovations-modern-techniques',
                'author_name' => 'Bangabasi India',
                'tags' => 'ceramics, innovation, modern art',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'The Revival of Quilting Arts',
                'image' => '6.png',
                'blog_description' => 'Explore the resurgence of quilting as an art form. Discover how contemporary artists are reinterpreting traditional quilting methods to create vibrant, modern works.',
                'slug' => 'revival-of-quilting-arts',
                'author_name' => 'Bangabasi India',
                'tags' => 'quilting, arts, contemporary',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Woodcraft Wonders: From Trees to Treasures',
                'image' => '7.png',
                'blog_description' => 'Take a closer look at the artistry involved in woodcraft. From selecting the perfect wood to crafting intricate designs, learn about the skills and passion behind each wooden masterpiece.',
                'slug' => 'woodcraft-wonders-from-trees-to-treasures',
                'author_name' => 'Bangabasi India',
                'tags' => 'woodcraft, artistry, craftsmanship',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Ceramic Sculpture: Merging Art and Functionality',
                'image' => '8.png',
                'blog_description' => 'Discover the unique world of ceramic sculpture where artistry meets functionality. Learn how artists create stunning pieces that serve both aesthetic and practical purposes.',
                'slug' => 'ceramic-sculpture-art-functionality',
                'author_name' => 'Bangabasi India',
                'tags' => 'ceramics, sculpture, functional art, craftsmanship',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Crafting with Nature: Natural Dye Techniques',
                'image' => '9.png',
                'blog_description' => 'Dive into the art of natural dyeing and learn how to create vibrant colors from plants and minerals. Explore the ecological impact and the beauty of sustainable dyeing practices.',
                'slug' => 'crafting-with-nature-natural-dye-techniques',
                'author_name' => 'Bangabasi India',
                'tags' => 'dyeing, eco-friendly, textiles, natural materials, sustainability',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'The Art of Paper Mache: Crafting Unique Sculptures',
                'image' => '10.png',
                'blog_description' => 'Explore the creative process of paper mache, where everyday materials transform into extraordinary sculptures. Discover the techniques behind this accessible art form.',
                'slug' => 'art-of-paper-mache-sculptures',
                'author_name' => 'Bangabasi India',
                'tags' => 'paper mache, sculpture, crafting, creativity',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Stained Glass: The Intersection of Light and Art',
                'image' => '11.png',
                'blog_description' => 'Uncover the beauty of stained glass art, where color and light dance together. Learn about the history, techniques, and contemporary applications of this ancient craft.',
                'slug' => 'stained-glass-light-art',
                'author_name' => 'Bangabasi India',
                'tags' => 'stained glass, art, light, creativity, craftsmanship',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'The Craft of Leatherwork: From Hide to Heirloom',
                'image' => '12.png',
                'blog_description' => 'Step into the world of leatherwork and discover the techniques that turn animal hides into beautiful, functional pieces. Explore the artistry behind bags, shoes, and more.',
                'slug' => 'craft-of-leatherwork-hide-to-heirloom',
                'author_name' => 'Bangabasi India',
                'tags' => 'leatherwork, craftsmanship, fashion, artistry',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Metalworking Magic: Forging New Frontiers',
                'image' => '13.png',
                'blog_description' => 'Learn about the intricate art of metalworking, from forging to sculpting. Discover how artisans are pushing the boundaries of creativity with metal as their medium.',
                'slug' => 'metalworking-magic-forging-new-frontiers',
                'author_name' => 'Bangabasi India',
                'tags' => 'metalworking, artistry, craftsmanship, sculpture',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
            [
                'blog_head' => 'Creative Embroidery: Stitching Stories',
                'image' => '14.png',
                'blog_description' => 'Delve into the world of embroidery, where each stitch tells a story. Explore various techniques and how contemporary artists are reimagining this timeless craft.',
                'slug' => 'creative-embroidery-stitching-stories',
                'author_name' => 'Bangabasi India',
                'tags' => 'embroidery, art, textile, storytelling, craftsmanship',
                'view_count' => rand(1, 100),
                'published_at' => now(),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
