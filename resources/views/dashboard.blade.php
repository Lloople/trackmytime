@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-title w-full block">
            <span class="float-left">Welcome, {{ auth()->user()->name }} 👋</span>
            <toggle-button class="float-right align-middle" tracking="{{ auth()->user()->tracking_since ?? '' }}"></toggle-button>
        </div>
        <div class="clearfix"></div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <dashboard :rows='@json($todayRegisters)' day="{{ now()->format('Y-m-d') }}"></dashboard>
    </div>
@endsection
