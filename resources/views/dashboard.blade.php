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

        <h2 class="text-3xl mt-8">
            @if ($totalToday)

            You've worked <span class="font-black text-teal-500">{{ $totalToday }}</span> hours today.
            @else
                Today is empty. Maybe you forgot to track your time? 🤔
            @endif

        </h2>

        <tracking-table :rows='@json($todayRegisters)'></tracking-table>

    </div>
@endsection
