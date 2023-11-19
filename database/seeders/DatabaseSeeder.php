<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Theme;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{

		User::create([
			'name' => 'Jahidin',
			'username' => 'Jahidin',
			'email' => 'Jahidin@gmail.com',
			'password' => bcrypt('123456')
		]);

		$categories = [
			['category' => 'Lomba'],
			['category' => 'Beasiswa'],
			['category' => 'Konser'],
			['category' => 'Olimpiade'],
			['category' => 'Seminar'],
			['category' => 'Pameran'],
			['category' => 'Bazar'],
			['category' => 'Training'],
			['category' => 'Turnamen'],
			['category' => 'Trip'],
			['category' => 'Lainya']
		];
		Category::insert($categories);

		$theme = [
			['theme' => 'Sains & teknologi'],
			['theme' => 'Ekonomi, bisnis, & investasi'],
			['theme' => 'Pendidikan & beasiswa'],
			['theme' => 'Seni budaya'],
			['theme' => 'Game / e-sports'],
			['theme' => 'Musik'],
			['theme' => 'Keuangan / finansial'],
			['theme' => 'Desain, foto, & video'],
			['theme' => 'Karir & pengembangan diri'],
			['theme' => 'Sosial, hukum & politik'],
			['theme' => 'Kesehatan'],
			['theme' => 'Otomotif'],
			['theme' => 'Keagamaan'],
			['theme' => 'Lingkungan hidup'],
			['theme' => 'Makanan / minuman'],
			['theme' => 'Lainya'],
		];
		Theme::insert($theme);
	}
}
