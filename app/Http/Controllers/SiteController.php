<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SiteController extends Controller
{
    public function home()
    {

        $post = Post::all();
    	return view('sites.home',compact(['post']));
    }
    public function about()
    {
    	return view('sites.about');
    }
    public function register()
    {
    	return view('sites.register');
    }
    public function postregister(Request $request)
    {

        $this->validate($request,[
            'nama_depan' => 'required|min:5',
            'nama_belakang' => htmlspecialchars('required'),
            'email'     =>  'required|email|unique:users',
            'jenis_kelamin' => 'required',
            'agama' => 'required'

        ]);

    	//insert tabel user
        $user  = new \App\User;
        $user->role  = 'siswa';
        $user->name  = $request->nama_depan;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // password default;
        $user->remember_token = str_random(60);
        $user->save();

        //insert tabel siswa
        $request->request->add(['user_id' => $user->id ]);
        $siswa = \App\Siswa::create($request->all()); 

        return redirect('/')->with('sukses','Data pendaftaran berhasil dikirim!');
    }
    public function singlepost($slug)
    {
        $post = Post::where('slug','=',$slug)->first(); //first(); untuk mengambil satu row ('slug harus sama dengan parameter yang di kirim $slug')
        return view('sites.singlepost',compact(['post'])); //compact (helper bawan laravel) (untuk melempar variabel atau parameter ke view)
    }
}
