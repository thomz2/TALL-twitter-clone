@extends('layouts.app')

@section('content')
    <div>
        @livewire('update-user-form', ["user" => $user])
    </div>
@endsection