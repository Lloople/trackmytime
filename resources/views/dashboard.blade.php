@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-title">Welcome, {{ auth()->user()->name }} 👋</div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h2 class="text-3xl mt-8">
            @if ($totalToday)

            You've worked <span class="font-black text-teal-500">{{ $totalToday }}</span> hours
            today.
            @else
                Today is empty. Maybe you forgot to track your time? 🤔
            @endif

        </h2>

        <tracking-table :rows='@json($todayRegisters)'></tracking-table>

    </div>
@endsection
