@extends('layout.main')

@section('title', 'web anu')

@section('container')
	<div class="main">
		<div class="main-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Rangking 5 Besar</h3>
							</div>
							<div class="panel-body no-padding">
								<table class="table">
									<thead>
										<tr>
											<th>Rangking</th>
											<th>Nama</th>
											<th>Nilai</th>
										</tr>
									</thead>
									<tbody>
										@foreach(rangkingBesar() as $s)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td>{{$s->nama_lengkap()}}</td>
											<td>{{$s->rataNilai}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="metric">
							<span class="icon"><i class="fa fa-user"></i></span>
							<p>
								<span class="number">{{totalSiswa()}}</span>
								<span class="title">Total Siswa</span>
							</p>
						</div>
					</div>
					<div class="col-md-3">
						<div class="metric">
							<span class="icon"><i class="fa fa-user"></i></span>
							<p>
								<span class="number">{{totalGuru()}}</span>
								<span class="title">Total Guru</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection