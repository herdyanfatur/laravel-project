 @extends('layout.main')

@section('title', 'Data Siswa')


@section('container')

	<div class="main">
		<div class="main-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8">
						<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Edit Data Siswa</h3>
								</div>
								<div class="panel-body">
									<form action="/siswa/{{$siswa->id}}/update" method="POST" enctype="multipart/form-data">
									        	{{csrf_field()}}
											  <div class="form-group">
											    <label for="exampleInputEmail1" class="panel-title">Nama Depan</label>
											    <input name="nama_depan" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Inputkan Nama Depan Anda" value="{{$siswa->nama_depan}}">
											  </div>
											  <div class="form-group">
											    <label for="exampleInputEmail1">Nama Belakang</label>
											    <input name="nama_belakang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Inputkan Nama Belakang Anda" value="{{$siswa->nama_belakang}}">
											  </div>
											  <div class="form-group">
											    <label for="exampleFormControlSelect1">Jenis Kelamin</label>
											    <select name="jenis_kelamin" class="form-control" id="exampleFormControlSelect1" value="{{$siswa->jenis_kelamin}}">
											      <option value="L" @if($siswa->jenis_kelamin == 'L')selected @endif)>laki-laki</option>
											      <option value="P" @if($siswa->jenis_kelamin == 'P') selected @endif>Perempuan</option>
											    </select>
											  </div>
											  <div class="form-group">
											    <label for="exampleInputEmail1">Agama</label>
											    <input name="agama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Inputkan Agama Anda" value="{{$siswa->agama}}">
											  <div class="form-group">
												<label for="exampleFormControlTextarea1">Alamat</label>
												 <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3" >{{$siswa->alamat}}</textarea>
												</div>
												<div class="form-group">
												<label for="exampleFormControlTextarea1">Avatar</label>
												 <input type="file" name="avatar" class="form-control" >
												</div>
											</div>
											  
									      </div>
									      <button type="submit" class="btn btn-warning">Update</button>
									</form>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop
