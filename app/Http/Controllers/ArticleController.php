<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{

	# Main page artikel / blog
	public function blogMain()
	{
		# 1 Artikel terbaru
		$latestArticles = Article::where('article_code', '!=', 2)->latest()->first();

		# Query mengambil data artikel
		$articles = Article::where('slug', '!=', $latestArticles->slug)
			->where('article_code', '!=', 2)
			->orderBy('id', 'DESC')
			->paginate(10)
			->withQueryString();

		return view('article.page-blog-index', [
			'latestArticle' => $latestArticles,
			'articles' => $articles,
		]);
	}

	public function blogSearch(Request $request)
	{
		# Key pencarian
		$key = $request->key;

		# Query artikel
		$articles = Article::where('title', 'LIKE', '%' . $key . '%')
			->where('article_code', '!=', 2)
			->orderBy('id', 'DESC')
			->limit(10)
			->paginate(10)
			->withQueryString();

		return view('article.page-blog-search', [
			'articles' => $articles,
		]);
	}

	# function proses validasi dan simpan artikel
	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'blog_title' => 'required|max:255',
			'blog_category' => 'required',
			'slug' => 'required|unique:articles|max:255',
			'blog_image' => 'image|file|max:2048',
			'blog_body' => 'required',
			'blog_article_id' => 'required',
			'blog_tag' => 'required'
		], [
			'blog_title.required' => 'Judul wajib diisi.',
			'blog_category.required' => 'Kategori wajib diisi.',
			'slug.unique' => 'Title sudah digunakan. Harap pilih judul lain.',
			'blog_image.image' => 'Gambar harus berupa file gambar.',
			'blog_image.file' => 'File yang diunggah harus berupa gambar.',
			'blog_image.max' => 'Ukuran gambar tidak boleh melebihi 2 MB.',
			'blog_body.required' => 'Isi blog tidak boleh kosong.',
			'blog_article_id.required' => 'ID artikel blog wajib diisi.',
			'blog_tag.required' => 'Tag blog wajib dipilih.'
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			$firstError = $errors->first();
			return response()->json(['error' => $firstError]);
		}

		// Jika validasi berhasil, simpan gambar ke storage
		if ($request->hasFile('blog_image')) {
			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('blog_image')->getClientOriginalName());

			# Simpan image
			$request->file('blog_image')->storeAs('public/blog-images', $imageName);
		} else {
			$imageName = null; // Jika tidak ada gambar diunggah
		}

		$excerpt = Str::limit(strip_tags($request->blog_body), 50, '...') ?? '';

		# Jika sudah validasi, simpan data di variabel
		$data = [
			'title' => $request->blog_title,
			'category_id' => $request->blog_category,
			'user_id' => auth()->user()->id,
			'slug' => $request->slug,
			'input_image' => $imageName,
			'excerpt' => $excerpt,
			'body' => $request->blog_body,
			'article_code' => $request->blog_article_id,
			'tag' => $request->blog_tag,
		];

		Article::create($data);
		return response()->json(['success' => 'Article created!']);
	}

	public function getArticle()
	{
		$article = Article::with(['user'])
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($article)
			->addIndexColumn()
			->addColumn('blog-title', function ($article) {
				return view('dashboard.admin-dashboard.components.article-title')->with(['data' => $article]);
			})
			->addColumn('action', function ($article) {
				return view('dashboard.admin-dashboard.components.article-action')->with(['data' => $article]);
			})
			->make(true);
	}

	public function editArticle(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'blog_title_edit' => 'required|max:255',
			'blog_category_edit' => 'required',
			'slug_edit' => 'required|max:255',
			'blog_image_edit' => 'image|file|max:2048',
			'blog_body_edit' => 'required',
			'blog_article_id_edit' => 'required',
			'blog_tag_edit' => 'required'
		], [
			'blog_title_edit.required' => 'Judul wajib diisi.',
			'blog_category_edit.required' => 'Kategori wajib diisi.',
			'blog_image_edit.image' => 'Gambar harus berupa file gambar.',
			'blog_image_edit.file' => 'File yang diunggah harus berupa gambar.',
			'blog_image_edit.max' => 'Ukuran gambar tidak boleh melebihi 2 MB.',
			'blog_body_edit.required' => 'Isi blog tidak boleh kosong.',
			'blog_article_id_edit.required' => 'ID artikel blog wajib diisi.',
			'blog_tag_edit.required' => 'Tag blog wajib dipilih.'
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			$firstError = $errors->first();
			return response()->json(['error' => $firstError]);
		}

		$blog_id = $request->blog_id_edit;
		$blog_detail = Article::find($blog_id);

		# Jika title / slug ada perubahan, maka cek slug
		if ($blog_detail->slug != $request->slug_edit) {
			$cek_slug = Article::where('slug', $request->slug_edit)->exists();
			if ($cek_slug) {
				return response()->json(['error' => 'Ada title yang sama! Coba ganti judul yang unik!']);
			}
		}

		$excerpt = Str::limit(strip_tags($request->blog_body_edit), 50, '...') ?? '';

		# Jika sudah validasi, simpan data di variabel
		$data = [
			'title' => $request->blog_title_edit,
			'category_id' => $request->blog_category_edit,
			'user_id' => auth()->user()->id,
			'slug' => $request->slug_edit,
			'excerpt' => $excerpt,
			'body' => $request->blog_body_edit,
			'article_code' => $request->blog_article_id_edit,
			'tag' => $request->blog_tag_edit,
		];

		# Jika ada file baru
		if ($request->hasFile('blog_image_edit')) {

			#Hapus file lama
			if ($blog_detail->input_image != null) {
				Storage::delete('public/blog-images/' . $blog_detail->input_image);
			}

			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('blog_image_edit')->getClientOriginalName());

			# Simpan data image baru
			$request->file('blog_image_edit')->storeAs('public/blog-images', $imageName);
			$data['input_image'] = $imageName;
		}

		$blog_detail->update($data);
		return response()->json(['success' => 'Article edited!']);
	}

	# Fungsi delete

	public function deleteArticle(Request $request)
	{
		$id_article = $request->id;
		$data_article = Article::find($id_article);

		// Hapus file gambarnya juga
		if ($data_article->input_image) {
			Storage::delete('public/blog-images/' . $data_article->input_image);
		}

		$data_article->delete();
		return response()->json(['success' => 'Article deleted!']);
	}

	# KATEGORI ARTIKEL
	public function submitCategory(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'category_name' => 'required|max:255',
			'category_id' => 'required|unique:article_categories|max:255',
		], [
			'category_name.required' => 'Nama kategori wajib diisi.',
			'category_id.unique' => 'Kategori sudah ada!',
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			$firstError = $errors->first();
			return response()->json(['error' => $firstError]);
		}

		$category = $request->category_name;
		$category_id = $request->category_id;

		$data = [
			'category' => $category,
			'category_id' => $category_id,
		];

		# Insert
		ArticleCategory::create($data);
		return response()->json(['success' => 'Kategori ditambahkan!']);
	}

	public function viewArticle($slug)
	{
		$detail_article = Article::where('slug', $slug)->first();
		$more_articles = Article::where('article_code', $detail_article->article_code)
			->where('slug', '!=', $detail_article->slug)
			->inRandomOrder()
			->limit(5)
			->get();

		if ($detail_article) {
			// Artikel ditemukan, lakukan logika untuk menampilkan artikel
			return view('article.page-blog-view', [
				'article' => $detail_article,
				'more_articles' => $more_articles,
			]);
		}

		// Artikel tidak ditemukan, kembalikan respons 404 ("Not Found")
		abort(404);
	}


	public function getCategory()
	{

		$category = ArticleCategory::orderByRaw('id DESC')
			->get();

		return DataTables::of($category)
			->addIndexColumn()
			->addColumn('action', function ($category) {
				return view('dashboard.admin-dashboard.components.article-category')->with(['data' => $category]);
			})
			->make(true);
	}

	public function editCategory(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'category_name' => 'required|max:255',
			'category_id' => 'required|max:255',
		], [
			'category_name.required' => 'Nama kategori wajib diisi.',
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			$firstError = $errors->first();
			return response()->json(['error' => $firstError]);
		}

		$category_name = $request->category_name;
		$category_id = $request->category_id;

		$category = ArticleCategory::where('id', $request->category_key)->first();

		$data_edit = [
			'category' => $category_name,
			'category_id' => $category_id,
		];

		if ($category->category_id == $category_id) {
			# Insert
			$category->update($data_edit);
			return response()->json(['success' => 'Kategori berhasil di edit!']);
		} else {
			$cek_category = ArticleCategory::where('category_id', $category_id)->exists();
			# Cek slug / id unik
			if ($cek_category) {
				return response()->json(['error' => 'Sepertinya kategori sudah ada!']);
				# code...
			}
			$category->update($data_edit);
			return response()->json(['success' => 'Kategori berhasil di edit!']);
		}
	}

	public function deleteCategory(Request $request)
	{

		$id_kategori = $request->id;
		$data_kategori = ArticleCategory::find($id_kategori);

		$data_kategori->delete();
		return response()->json(['success' => 'Category deleted!']);
	}


	# Tipe / Jenis artikel

	public function getType()
	{
		$type = ArticleType::orderByRaw('id DESC')
			->get();

		return DataTables::of($type)
			->addIndexColumn()
			->addColumn('action', function ($type) {
				return view('dashboard.admin-dashboard.components.article-type')->with(['data' => $type]);
			})
			->make(true);
	}

	public function submitType(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'article_type' => 'required|max:255',
			'type_slug' => 'required|unique:article_types|max:255',
		], [
			'article_type.required' => 'Jenis artikel wajib diisi.',
			'type_slug.unique' => 'Jenis artikel sudah ada!',
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			$firstError = $errors->first();
			return response()->json(['error' => $firstError]);
		}

		$type = $request->article_type;
		$type_slug = $request->type_slug;

		$data = [
			'type_name' => $type,
			'type_slug' => $type_slug,
		];

		# Insert
		ArticleType::create($data);
		return response()->json(['success' => 'jenis artikel ditambahkan!']);
	}

	public function editType(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'article_type' => 'required|max:255',
			'type_slug' => 'required|max:255',
		], [
			'article_type.required' => 'Jenis artikel wajib diisi.',
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			$firstError = $errors->first();
			return response()->json(['error' => $firstError]);
		}

		$type = $request->article_type;
		$type_slug = $request->type_slug;

		$type_article = ArticleType::find($request->type_id);

		$data = [
			'type_name' => $type,
			'type_slug' => $type_slug,
		];

		if ($type_article->type_slug != $type_slug) {
			# Cek ada slug yang sama atau tidak
			$check_data = ArticleType::where('type_slug', $type_slug)->exists();
			if ($check_data) {
				return response()->json(['error' => 'jenis artikel sudah ada!']);
			}
		}

		$type_article->update($data);
		return response()->json(['success' => 'jenis artikel berhasil di edit!']);
	}

	public function deleteType(Request $request)
	{

		$id_type = $request->id;
		$data_type = ArticleType::find($id_type);

		$data_type->delete();
		return response()->json(['success' => 'Article type deleted!']);
	}

	public function pricingInfo()
	{
		return view('article.page-pricing', []);
	}

	public function aboutUs()
	{
		return view('article.page-about-us', []);
	}

	public function contactUs()
	{
		return view('article.page-contact-us', []);
	}

	public function guide()
	{
		return view('article.page-guide', []);
	}
	public function terms()
	{
		# Dari database kirim artikel

		$tosGeneral = Article::where('slug', 'terms-and-condition-general')->first();
		$tosCreator = Article::where('slug', 'terms-and-condition-creator')->first();
		$tosUser = Article::where('slug', 'terms-and-condition-user')->first();

		return view('article.page-terms-and-condition', [
			'tosGeneral' => $tosGeneral,
			'tosCreator' => $tosCreator,
			'tosUser' => $tosUser,
		]);
	}

	public function privacyPolicy()
	{
		# Dari database kirim artikel

		$privacyPolicy = Article::where('slug', 'privacy-policy')->first();

		return view('article.page-privacy-policy', [
			'privacy_policy' => $privacyPolicy,
		]);
	}

	public function faq()
	{
		# Halaman FAQ
		return view('article.page-faq', []);
	}
}
