<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <h1>Recircled Dashboard</h1> --}}
         <h1>{{ __('message.recircled_dashboard') }}</h1>
       {{-- {{ __('message.Recircled_Dashboard') }} --}}
        {{-- languages changes --}}
        {{ __('message.welcome') }}
        <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('message.users') }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('message.total_users') }}</h5>
                        <p class="card-text">100</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                       {{ __('message.products') }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('message.total_products') }}</h5>
                        <p class="card-text">50</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        {{-- <table id="dataTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
@endsection


