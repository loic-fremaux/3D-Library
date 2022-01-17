@extends('layout')

@livewireScripts
@livewireStyles

@section('content')

    <h1 class="text-3xl font-bold text-white sm:text-3xl sm:truncate mx-24 my-8">3D Library</h1>

    @livewire('components-table', compact('models'))

@endsection
