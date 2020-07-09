@extends('layout.main')

@section('title', 'Profile Siswa')

@section('header')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@endsection

@section('container')


		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					@if(session('sukses'))
						<div class="alert alert-success" role="alert">{{session('sukses')}}</div>
					@endif
					@if(session('error'))
						<div class="alert alert-danger" role="alert">{{session('error')}}</div>
					@endif

					@error('nilai')
					<div class="invalid-feedback alert alert-danger">
			          	{{ $message }}
			        </div>
					@enderror
					<div class="panel panel-profile">
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left">
								<!-- PROFILE HEADER -->
								<div class="profile-header">
									<div class="overlay"></div>
									<div class="profile-main">
										<img src="{{$siswa->getAvatar()}}" class="img-circle" alt="Avatar">
										<h3 class="name">{{$siswa->nama_depan}}</h3>
									</div>
									<div class="profile-stat">
										<div class="row">
											<div class="col-md-4 stat-item">
												{{$siswa->mapel->count()}} <span>Mata Pelajaran</span>
											</div>
											<div class="col-md-4 stat-item">
												{{$siswa->rataNilai()}} <span>Rata-Rata Nilai</span>
											</div>
											<div class="col-md-4 stat-item">
												2174 <span>Points</span>
											</div>
										</div>
									</div>
								</div>
								<!-- END PROFILE HEADER -->
								<!-- PROFILE DETAIL -->
								<div class="profile-detail">
									<div class="profile-info">
										<h4 class="heading">Detail Data Profile</h4>
										<ul class="list-unstyled list-justify">
											<li>Jenis Kelamin <span>{{$siswa->jenis_kelamin}}</span></li>
											<li>Agama<span>{{$siswa->agama}}</span></li>
											<li>Alamat<span>{{$siswa->alamat}}</span></li>
										</ul>
									</div>
									<div class="profile-info">
										<h4 class="heading">About</h4>
										<p>Interactively fashion excellent information after distinctive outsourcing.</p>
									</div>
									<div class="text-center"><a href="/siswa/{{$siswa->id}}/edit" class="btn btn-primary">Edit Profile</a></div>
								</div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->
							<!-- RIGHT COLUMN -->
							<div class="profile-right">

								<div class="panel-heading">
									<h3 class="panel-title">Mata Pelajaran</h3>
										<!-- Button trigger modal -->
									<div class="right btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal1">Input Nilai </div>
								</div>
								<!-- AWARDS -->
									<div class="row">
										<div class="panel">
											<div class="panel-body no-padding">
												<table class="table">
													<thead>
														<tr>
															<th>Kode</th>
															<th>Nama</th>
															<th>Semester</th>
															<th>Nilai</th>
															<th>Guru</th>
															<th>Aksi</th>
														</tr>
													</thead>
													<tbody>
														@foreach($siswa->mapel as $mapel)
														<tr>
															<td>{{$mapel->kode}}</td>
															<td>{{$mapel->nama}}</td>
															<td>{{$mapel->semester}}</td>
															<td><a href="#" class="nilai" data-type="text" data-pk="{{$mapel->id}}" data-url="/api/siswa/{{$siswa->id}}/editnilai" data-title="Inputkan Nilai">{{$mapel->pivot->nilai}}</a></td>
															<td><a href="/guru/{{$mapel->guru_id}}/profile">{{$mapel->guru->nama}}</a></td>
															<td><a href="/siswa/{{$siswa->id}}/{{$mapel->id}}/deletenilai" class="btn btn-danger btn-sm">Delete</a></td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
								
									<div class="panel">
									<div id="chartNilai"></div>
									</div>
								</div>
								</div>
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>


		<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Input Nilai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/siswa/{{$siswa->id}}/addnilai" method="POST" enctype="multipart/form-data">
			 {{csrf_field()}}
			<div class="form-group">
			    <label for="exampleFormControlSelect1">Mata Pelajaran</label>
			    <select class="form-control" id="mapel" name="mapel">
			      @foreach($matapelajaran as $mp)
			      <option value="{{$mp->id}}">{{$mp->nama}}</option>
			      @endforeach
			    </select>
			 </div>
			<div class="form-group {{$errors->has('nilai') ? 'has-error' : ''}}">
				<label for="exampleInputEmail1">Nilai</label>
				<input name="nilai" type="number" class="form-control @error('nilai') is-invalid @enderror" id="exampleInputEmail1" placeholder="Inputkan Nilai" value="{{old('nilai')}}">
				@if($errors->has('nilai'))
				<span class="help-block">{{$errors->first('nilai')}}</span>
				@endif
			</div>
			<div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>
		</form>	
      </div>

    </div>
  </div>
</div>


@endsection

@section('footer')
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
	Highcharts.chart('chartNilai', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Laporan Nilai Siswa'
	    },
	    
	    xAxis: {
	        categories: {!!json_encode($categories)!!},
	        crosshair: true
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: 'Nilai'
	        }
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: 'Nilai',
	        data: {!!json_encode($data)!!}

	    }]
	});
	$(document).ready(function() {
    $('.nilai').editable();
});
</script>
@endsection