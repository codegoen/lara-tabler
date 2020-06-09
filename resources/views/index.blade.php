@extends('tabler::layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{ route('tabler.create') }}">
            @csrf
            <div class="row">
                <div class="form-header mb-3">
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                    <button type="button" class="btn btn-warning mt-3 ml-2">Reset</button>
                </div>
                @include("tabler::partials.model")
                @include("tabler::partials.controller")
                @include("tabler::partials.request")
            </div>
        </form>
    </div>
@stop
