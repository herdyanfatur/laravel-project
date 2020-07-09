<?php 
use App\Siswa;
use App\Guru;

function rangkingBesar()
{
	$siswa = Siswa::all();
    $siswa->map(function($s){
    	$s->rataNilai = $s->rataNilai();
    		return $s;
    	});
    $siswa = $siswa->sortByDesc('rataNilai')->take(5);
    return $siswa;
}
function totalSiswa()
{
	return Siswa::count();
}
function totalGuru()
{
	return Guru::count();
}