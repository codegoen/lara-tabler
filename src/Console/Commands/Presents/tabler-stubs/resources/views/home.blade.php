<x-app-layout title="Welcome Back {{ auth()->user()->name }}">
    @section('content')
        You are logged in!
    @stop
</x-app-layout>
