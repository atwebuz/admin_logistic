        @extends('layouts.admin')

        @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session()->has('error'))
                                <div class="alert alert-danger">{{ session()->get('error') }}</div>
                            @endif
                            @if(auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Manager' )
                                <h2 class="text-center mb-4">{{ __("Manager") }}</h2>

                                @foreach($applications as $application)
                                    <div class="d-flex justify-content-center p-4 mt-4">
                                        <div class="card rounded-xl border p-5 shadow-md w-75 bg-white">
                                            <div class="d-flex w-100 justify-content-between border-bottom pb-3">
                                                <div class="d-flex align-items-center space-x-3">
                                                    <div class="rounded-circle bg-slate-400"  ></div>
                                                    <button class="btn btn-secondary rounded-2xl mr-2">{{ __('id') }}: {{ $application->id }}</button>
                                                    <div class="text-lg font-weight-bold text-slate-700">{{ $application->user->name }}</div>
                                                </div>
                                                <div class="d-flex align-items-center space-x-4">
                                                    <a href="mailto:{{ $application->user->email }}" class="text-gray-500">
                                                        {{ $application->user->email }}
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="mt-4 mb-6 d-flex justify-content-between">
                                                <div>
                                                    <div class="mb-3 text-xl font-weight-bold">
                                                        {{ $application->subject }}
                                                    </div>
                                                    <div class="text-sm text-muted">
                                                        {{ $application->message }}
                                                    </div>
                                                    <div class="text-sm text-muted">
                                                        {{ $application->created_at }}
                                                    </div>
                                                </div>
                                                {{-- @dd($application->file_url) --}}
                                                <div class="d-flex mb-3">
                                                    @if(is_null($application->file_url))
                                                        <a href="#" >
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
                                            {{-- @dd($application); --}}
                                                <span class="font-weight-bold">Answer:</span>
                                                <p class="text-success"> {{$application->answer->body}}</p>
                                            @else
                                                <div class="d-flex">
                                                    <a href="{{ route('answers.store', ['application' => $application->id]) }}" type="button" class="btn btn-primary btn-sm my-2">{{ __('Answer') }}</a>

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                               
                                    @endforeach


                        

                                {{ $applications->links() }}

                            @else

                                <h2 class="text-center mb-4">{{ __("Client") }}</h2>

                                <div class="d-flex justify-content-center">
                                    <div class="card w-75 max-w-lg px-4 py-4 mx-auto bg-white rounded-lg shadow-xl">
                                        <div class="max-w-md mx-auto space-y-6">
                                            <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <h2 class="text-2xl font-bold mb-4">{{ __("Submit your application") }}</h2>
                                                <hr class="my-4">
                                                <label class="text-uppercase text-sm font-weight-bold opacity-70">{{ __("Subject") }}</label>
                                                <input required name="subject" type="text" class="form-control rounded">

                                                <hr class="my-4">
                                                <label class="text-uppercase text-sm font-weight-bold opacity-70">{{ __("Text Area") }}</label>
                                                <textarea required name="message" cols="30" rows="10" class="form-control rounded"></textarea>

                                                <label class="text-uppercase text-sm font-weight-bold opacity-70">{{ __("File Upload") }}</label>
                                                <input name="file" type="file" class="form-control rounded">

                                                <div class="d-grid gap-2 mt-4">
                                                    <input type="submit" class="btn btn-success" value="{{ __('Send') }}">

                                                    {{-- <a class="btn btn-primary" href="/applications">My Apps</a> --}}
                                                    @foreach($applications as $application)
                                                    @if($application->user_id == auth()->user()->id)
                                                        @if($application->answer()->exists())
                                                            <a class="btn btn-primary" href="{{route('applications')}}">My Apps</a>
                                                        @else
                                                            <a class="btn btn-primary disabled">The admin has not answered yet</a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
