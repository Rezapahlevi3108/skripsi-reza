@extends('layouts.main')

@section('content')

    @if ($data->count() > 0 && $data->where('cluster', '!=', 0)->count() > 0)

        <div class="card bg-success-subtle">
            <div class="card-body">
                <h2>Nilai DBI dari hasil clustering ini adalah {{ number_format($dbi, 5) }}</h2>
            </div>
        </div>

        <div class="accordion card mb-3" id="perhitungan">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-perhitungan" aria-expanded="false" aria-controls="collapse-perhitungan">
                        <h3>Proses Perhitungan</h3>
                    </button>
                </h2>
                <div id="collapse-perhitungan" class="accordion-collapse collapse" data-bs-parent="#perhitungan">
                    <div class="accordion-body">

                        {{-- Centroid akhir --}}
                        <div class="accordion card mb-3" id="centroid">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-centroid" aria-expanded="false" aria-controls="collapse-centroid">
                                        <h3>Nilai Centroid Akhir</h3>
                                    </button>
                                </h2>
                                <div id="collapse-centroid" class="accordion-collapse collapse" data-bs-parent="#centroid">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered table-responsive table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Cluster</th>
                                                            <th>SBD</th>
                                                            <th>IPS</th>
                                                            <th>IPA</th>
                                                            <th>BING</th>
                                                            <th>MAT</th>
                                                            <th>PA</th>
                                                            <th>PJOK</th>
                                                            <th>PRA</th>
                                                            <th>BIND</th>
                                                            <th>PKN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($centroids as $cluster => $centroid)
                                                        <tr>
                                                            <td>{{ $cluster }}</td>
                                                            <td>{{ $centroid['sbd'] }}</td>
                                                            <td>{{ $centroid['ips'] }}</td>
                                                            <td>{{ $centroid['ipa'] }}</td>
                                                            <td>{{ $centroid['bing'] }}</td>
                                                            <td>{{ $centroid['mat'] }}</td>
                                                            <td>{{ $centroid['pa'] }}</td>
                                                            <td>{{ $centroid['pjok'] }}</td>
                                                            <td>{{ $centroid['pra'] }}</td>
                                                            <td>{{ $centroid['bind'] }}</td>
                                                            <td>{{ $centroid['pkn'] }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                     
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- SSW --}}
                        <div class="accordion card mb-3" id="ssw">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-ssw" aria-expanded="false" aria-controls="collapse-ssw">
                                        <h3>SSW</h3>
                                    </button>
                                </h2>
                                <div id="collapse-ssw" class="accordion-collapse collapse" data-bs-parent="#ssw">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example2" class="table table-bordered table-responsive table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>NIS</th>
                                                            <th>Nama</th>
                                                            <th>Kelas</th>
                                                            <th>SBD</th>
                                                            <th>IPS</th>
                                                            <th>IPA</th>
                                                            <th>BING</th>
                                                            <th>MAT</th>
                                                            <th>PA</th>
                                                            <th>PJOK</th>
                                                            <th>PRA</th>
                                                            <th>BIND</th>
                                                            <th>PKN</th>
                                                            <th>Cluster</th>
                                                            <th>Jarak data ke Cluster</th>
                                                            <th>SSW</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;?>
                                                        @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $item->nis }}</td>
                                                            <td>{{ $item->nama }}</td>
                                                            <td>{{ $item->kelas }}</td>
                                                            <td>{{ $item->sbd }}</td>
                                                            <td>{{ $item->ips }}</td>
                                                            <td>{{ $item->ipa }}</td>
                                                            <td>{{ $item->bing }}</td>
                                                            <td>{{ $item->mat }}</td>
                                                            <td>{{ $item->pa }}</td>
                                                            <td>{{ $item->pjok }}</td>
                                                            <td>{{ $item->pra }}</td>
                                                            <td>{{ $item->bind }}</td>
                                                            <td>{{ $item->pkn }}</td>
                                                            <td>{{ $item->cluster }}</td>
                                                            <td>{{ number_format($distances[$loop->index]['distance'], 5) }}</td>
                                                            <td>{{ number_format($ssws[$item->cluster], 5) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- SSB --}}
                        <div class="accordion card mb-3" id="ssb">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-ssb" aria-expanded="false" aria-controls="collapse-ssb">
                                        <h3>SSB</h3>
                                    </button>
                                </h2>
                                <div id="collapse-ssb" class="accordion-collapse collapse" data-bs-parent="#ssb">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Cluster i</th>
                                                            <th>Cluster j</th>
                                                            <th>SSB</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ssbs as $clusterI => $ssbsRow)
                                                            @foreach($ssbsRow as $clusterJ => $ssbValue)
                                                            <tr>
                                                                <td>{{ $clusterI }}</td>
                                                                <td>{{ $clusterJ }}</td>
                                                                <td>{{ $ssbValue }}</td>
                                                            </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- MAX Ratio --}}
                        <div class="accordion card mb-3" id="max-ratio">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-max-ratio" aria-expanded="false" aria-controls="collapse-max-ratio">
                                        <h3>MAX Ratio</h3>
                                    </button>
                                </h2>
                                <div id="collapse-max-ratio" class="accordion-collapse collapse" data-bs-parent="#max-ratio">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Cluster</th>
                                                            <th>MAX Ratio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ratios as $cluster => $ratio)
                                                            <tr>
                                                                <td>{{ $cluster }}</td>
                                                                <td>{{ number_format($ratio, 5) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                       
                                    </div>
                                </div>
                            </div>
                        </div>
                                                                
                    </div>
                </div>
            </div>
        </div>

    @elseif ($data->count() == 0)

        <div class="d-flex justify-content-center mb-auto">
            <h2 class="text-secondary">DATA BELUM DI IMPORT</h2>
        </div>

    @else

        <div class="d-flex justify-content-center mb-auto">
            <h2 class="text-secondary">DATA BELUM DI PROSES</h2>
        </div>
    
    @endif

@endsection