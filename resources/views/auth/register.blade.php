@extends('layouts.app')

@section('content')


    <form class="card" method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="card-title">{{ __('Register') }}</h1>

        <div class="card-row">
            <div class="form-input-container mb-6 md:mb-0">
                <label class="form-input-label" for="name">
                    Name
                </label>
                <input class="form-input @error('name') form-input-error @enderror" id="name" type="text"
                       placeholder="Boba Fett" value="{{ old('name') }}" autofocus>
                @error('name')
                <p class="form-input-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input-container">
                <label class="form-input-label" for="email">
                    E-mail
                </label>
                <input class="form-input @error('email') form-input-error @enderror" id="email" type="email"
                       placeholder="bobafett@mandalorian.sw">
                @error('email')
                <p class="form-input-error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="card-row">
            <div class="form-input-container">
                <label class="form-input-label" for="password">
                    Password
                </label>
                <input class="form-input @error('password') form-input-error @enderror" id="password" type="password" placeholder="**************">
                @error('password')
                <p class="form-input-error-message">{{ $message }}</p>
                @else
                    <p class="text-gray-600 text-xs italic">Make it as long and as crazy as you'd like</p>
                @enderror
            </div>
            <div class="form-input-container">
                <label class="form-input-label" for="password-confirmation">
                    Repeat Password
                </label>
                <input class="form-input @error('password-confirmation') form-input-error @enderror" id="password-confirmation" type="password" placeholder="**************">
            </div>
        </div>
        <div class="card-row">
            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="form-input-label" for="city">
                    City
                </label>
                <input class="form-input" id="city" type="text" placeholder="Coruscant">
            </div>
            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="form-input-label" for="timezone">
                    Time Zone
                </label>
                <div class="relative">
                    <select class="form-input" id="timezone">
                        @foreach(timezone_identifiers_list() as $text)
                            <option value="{{ $text }}">{{ $text }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="form-input-label" for="">&nbsp;</label>
                <button class="button button-block block w-full">
                    REGISTER
                </button>
            </div>
        </div>
    </form>
@endsection
