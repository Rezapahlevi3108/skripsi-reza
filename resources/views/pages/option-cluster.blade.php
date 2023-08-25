@extends('layouts.main')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4>Tentukan Jumlah Cluster</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('setCluster') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Jumlah Cluster</label>
                    <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Isi jumlah cluster" name="clusters"  required>
                </div>
                <button type="submit" class="btn btn-primary ps-5 pe-5">Proses</button>
            </form>         
        </div>
    </div>

@endsection
