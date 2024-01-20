<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\OrganisationMember;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
	public function index()
	{
		$org = OrganisationMember::with(['org'])->where('user_id', auth()->user()->id)->get();
		return view('dashboard.page-profile', [
			'org' => $org
		]);
	}

	public function editImage(Request $request)
	{
		$user_id = auth()->user()->id;
		//Validasi Gambar/poster
		$validasi = Validator::make($request->all(), [
			'imageProfileEdit' => 'required|max:616'
		]);

		//Response jika validasi gagal
		if ($validasi->fails()) {
			return response()->json(['error' => 'Foto kosong atau ukuran terlalu besar!']);
		}

		//Jika lolos validasi atau validasi berhasil
		else {
			$user = User::where('id', $user_id)->first();

			//Hapus file
			if ($user->profile_picture) {
				Storage::delete('public/profile-images/' . $user->profile_picture);
			}

			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('imageProfileEdit')->getClientOriginalName());
			$data = [
				'profile_picture' => $imageName,
			];

			//Simpan gambar dan update data gambar pada database
			$request->file('imageProfileEdit')->storeAs('public/profile-images', $imageName);
			$upload_proses = User::where('id', $user_id)->update($data);

			if ($upload_proses) {
				//response suksess
				return response()->json(['success' => 'Foto profil berhasil diubah!']);
			} else {
				return response()->json(['error' => 'Gagal!']);
			}
		}
	}

	public function editPassword(Request $request)
	{
		$validasi = Validator::make($request->all(), [
			'oldPassword' => 'required|min:6|max:255',
			'newPassword' => 'required|min:6|max:255',
			'newPasswordConfirm' => 'required|min:6|same:newPassword'
		]);

		if ($validasi->fails()) {
			$error = $validasi->errors()->first();
			return response()->json(['error' => $error]);
		} else {
			//Cari user
			$user_id = auth()->user()->id;
			$user = User::findOrFail($user_id);

			//Jika password lama benar
			if (Hash::check($request->oldPassword, $user->password)) {
				$user->fill([
					'password' => Hash::make($request->newPassword)
				])->save();
				return response()->json(['success' => 'Password berhasil diganti!']);
			}
			//Jika password lama salah
			else {
				return response()->json(['error' => 'Cek password lama kamu ya!']);
			}
		}

		//dd($request->oldPassword);
	}

	public function getMyProfile()
	{
		$user_id = auth()->user()->id;
		$data_user = User::find($user_id);

		return response()->json(['success' => $data_user]);
	}

	public function editProfile(Request $request)
	{
		$validasi = Validator::make($request->all(), [
			'p_username' => 'required',
			'p_name' => 'required',
			'p_email' => 'required|email:dns',
			'p_no_tlp' => 'required|min:9',
			'p_no_rekening' => 'required',
			'p_bank' => 'required',
		]);

		if ($validasi->fails()) {
			$error = $validasi->errors()->first();
			return response()->json(['error' => $error]);
		} else {
			$user_id = auth()->user()->id;
			$data = [
				'name' => $request->p_name,
				'email' => $request->p_email,
				'no_tlp' => $request->p_no_tlp,
				'no_rekening' => $request->p_no_rekening,
				'no_bank' => $request->p_bank,
			];

			$userData = User::find($user_id);
			$userData->update($data);

			return response()->json(['success' => 'Sukses ubah profil 👌']);
		}
	}

	//View for public
	public function userPublicInfo(Request $request, $username)
	{
		$detailProfile = User::where('username', $username)->first();
		$listOrg = OrganisationMember::with(['user', 'org'])->where('user_id', $detailProfile->id)->get();
		$listEvent = Event::where('organizer', 'individual')->where('organizer_id', $detailProfile->id)->get();

		if (empty($detailProfile)) {
			abort(404, 'Resource not found.');
		}

		return view('events.page-show-user', [
			'detailProfile' => $detailProfile,
			'listOrg' => $listOrg,
			'listEvent' => $listEvent,
		]);
	}
}
