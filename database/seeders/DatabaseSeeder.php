<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Theme;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\CustomForm;
use App\Models\Transaction;
use Illuminate\Support\Str;
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
			'password' => bcrypt('123456'),
			'no_rekening' => '627277272',
			'bank' => 'BCA',
		]);

		User::create([
			'name' => 'JAY',
			'username' => 'JAY',
			'email' => 'Jahidin.inspirit@gmail.com',
			'password' => bcrypt('123456'),
			'no_rekening' => '627277888872',
			'bank' => 'BRI',
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

		Event::create([
			'user_id' => 1,
			'title' => 'Example event 1',
			'slug' => 'example1',
			'category' => 2,
			'description' => 'Example description 1',
			'terms' => 'Example terms 1',
			'theme' => 4,
			'location_jenis' => 'Online',
			'location_province' => null,
			'location_city' => null,
			'location_detail' => null,
			'price_category' => 1,
			'start_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'end_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'image' => 'example1.jpg',
		]);
		Event::create([
			'user_id' => 1,
			'title' => 'Example event 2',
			'slug' => 'example2',
			'category' => 3,
			'description' => 'Example description 2',
			'terms' => 'Example terms 2',
			'theme' => 2,
			'location_jenis' => 'Online',
			'location_province' => null,
			'location_city' => null,
			'location_detail' => null,
			'price_category' => 1,
			'start_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'end_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'image' => 'example2.jpg',
		]);
		Event::create([
			'user_id' => 1,
			'title' => 'Example event 3',
			'slug' => 'example3',
			'category' => 3,
			'description' => 'Example description 3',
			'terms' => 'Example terms 3',
			'theme' => 6,
			'location_jenis' => 'Online',
			'location_province' => null,
			'location_city' => null,
			'location_detail' => null,
			'price_category' => 1,
			'start_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'end_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'image' => 'example3.jpg',
		]);
		Event::create([
			'user_id' => 1,
			'title' => 'Example event 4',
			'slug' => 'example4',
			'category' => 4,
			'description' => 'Example description 4',
			'terms' => 'Example terms 4',
			'theme' => 2,
			'location_jenis' => 'Online',
			'location_province' => null,
			'location_city' => null,
			'location_detail' => null,
			'price_category' => 1,
			'start_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'end_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'image' => 'example4.jpg',
		]);

		Event::create([
			'user_id' => 1,
			'title' => 'Example event 5',
			'slug' => 'example5',
			'category' => 7,
			'description' => 'Example description 5',
			'terms' => 'Example terms 5',
			'theme' => 5,
			'location_jenis' => 'Online',
			'location_province' => null,
			'location_city' => null,
			'location_detail' => null,
			'price_category' => 1,
			'start_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'end_date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
			'image' => 'example5.jpg',
		]);

		Ticket::create([
			"event_id" => 1,
			"ticket_name" => 'Example ticket 1',
			"ticket_description" => 'Ticket description 1',
			"ticket_quota" => 100,
			"ticket_start" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_deadline" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_price" => 60000,
			"ticket_button" => 'BELI TIKET',
		]);
		Ticket::create([
			"event_id" => 2,
			"ticket_name" => 'Example ticket 2',
			"ticket_description" => 'Ticket description 2',
			"ticket_quota" => 200,
			"ticket_start" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_deadline" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_price" => 50000,
			"ticket_button" => 'BELI TIKET',
		]);
		Ticket::create([
			"event_id" => 3,
			"ticket_name" => 'Example ticket 3',
			"ticket_description" => 'Ticket description 3',
			"ticket_quota" => 300,
			"ticket_start" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_deadline" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_price" => 40000,
			"ticket_button" => 'BELI TIKET',
		]);
		Ticket::create([
			"event_id" => 4,
			"ticket_name" => 'Example ticket 4',
			"ticket_description" => 'Ticket description 4',
			"ticket_quota" => 400,
			"ticket_start" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_deadline" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_price" => 10000,
			"ticket_button" => 'BELI TIKET',
		]);
		Ticket::create([
			"event_id" => 5,
			"ticket_name" => 'Example ticket 5',
			"ticket_description" => 'Ticket description 5',
			"ticket_quota" => 500,
			"ticket_start" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_deadline" => Carbon::parse('2024-01-01')->format('Y-m-d'),
			"ticket_price" => 200000,
			"ticket_button" => 'BELI TIKET',
		]);
		CustomForm::create([
			"event_id" => 1,
			"form_name" => 'KTP'
		]);
		CustomForm::create([
			"event_id" => 2,
			"form_name" => 'KTP'
		]);
		CustomForm::create([
			"event_id" => 3,
			"form_name" => 'KTP'
		]);
		CustomForm::create([
			"event_id" => 4,
			"form_name" => 'KTP'
		]);
		CustomForm::create([
			"event_id" => 5,
			"form_name" => 'KTP'
		]);

		$namaArray = [
			'Anita', 'Budi', 'Citra', 'Dian', 'Eka',
			'Fandi', 'Gita', 'Hendra', 'Indah', 'Joko',
			'Kartika', 'Lukman', 'Mira', 'Nina', 'Oscar',
		];

		foreach ($namaArray as $nama) {
			Transaction::create([
				'ticket_id' => 2,
				'event_id' => 2,
				'name' => $nama,
				'phone' => '0893762373334',
				'email' => $nama . '@email.com',
				'is_login' => 1,
				'user_login_id' => 1,
				'payment_type' => 'qris',
				'quantity' => 1,
				'total_price' => 50500,
				'transaction_id' => 'EC-' . strtoupper(Str::random(10)),
				'status' => 'Paid',
			]);
		}

		$namaArray2 = [
			'Fatkhan', 'Ana', 'Kusuma', 'Noviayu', 'Alfian',
			'Joko', 'Naeli', 'indah', 'hendra', 'Abdul',
		];

		foreach ($namaArray2 as $nama2) {
			Transaction::create([
				'ticket_id' => 1,
				'event_id' => 1,
				'name' => $nama2,
				'phone' => '021162373334',
				'email' => $nama2 . '@email.com',
				'is_login' => 1,
				'user_login_id' => 1,
				'payment_type' => 'bank_transfer',
				'quantity' => 1,
				'total_price' => 60500,
				'transaction_id' => 'EC-' . strtoupper(Str::random(10)),
				'status' => 'Paid',
			]);
		}


		// Seeder data privinsi dan kota
		// php artisan migrate:fresh --seed && php artisan laravolt:indonesia:seed
	}
}
