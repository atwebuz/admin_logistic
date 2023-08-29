@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="font-weight-bold text-xl text-gray-800">{{ __('My Applications') }}</h2>
        </div>

        <div class="py-4">
            <div class="card">
                <div class="card-body">
                    @foreach($applications as $application)
                        <div class="d-flex flex-column justify-content-center p-4 mt-4">
                            <div class="card rounded-xl border p-5 shadow-sm bg-white">
                                <div class="d-flex justify-content-between border-bottom pb-3">
                                    <div class="d-flex align-items-center space-x-3">
                                        <div class="rounded-circle bg-slate-400 bg-[url('https://i.pravatar.cc/32')]"  ></div>
                                        <button class="btn btn-sm btn-secondary rounded-2xl mr-2">{{ __('id') }}: {{$application->id}}</button>
                                        <div class="text-lg font-weight-bold text-slate-700">{{$application->user->name}}</div>
                                    </div>
                                    <div class="d-flex align-items-center space-x-4">
                                        <a href="mailto:{{$application->user->email}}" class="text-gray-500">
                                            {{$application->user->email}}
                                        </a>
                                    </div>
                                </div>

                                <div class="mt-4 mb-6 d-flex justify-content-between">
                                    <div>
                                        <div class="mb-3 text-xl font-weight-bold">
                                            {{$application->subject}}
                                        </div>
                                        <div class="text-sm text-muted">
                                            {{$application->message}}
                                        </div>
                                        <div class="text-sm text-muted">
                                            {{$application->created_at}}
                                        </div>
                                    </div>

                                    <div class="border p-4 rounded hover-bg-gray-100 transition cursor-pointer">
                                        @if(is_null($application->file_url))
                                        <a href="#">
                                            <i class="fas fa-times"></i>

                                        </a>
                                        @else
                                            <a href="{{ asset('storage/'.$application->file_url) }}" target="_blank">
                                                    <i class="fas fa-file" style="color: black; margin: auto; display:flex; font-size: 34px" ></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                @if($application->answer()->exists())
                                    <span class="font-weight-bold">{{ __('Answer') }}:</span>
                                    <p class="text-success"> {{$application->answer->body}}</p>
                                @else
                                    @if(auth()->user()->role->name == 'Manager')
                                        <div class="d-flex">
                                            <a href="{{route('answers.create', ['application' => $application->id])}}"
                                                type="button"
                                                class="btn btn-primary btn-sm my-2"
                                            >
                                                {{ __('Answer') }}
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
