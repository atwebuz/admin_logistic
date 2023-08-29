@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-weight-bold text-xl text-gray-800">{{ __('Dashboard') }}</h2>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="w-100 max-w-lg px-4 py-4 bg-white rounded-lg shadow-xl">
                                <div class="max-w-md mx-auto space-y-6">

                                    <form action="{{ route('answers.store', ['application' => $application]) }}" method="POST">
                                        @csrf
                                        <h2 class="text-2xl font-bold mb-4">Answer application #{{$application->id}}</h2>

                                        <hr class="my-4">
                                        <div class="mb-2">
                                            <label class="text-uppercase text-sm font-weight-bold opacity-70">Answer</label>
                                            <textarea required name="body" cols="30" rows="6" class="form-control rounded"></textarea>
                                        </div>

                                        <div class="d-grid gap-2 mt-4">
                                            <input type="submit" class="btn btn-success" value="Send">
                                            <a href="{{route('dashboard')}}" class="btn btn-danger">Cancel</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
