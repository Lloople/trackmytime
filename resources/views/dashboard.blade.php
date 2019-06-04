@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-title">Welcome, {{ auth()->user()->name }} 👋</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h2 class="text-3xl mt-8">You've worked <span class="font-black text-teal-500">{{ $totalToday }}</span> hours today.</h2>

            <table class="table table-auto w-full mt-8 table-stripped">
                <thead>
                    <tr>
                        <th class="w-1/5">Begin</th>
                        <th class="w-1/5">End</th>
                        <th class="w-1/5">Duration</th>
                        <th class="w-2/5">Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todayRegisters as $todayRegister)
                        <tr>
                            <td>{{ $todayRegister->start_at->format('H:i') }}</td>
                            <td>{{ $todayRegister->end_at->format('H:i') }}</td>
                            <td>{{ $todayRegister->duration_for_humans }}</td>
                            <td>{{ $todayRegister->comment }}</td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <th class="table-header">{{ App\Models\Timesheet::durationForHumans($todayRegisters->sum('duration')) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
