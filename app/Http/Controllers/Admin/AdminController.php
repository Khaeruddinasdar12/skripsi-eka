<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Auth;
class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index(Request $request) //menampilkan hal. data user
	{
		//mengurutkan dari terbaru ke terlama (descending)
		if($request->get('search') != '') {
			$admin = Admin::where('name', 'like', '%'.$request->get('search').'%')
					->orderBy('created_at', 'desc')
					->paginate(10);
		} else {
			$admin = Admin::orderBy('created_at', 'desc')->paginate(10);
		}
		$jml = Admin::count();
		// return $admin; // uncomment ini untuk melihat api data admin
		return view('admin.page.admin', ['admin' => $admin, 'jml' => $jml]); //struktur folder di folder views
	}

	public function store(Request $request)
	{
		$validasi = $this->validate($request, [
			'name'      => 'required|string',
			'email'     => 'required|string|email|max:255|unique:users',
			'password'  => 'required|string|min:8|confirmed',
			'role' 		=> 'required|string'
		]);

		$admin = Admin::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => bcrypt($request->get('password')),
			'role' => $request->get('role'),
		]);

		return redirect()->back()->with('success', 'Berhasil menambah data admin');
	}

	public function update(Request $request, $id)
	{
		$validasi = $this->validate($request, [
			'name'      => 'required|string',
			'role' 		=> 'required|string'
		]);

		$admin = Admin::findOrFail($id);
		$admin->name = $request->get('name');
		$admin->role = $request->get('role');
		$admin->save();

		return redirect()->back()->with('success', 'Berhasil mengubah data admin');
	}

	public function delete($id)
	{
		if ($id == Auth::guard('admin')->user()->id) {
			return redirect()->back()->with('error', 'Anda sedang login');
		}

		$admin = Admin::findOrFail($id);
		$admin->delete();

		return redirect()->back()->with('success', 'Berhasil menghapus data admin');
	}
}
