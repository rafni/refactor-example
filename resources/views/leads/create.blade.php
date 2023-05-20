@extends('theme')

@section('content')
    <form method="POST" action="{{ route('lead.store') }}">
        {{ csrf_field() }}
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">{{ __('Phone') }}</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Create lead') }}</button>
    </form>
@endsection
