@extends('layouts.main')

@section('content')

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($data->count() == 0)

        <div class="card w-50 mx-auto">
            <div class="card-header">
                <h4>Import Data</h4>
            </div>
            <div class="card-body">
                <form action="/data-import" method="post" enctype="multipart/form-data">
                    @csrf
                    <span class="text-danger">*Hanya mendukung tipe file .xlsx</span>
                    <input type="file" name="file" class="form-control mb-3" style="border: #3c413e 1px solid">
                    <button class="btn btn-secondary" type="submit">Import Data</button>
                </form>
            </div>
        </div>

    @else

        <div class="card">
            <div class="card-header p-3">
                <button type="button" class="btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">Hapus Semua Data</button>
            </div>
            
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                            <tr>
                                <td>{{ $index + $data->firstItem() }}</td>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table><br>
                <div class="float-right">{{ $data->links() }}</div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">DELETE</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="">Anda yakin ingin menghapus semua data?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                        <form action="{{ route('delete-data') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger float-right">Delete Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    @endif

@endsection