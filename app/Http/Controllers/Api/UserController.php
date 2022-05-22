<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\Controller;
class UserController extends Controller
{
    public function login(Request $request) //login
    {
        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'status'    => false,
                'message'   => 'Kesalahan email atau password',
            ]);
        }    

        if (Auth::check()) {
            Auth::user()->OauthAcessToken()->delete();                
        }

        $user = Auth::user();

        $token = $user->createToken('nApp')->accessToken;
        return response()->json([
            'status'    => true,
            'message'   => 'Berhasil login',
            'data'      => $user,
            'token'     => $token
        ]);

    }

    public function register(Request $request) // register
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'tempat_lahir'  => 'required|string', 
            'tanggal_lahir' => 'required|date', // yyyy-mm-dd
            'pekerjaan' => 'required|string',
            'kota_id'       => 'required|numeric',
            'alamat_lengkap'=>'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'nohp' => 'required|string',
            'jkel' => 'required|string', // "L", "P"
            'foto_ktp' => 'image|mimes:jpeg,png,jpg|max:3072',    
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status'    => false,
                'message'  => $message
            ]);
        }

        $gambar = $request->file('foto_ktp');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
        }

        $user = User::create([ 
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => Hash::make($request->get('password')),
            'tempat_lahir' => $request->get('tempat_lahir'),
            'tanggal_lahir' => $request->get('tanggal_lahir'),
            'pekerjaan' => $request->get('pekerjaan'),
            'alamat_id' => $request->get('kota_id'),
            'alamat'    => $request->get('alamat_lengkap'),
            'kecamatan' => $request->get('kecamatan'),
            'kelurahan' => $request->get('kelurahan'),
            'nohp'      => $request->get('nohp'),
            'petani_verified' => '1', // terverifikasi (skripsi)
            'foto_ktp'  => $gambar_path,
            'jkel'      => $request->get('jkel'),
            'rt' => $request->get('rt'),
            'rw' => $request->get('rw'),
            'role'      => 'petani', //petani (skripsi)    
            'verified_by' => null,    
        ]);

        $token = $user->createToken('nApp')->accessToken;
        return response()->json([
            'status'    => true,
            'message'   => 'Berhasil daftar',
            'data'      => $user,
            'token'     => $token
        ]);
    }

    public function update(Request $request) // edit profile
    {
        if(!$user = Auth::user()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Invalid Token'
            ]);
        }

        if($request->get('password_lama') != null) {
                // custom validator
            Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
                return Hash::check($value, \Auth::user()->password);
            });

                // message for custom validation
            $messages = [
                'password' => 'Password lama tidak sesuai',
            ];

                // validate form
            $validator = Validator::make(request()->all(), [
                'password_lama'         => 'required|password',
                'password'              => 'required|min:8|confirmed',
                'password_confirmation' => 'required',

            ], $messages);

                // if validation fails
            if ($validator->fails()) {
                $message = $validator->messages()->first();
                return response()->json([
                    'status'    => false,
                    'message'  => $message
                ]);
            }
            $data = User::find($user->id);
            $user->password = bcrypt(request('password'));
            $user->save();
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil mengubah paasword'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date', // yyyy-mm-dd
            'alamat_lengkap'=> 'required|string',
            'pekerjaan'     => 'required|string',
            'kecamatan'     => 'required|string',
            'kelurahan'     => 'required|string',
            'nohp'          => 'required|string',
            'kota_id'       => 'required|numeric',
            'rt'            => 'required|string',
            'rw'            => 'required|string',
            'jkel'          => 'required|string',
            'foto_ktp'      => 'image|mimes:jpeg,png,jpg|max:3072',  
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status'    => false,
                'message'  => $message
            ]);
        }

        $data = User::find($user->id);
        if ($data == null) {
            return response()->json([
                'status'    => false, 
                'message'   => 'Id user tidak ditemukan'
            ]);
        }
        $data->name         = $request->get('name');
        $data->tempat_lahir = $request->get('tempat_lahir');
        $data->alamat       = $request->get('alamat_lengkap');
        $data->kecamatan    = $request->get('kecamatan');
        $data->nohp         = $request->get('nohp');
        $data->pekerjaan    = $request->get('pekerjaan');
        $data->alamat_id    = $request->get('kota_id');
        $data->tanggal_lahir= $request->get('tanggal_lahir');
        $data->rt           = $request->get('rt');
        $data->rw           = $request->get('rw');
        $data->jkel         = $request->get('jkel'); // L atau P
        $data->kelurahan    = $request->get('kelurahan');

        $gambar = $request->file('foto_ktp');
        
        if($gambar) {
            if ($data->gambar && file_exists(storage_path('app/public/' . $data->foto_ktp))) {
                \Storage::delete('public/' . $data->foto_ktp);
            }

            $filenameSimpan = $data->foto_ktp;
            $path = $request->file('foto_ktp')->storeAs('public', $filenameSimpan);
            $data->foto_ktp = $filenameSimpan;
        }
        
        // $gambar = $request->file('foto_ktp');

        // if ($gambar) {
        //     if ($data->gambar && file_exists(storage_path('app/public/' . $data->foto_ktp))) {
        //         \Storage::delete('public/' . $data->foto_ktp);
        //     }
        //     $gambar_path = $gambar->store('gambar', 'public');
        //     $data->foto_ktp = $gambar_path;
        // }

        $data->save();
        return response()->json([
            'status'    => true,
            'message'   => 'Berhasil mengubah data'
        ]);
    }

        public function detail() //detail user
        {
            if(!$user = Auth::user()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid Token'
                ]);
            }
            return response()->json([
                'status'    => true,
                'message'   => 'Data user yang sedang login',
                'data'      => $user
            ]);
        }
    }

