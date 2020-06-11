@extends('tabler::layouts.app')

@section('content')
    <div class="container mt-3">
        <form method="post" action="{{ route('rizkhal.request.create') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="form-header mb-3">
                        @if (session()->has('message'))
                            <x-alert type="{{session()->get('type')}}" dismiss="true">{{session()->get('message')}}</x-alert>
                        @endif
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-warning ml-2">Reset</button>
                    </div>
                    @include("tabler::partials.request")
                </div>
            </div>
        </form>
    </div>
@stop
