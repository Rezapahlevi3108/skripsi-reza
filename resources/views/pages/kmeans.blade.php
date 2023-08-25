@extends('layouts.main')

@section('content')

    @if($results->count() > 0 && $results->where('cluster', '!=', 0)->count() > 0)

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="row">
            <div class="col-md-6">
                <a href="/data-export" class="btn btn-primary ps-5 pe-5 pt-2 pb-2 mb-3">
                    Export Data
                </a>
                <div class="card">
                    <div class="card-header">
                        <h3>Hasil K-Means Clustering</h3>
                    </div>
                    
                    <div class="card-body">    
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Cluster</th>
                                    <th>Jumlah Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clusterCounts as $cluster => $count)
                                    <tr>
                                        <td>{{ $cluster }}</td>
                                        <td>{{ $count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <canvas id="clusterChart"></canvas>
            </div>
            <div class="col-md-1"></div>
        </div>

        {{-- Hasil Clustering --}}
        @foreach ($clusterCounts as $cluster => $count)
            <div class="accordion card mb-3" id="accordion-cluster-{{ $cluster }}">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cluster-{{ $cluster }}" aria-expanded="false" aria-controls="cluster-{{ $cluster }}">
                            <h3>Data Cluster {{ $cluster }}</h3>
                        </button>
                    </h2>
                    <div id="cluster-{{ $cluster }}" class="accordion-collapse collapse" data-bs-parent="#accordion-cluster-{{ $cluster }}">
                        <div class="accordion-body">
                            <div class="card">
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
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
                                                <th>cluster</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <?php $no = 1;?>
                                            @foreach ($results as $item)
                                                <tr>
                                                    @if ($item->cluster == $cluster)
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
                                                    @endif
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
        @endforeach

        <div class="accordion card mb-3" id="accordionIteration">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#iteration" aria-expanded="false" aria-controls="iteration">
                        <h3>Proses Perhitungan</h3>
                    </button>
                </h2>
                <div id="iteration" class="accordion-collapse collapse" data-bs-parent="#accordionIteration">
                    <div class="accordion-body">

                        {{-- Hasil perhitungan tiap iterasi --}}
                        @foreach ($distances as $iteration => $row)
                            <div class="accordion card mb-3" id="accordion-detail-iteration{{ $iteration + 1 }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#detail-iteration{{ $iteration + 1 }}" aria-expanded="false" aria-controls="detail-iteration{{ $iteration + 1 }}">
                                            <h3>Iterasi ke-{{ $iteration + 1 }}</h3>
                                        </button>
                                    </h2>
                                    <div id="detail-iteration{{ $iteration + 1 }}" class="accordion-collapse collapse" data-bs-parent="#detail-iteration{{ $iteration + 1 }}">
                                        <div class="accordion-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>NIS</th>
                                                                <th>Nama</th>
                                                                <th>Kelas</th>
                                                                @for ($j = 0; $j < $k; $j++)
                                                                    <th>Jarak ke C{{ $j+1 }}</th>
                                                                @endfor
                                                                <th>Cluster Terdekat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($row as $key => $column)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $data[$key]->nis }}</td>
                                                                    <td>{{ $data[$key]->nama }}</td>
                                                                    <td>{{ $data[$key]->kelas }}</td>
                                                                    @foreach ($column as $distance)
                                                                        <td>{{ number_format($distance, 5) }}</td>
                                                                    @endforeach
                                                                    <td>{{ $clusters[$iteration][$key] }}</td>
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
                        @endforeach

                        {{-- Rangkuman hasil perhitungan tiap iterasi --}}
                        <div class="accordion card mb-3" id="accordion-rangkuman">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rangkuman" aria-expanded="false" aria-controls="rangkuman">
                                        <h3>Rangkuman cluster tiap iterasi</h3>
                                    </button>
                                </h2>
                                <div id="rangkuman" class="accordion-collapse collapse" data-bs-parent="#accordion-rangkuman">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body"> 
                                                <table id="example2" class="table table-bordered table-responsive">
                                                    <tbody>
                                                        @foreach ($clusters as $iteration => $clusterData)
                                                            <tr>
                                                                <td>Iterasi ke-{{ $iteration + 1 }}</td>
                                                                @foreach ($data as $item)
                                                                    <td>{{ $clusterData[$item->id - 1] }}</td>
                                                                @endforeach
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

        <script>
            // Ambil nilai clusterCounts dari PHP
            var clusterCounts = {!! json_encode($clusterCounts) !!};
    
            // Konversi clusterCounts ke array labels dan data
            var labels = Object.keys(clusterCounts);
            var data = Object.values(clusterCounts);
    
            labels = labels.map(function(label) {
                return "Cluster " + label;
            });
    
            // Buat chart pie menggunakan Chart.js
            var ctx = document.getElementById('clusterChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Data',
                        data: data,
                        backgroundColor: [
                            '#D35400',
                            '#F1C40F ',
                            '#1ABC9C',
                            '#3498DB ',
                            '#8E44AD',,
                            '#E67E22'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                            align: 'start',
                            labels: {
                                boxWidth: 12,
                            }
                        }
                    }
                }
            });
        </script>

    @elseif ($results->count() == 0)

        <div class="d-flex justify-content-center mb-auto">
            <h2 class="text-secondary">DATA BELUM DI IMPORT</h2>
        </div>    

    @else

        <div class="d-flex justify-content-center mb-auto">
            <h2 class="text-secondary">DATA BELUM DI PROSES</h2>
        </div>

    @endif

@endsection