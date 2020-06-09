@extends('tabler::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Basic form</h3>
                </div>
                <div class="card-body">
                  <form method="post" action="{{ route('tabler.store') }}">
                    @csrf
                    <div class="form-group mb-3 ">
                      <label class="form-label">Model Name</label>
                        <input type="text" class="form-control" name="model">
                        @error('model')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group mb-3 ">
                      <label class="form-label">Controller Name</label>
                        <input type="text" class="form-control" name="controller">
                    </div>
                    <div class="form-footer border-top">
                      <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
@stop
