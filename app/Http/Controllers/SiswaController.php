<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Siswa;


class SiswaController extends Controller
{
    //
    public function index(Request $request)
    { 
    	if ($request->has('cari')) {
    		$data_siswa = \App\Siswa::where('nama_depan','LIKE','%'.$request->cari.'%')->get();
    	}else{
    		$data_siswa = \App\Siswa::all(); 
    	}
    	
    	return view('siswa.index',['data_siswa' => $data_siswa]);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'nama_depan' => 'required|min:5',
            'nama_belakang' => 'required',
            'email'     =>  'required|email|unique:users',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'avatar' => 'mimes:jpeg,png'

        ]);

        
        //insert tabel user
        $user  = new \App\User;
        $user->role  = 'siswa';
        $user->name  = $request->nama_depan;
        $user->email = $request->email;
        $user->password = bcrypt('rahasia'); // password default;
        $user->remember_token = str_random(60);
        $user->save();

        //insert tabel siswa
        $request->request->add(['user_id' => $user->id ]);
        $siswa = \App\Siswa::create($request->all()); 
        if ($request->hasfile('avatar')) {
            $request->file('avatar')->move('images/',$request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
    	return redirect('/siswa')->with('sukses','Data Berhasil diinputt!');
    	
    }
    public function edit(Siswa $siswa)
    {

    	return view('siswa/edit',['siswa' => $siswa]);
    }

    public function update(Request $request,Siswa $siswa)
    {
        $this->validate($request,[
            'nama_depan' => 'required|min:5',
            'nama_belakang' => 'required',
            'email'     =>  'required|email|unique:users',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'avatar' => 'mimes:jpeg,png'

        ]);
    	$siswa->update($request->all());
        if ($request->hasfile('avatar')) {
            $request->file('avatar')->move('images/',$request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
    	return redirect('/siswa')->with('sukses','Data Berhasil diupdate!');
    }
    public function delete(Siswa $siswa)
    {
    	$siswa->delete($siswa);
    	return redirect('/siswa')->with('sukses','Data Berhasil dihapus!');
    }
    public function profile(Siswa $siswa)
    {
        
        $matapelajaran = \App\Mapel::all();
        // dd($mapel);

        // menyiapkan data untuk chart
        $categories = [];
        $data       = [];

        foreach ($matapelajaran as $mp) {
            if ($siswa->mapel()->wherePivot('mapel_id',$mp->id)->first()) {
                $categories[] = $mp->nama; 
                $data[]       = $siswa->mapel()->wherePivot('mapel_id',$mp->id)->first()->pivot->nilai;
            }
        }
// cari penjelasan perbedaan antara dua code di atas dan di bawah
        // foreach ($siswa->mapel as $mp) {
        //         $categories[] = $mp->nama; 
        //         $data[]       = $siswa->mapel()->wherePivot('mapel_id',$mp->id)->first()->pivot->nilai;
        // }

        return view('siswa.profile', ['siswa' => $siswa,'matapelajaran' => $matapelajaran,'categories' => $categories,'data' => $data]);
    }
    public function addnilai(Request $request,$idsiswa)
    {
        $this->validate($request,[
            'nilai' => 'required'

        ]);
        $messages = [
            'required' => 'salaah !'
        ];

        // dd($request->all());
        $siswa = \App\Siswa::find($idsiswa);
        if ($siswa->mapel()->where('mapel_id',$request->mapel)->exists()) {
            
        return redirect('siswa/'.$idsiswa.'/profile')->with('error','Data Nilai Sudah Ada');
        }
        $siswa->mapel()->attach($request->mapel,['nilai' => $request->nilai]);

        return redirect('siswa/'.$idsiswa.'/profile')->with('sukses','Data Nilai Berhasil dimasukkan');
    }

    public function deletenilai(Siswa $siswa ,$idmapel)
    {
         
         $siswa->mapel()->detach($idmapel);
         return redirect()->back()->with('sukses','Data Nilai Berhasil dihapus!');
    }
    public function exportExcel() 
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }
    public function exportPdf() 
    {
        $siswa = \App\Siswa::all();
        $pdf = PDF::loadView('export.siswapdf',['siswa' => $siswa]);
        return $pdf->download('siswa.pdf');
    }
}
