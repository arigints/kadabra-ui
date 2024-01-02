@extends('template.main')
@section('title','About Ragno')
@section('content')
<div class="row">
	<div class="col-md-12">
		<h2 class="az-dashboard-title">Apa itu KADABRA Stats (RAGNO)?</h2>
		<p class="az-dashboard-text">RAGNO adalah microservices dari KADABRA RIS (Routing Information Services). Tugas dari microservice ini adalah untuk melakukan pengumpulan data dari RIS. Data tersebut akan diolah untuk menghasilkan statistik data yang terdiri dari :</p>

		<ul>
			<li>Pertumbuhan nomor PI (protokol internet) versi 4 dan versi 6 (estimasi harian)</li>
			<li>Pertumbuhan Autonomous System Number (ASN) (estimasi harian)</li>
			<li>Perkembangan RPKI di monitor melalui ROA Status yang dikumpulkan oleh RIS</li>
		</ul>

		<h2 class="az-dashboard-title">Bagaimana cara RAGNO mengumpulkan data?</h2>
		<p>RAGNO mengumpulkan data "hampir" sama dengan waktu yang sebenarnya (realtime). RAGNO sebagai layanan microservices hanya akan mengumpulkan data yang telah terkoneksi dan termonitor dengan KADABRA (lihat <a href="https://ris.kadabra.id/pages/bergabung-dengan-kadabra" target="_blank">bagaimana cara terkoneksi dengan KADABRA</a>). Setiap nomor protokol internet tersebut akan disimpan, diperiksa secara paralel, dan diklasifikasikan berdasarkan apakah data tersebut baru, memiliki roa invalid, unknown, atau valid.</p>

		<p>Data yang ditampilkan oleh RAGNO merupakan data ringkasan estimasi harian (estimated daily summary) untuk seluruh sumberdaya (resources) sesuai dengan informasi data di atas. </p>

<p>Apabila ada pertanyaan terkait statistik ini, silakan hubungi ke <a href="javascript:location='mailto:\u0073\u0065\u006b\u0072\u0065\u0074\u0061\u0072\u0069\u0061\u0074\u0040\u0069\u0064\u006e\u0069\u0063\u002e\u006e\u0065\u0074';void 0"><script type="text/javascript">document.write('\u0073\u0065\u006b\u0072\u0065\u0074\u0061\u0072\u0069\u0061\u0074\u0040\u0069\u0064\u006e\u0069\u0063\u002e\u006e\u0065\u0074')</script></a> untuk informasi lebih lanjut.</p>
	</div>
</div>
@endsection