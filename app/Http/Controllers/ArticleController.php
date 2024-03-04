<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
	// function proses validasi dan simpan artikel
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
			'slug.unique' => 'Title sudah digunakan. Harap pilih slug lain.',
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

		# Jika sudah validasi, simpan data di variabel

		// Jika validasi berhasil, simpan gambar ke storage
		if ($request->hasFile('blog_image')) {
			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('blog_image')->getClientOriginalName());

			# Simpan image
			$request->file('blog_image')->storeAs('public/blog-images', $imageName);
		} else {
			$imageName = null; // Jika tidak ada gambar diunggah
		}

		$excerpt = Str::limit(strip_tags($request->blog_body), 50, '...') ?? '';
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
			->addColumn('action', function ($article) {
				return view('dashboard.admin-dashboard.components.article-action')->with(['data' => $article]);
			})
			->make(true);
	}
}
