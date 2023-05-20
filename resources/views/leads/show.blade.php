@extends('theme')

@section('content')
    <dl class="row">
        <dt class="col-sm-3">{{ __('Name') }}</dt>
        <dd class="col-sm-9">{{ $lead->name }}</dd>
    
        <dt class="col-sm-3">{{ __('Email') }}</dt>
        <dd class="col-sm-9">{{ $lead->email }}</dd>

        <dt class="col-sm-3">{{ __('Phone') }}</dt>
        <dd class="col-sm-9">{{ $lead->phone }}</dd>
    </dl>

    <a href="{{ route('lead.create') }}" class="btn btn-secondary">{{ __('Go back') }}</a>
    <a href="{{ route('lead.edit', ['lead' => $lead->id]) }}" class="btn btn-primary">{{ __('Edit lead') }}</a>
@endsection