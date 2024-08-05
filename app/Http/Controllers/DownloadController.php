<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
	public function index()
	{
		return view('article.page-download-certificate', []);
	}
	public function checkFile(Request $request)
	{
		$jenis = $request->jenis;
		$id = $request->id . '.pdf';

		$exists = Storage::disk('public')->exists('certificate/' . $jenis . '/' . $id);
		return response()->json(['exists' => $exists, 'jenis' => $jenis, 'id' => $id]);
	}

	public function downloadFile(Request $request)
	{
		$jenis = $request->jenis;
		$id = $request->id;

		if (Storage::disk('public')->exists('certificate/' . $jenis . '/' . $id)) {
			return response()->download(storage_path('/app/public/certificate/' . $jenis . '/' . $id));
		}
		return abort(404);
	}
}
