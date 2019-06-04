@extends('layouts.app')

@section('content')


    <form class="card" method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="card-title">{{ __('Login') }}</h1>

        <div class="card-row">
            <div class="form-input-container">
                <label class="form-input-label" for="email">
                    E-mail
                </label>
                <input class="form-input @error('email') form-input-error @enderror" name="email" id="email" type="email"
                       placeholder="bobafett@mandalorian.sw">
                @error('email')
                <p class="form-input-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input-container">
                <label class="form-input-label" for="password">
                    Password
                </label>
                <input class="form-input @error('password') form-input-error @enderror" name="password" id="password" type="password" placeholder="**************">
                @error('password')
                <p class="form-input-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 mx-auto">
                <label class="form-input-label" for="">&nbsp;</label>
                <button class="button button-block block w-full">
                    LOGIN
                </button>
            </div>
        </div>
    </form>
@endsection
