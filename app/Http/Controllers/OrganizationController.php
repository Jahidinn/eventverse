<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class OrganizationController extends Controller
{
	public function index()
	{
		return view('dashboard.page-organization');
	}

	public function createOrg(Request $request)
	{
		$user_id = auth()->user()->id;
		$validasi = Validator::make($request->all(), [
			'org_name' => 'required',
			'org_institution' => 'required',
			'org_address' => 'required',
			'org_contact' => 'required',
			'org_type' => 'required',
			'org_logo_input' => 'required|image|max:616',
		]);

		if ($validasi->fails()) {
			$error = $validasi->errors()->first();
			return response()->json(['error' => $error]);
		} else {
			//cek apabila organisasi sudah dibuat
			$slug = Str::slug($request->org_name);
			$count = Organisation::where('org_id', $slug)->count();
			while ($count > 0) {
				$slug = Str::slug($request->org_name) . '-' . $count;
				return response()->json(['error' => 'Nama organisasi sudah ada! cek lagi ya!']);
			}

			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('org_logo_input')->getClientOriginalName());

			$data = [
				'org_id' => $slug,
				'org_name' => $request->org_name,
				'org_institution' => $request->org_institution,
				'org_address' => $request->org_address,
				'org_contact' => $request->org_contact,
				'org_type' => $request->org_type,
				'org_image' =>  $imageName,
				'org_status' =>  1,
				'user_created' =>  $user_id
			];
			//Simpan gambar dan update data gambar pada database
			$suksesInsrtOrg = Organisation::create($data);

			$dataMember = [
				'user_id' => $user_id,
				'org_id' => $suksesInsrtOrg->id,
				'position' => 'Owner',
				'status' => 1,
			];
			OrganisationMember::create($dataMember);

			if ($suksesInsrtOrg) {
				$request->file('org_logo_input')->storeAs('/public/organization-images', $imageName);
				//insert org member juga //
				return response()->json(['success' => 'Organisasi berhasil dibuat!']);
			} else {
				return response()->json(['error' => 'Gagall membuat organisasi!']);
			}
		}
	}

	public function getMyOrg()
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}

		$user_id = auth()->user()->id;
		$dataOrganization = Organisation::where('user_created', $user_id)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataOrganization)
			->addColumn('org', function ($dataOrganization) {
				return view('dashboard.components.column-org-name')->with(['data' => $dataOrganization]);
			})
			->addColumn('org_action', function ($dataOrganization) {
				return view('dashboard.components.column-myorg-action')->with(['data' => $dataOrganization]);
			})
			->make(true);
	}

	public function detailOrg(Request $request)
	{
		$detailOrganization = Organisation::where('id', $request->org_id)
			->orderByRaw('id DESC')
			->first();

		if ($detailOrganization) {
			return response()->json(['data' => $detailOrganization]);
		} else {
			return response()->json(['error' => 'Tidak ada data!']);
		}
	}

	public function editOrg(Request $request)
	{
		$user_id = auth()->user()->id;
		$validasi = Validator::make($request->all(), [
			'org_name_edit' => 'required',
			'org_institution_edit' => 'required',
			'org_address_edit' => 'required',
			'org_contact_edit' => 'required',
			'org_type_edit' => 'required',
			'org_logo_input_edit' => 'image|max:616',
		]);

		if ($validasi->fails()) {
			$error = $validasi->errors()->first();
			return response()->json(['error' => $error]);
		} else {
			//cek jika ada ada perubahan id / nama
			$slug = Str::slug($request->org_name_edit);
			$dataOrg = Organisation::where('id', $request->org_id_edit)->first();

			if ($slug != $dataOrg->org_id) {
				//cek apabila organisasi sudah dibuat
				$count = Organisation::where('org_id', $slug)->count();
				while ($count > 0) {
					$slug = Str::slug($request->org_name) . '-' . $count; // nggak dipakai
					return response()->json(['error' => 'Nama organisasi sudah ada! cek lagi ya!']);
				}
			}

			$data = [
				'org_id' => $slug,
				'org_name' => $request->org_name_edit,
				'org_institution' => $request->org_institution_edit,
				'org_address' => $request->org_address_edit,
				'org_contact' => $request->org_contact_edit,
				'org_type' => $request->org_type_edit,
			];

			//Cek apakah ada input gambar baru
			if ($request->file('org_logo_input_edit')) {
				//Hapus file
				if ($dataOrg->org_image != null) {
					Storage::delete('public/organization-images/' . $dataOrg->org_image);
				}
				//Save image
				$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('org_logo_input_edit')->getClientOriginalName());
				$request->file('org_logo_input_edit')->storeAs('/public/organization-images', $imageName);
				$data['org_image'] = $imageName;
			}


			//Simpan gambar dan update data gambar pada database
			$sukseUpdateOrg = Organisation::where('id', $request->org_id_edit)->update($data);

			if ($sukseUpdateOrg) {
				return response()->json(['success' => 'Organisasi berhasil di edit!']);
			} else {
				return response()->json(['error' => 'Gagall edit organisasi!']);
			}
		}
	}

	public function deleteOrg(Request $request)
	{
		$dataOrg = Organisation::find($request->org_id);

		// Hapus file gambarnya juga
		if ($dataOrg->org_image) {
			Storage::delete('public/organization-images/' . $dataOrg->org_image);
		}

		$deleteProcess = $dataOrg->delete();
		OrganisationMember::where('org_id', $request->org_id)->delete();

		if ($deleteProcess) {
			return response()->json(['success' => 'Berhasil dihapus!']);
		} else {
			return response()->json(['error' => 'Gagal!']);
		}
	}

	//Handle follow org
	public function getOrg(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}

		$user_id = auth()->user()->id;
		$dataOrganization = Organisation::orderByRaw('id DESC')
			->get();

		return DataTables::of($dataOrganization)
			->addColumn('org', function ($dataOrganization) {
				return view('dashboard.components.column-org-name')->with(['data' => $dataOrganization]);
			})
			->addColumn('org_follow', function ($dataOrganization) {
				return view('dashboard.components.column-org-follow')->with(['data' => $dataOrganization]);
			})
			->make(true);
	}

	public function followOrg(Request $request)
	{
		$user_id = auth()->user()->id;
		$org_id = $request->org_id;

		//cek siapa pembuat organisasi
		$cekOwner = Organisation::where('id', $org_id)->first();
		$owner = $cekOwner->user_created == $user_id ? 'Owner' : 'Request join';

		$data = [
			'user_id' => $user_id,
			'org_id' => $org_id,
			'position' => $owner,
			'status' => 1,
		];

		//Cek sudah ikut apa belum
		$cekOrg = OrganisationMember::where('user_id', $user_id)->where('org_id', $org_id)->first();
		if ($cekOrg) {
			return response()->json(['error' => 'Kamu sudah sudah gabung organisasi ini!']);
		}

		$follow = OrganisationMember::create($data);

		if ($follow) {
			return response()->json(['success' => 'Berhasil request gabung organisasi']);
		} else {
			return response()->json(['error' => 'Gagal!']);
		}
	}

	public function unfollowOrg(Request $request)
	{
		$user_id = auth()->user()->id;
		$org_id = $request->org_id;

		$delete = OrganisationMember::where('user_id', $user_id)->where('id', $org_id)->delete();

		if ($delete) {
			return response()->json(['success' => 'Berhasil keluar organisasi']);
		} else {
			return response()->json(['error' => 'Gagal!']);
		}
	}

	public function myFollowingOrg(Request $request)
	{

		$user_id = auth()->user()->id;

		$dataOrganization = OrganisationMember::with(['user', 'org'])->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataOrganization)
			->addColumn('org_nama', function ($dataOrganization) {
				return view('dashboard.components.column-org-following-name')->with(['data' => $dataOrganization]);
			})
			->addColumn('org_position', function ($dataOrganization) {
				return view('dashboard.components.column-org-foll-position')->with(['data' => $dataOrganization]);
			})
			->addColumn('org_unfollow', function ($dataOrganization) {
				return view('dashboard.components.column-org-unfollow')->with(['data' => $dataOrganization]);
			})
			->make(true);
	}

	public function getOrgMember(Request $request)
	{
		$dataMember = OrganisationMember::with(['user', 'org'])->where('org_id', $request->org_id)
			->whereIn('position', ['Owner', 'Member'])
			->orderByRaw('id ASC')
			->get();

		return DataTables::of($dataMember)
			->addColumn('member_name', function ($dataMember) {
				return view('dashboard.components.column-member-name')->with(['data' => $dataMember]);
			})
			->addColumn('member_action', function ($dataMember) {
				return view('dashboard.components.column-add-remove-member')->with(['data' => $dataMember]);
			})
			->make(true);
	}

	public function getOrgMemberReequest(Request $request)
	{
		$dataMember = OrganisationMember::with(['user', 'org'])->where('org_id', $request->org_id)
			->whereIn('position', ['Request join'])
			->orderByRaw('id ASC')
			->get();

		return DataTables::of($dataMember)
			->addColumn('member_name', function ($dataMember) {
				return view('dashboard.components.column-member-name')->with(['data' => $dataMember]);
			})
			->addColumn('member_action', function ($dataMember) {
				return view('dashboard.components.column-member-request')->with(['data' => $dataMember]);
			})
			->make(true);
	}
}
