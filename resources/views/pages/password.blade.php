@extends('layouts.main')

@section('content')

    @if(session('success'))
        <p class="alert alert-success mx-auto w-50">{{ session('success') }}</p>
    @endif
    @if($errors->any())
        @foreach($errors->all() as $err)
            <p class="alert alert-danger mx-auto w-50">{{ $err }}</p>
        @endforeach
    @endif

    <div class="card mx-auto w-50">

        <div class="card-header">
            <h4>Ubah Password</h4>
        </div>

        <form action="{{ route('password.action') }}" method="POST">
        @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label>Password <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="old_password" />
                </div>
                <div class="mb-3">
                    <label>New Password <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="new_password" />
                </div>
                <div class="mb-3">
                    <label>New Password Confirmation<span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="new_password_confirmation" />
                </div>
            </div>
            <div class="card-footer">    
                <div class="mt-2 mb-2">
                    <button class="btn btn-primary">Change</button>
                    <a class="btn btn-danger" href="{{ route('home') }}">Back</a>
                </div>
            </div>
        </form>
    </div>
    
@endsection