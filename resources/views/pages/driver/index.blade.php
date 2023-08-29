@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control Driver</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Control Driver</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-hear">
                    <h3 class="card-title">Driver</h3>
                    @can('driver.add')
                    <a href="{{ route('driverAdd') }}" class="btn btn-success btn-sm float-right">
                        <span class="fas fa-plus-circle"></span>
                        @lang('global.add')
                    </a>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- @dump($drivers[0]->full_name) --}}
                    {{-- @foreach($drivers as $driver)
                    @if (session('warning'))
                    <div class="alert alert-warning">
                        {{$driver->full_name}} {{ session('warning') }}
                    </div>
                    @elseif (isset($message))
                    <div class="alert alert-{{ $daysRemaining > 8 ? 'success' : 'warning' }}">
                        {{ $message }}
                    </div>
                    @endif

                    @endforeach --}}
                    {{-- @dd($daysRemaining) --}}

                    <!-- Data table -->
                    <table id="dataTable"
                        class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid"
                        aria-describedby="dataTable_info">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>full_name</th>
                                <th>track_num</th>
                                <th>company name</th>
                                <th>Eastern time</th>
                                <th>DOT & NOT DOT</th>
                                <th>Accessible</th>
                                <th class="w-20">@lang('global.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $driver)
                            {{-- @dump($driver->tags[0]->name) --}}
                            <tr>
                                <td>{{ $driver->id }}</td>
                                <td>{{ $driver->full_name }}</td>
                                <td>{{ $driver->track_num }}</td>
                                <td>{{ $driver->company->name_ru}}</td>
                                <td>{{ $driver->eastern_time}}</td>
                                <td>{{ $driver->tag}}</td>

                                <td>

                                    @if ($driver->canBeEdited())
                                    @if ($driver->daysRemaining <= 0) <div class="alert alert-success py-1 ">
                                        {{ __('Accessible to edit') }}
                </div>
                @else
                <div class="alert alert-{{ $driver->daysRemaining > 8 ? 'success' : 'warning' }}">
                    {{ $driver->message }}
                </div>
                @endif
                @else
                <div class="alert alert-warning">
                    {{ __('Driver is blocked and cannot be edited.') }}
                    {{$driver->blocked_until}}
                </div>
                @endif
                </td>

                <td class="text-center d-flex">
                    @can('driver.delete')
                    <form action="{{ route('driverDestroy', $driver->id) }}" method="post">
                        @csrf
                        <div class="btn-group">
                            @can('driver.edit')
                            <a href="{{ route('driverEdit', $driver->id) }}" type="button"
                                class="btn btn-info btn-sm">@lang('global.edit')</a>
                            @endcan
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="button"
                                class="submitButton btn btn-danger btn-sm mx-2">@lang('global.delete')</button>
                        </div>
                    </form>
                    @endcan
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#exampleModal_{{ $driver->id }}">
                        Details
                    </button>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>

                {{-- Modal start --}}
                @foreach($drivers as $driver)


                <div class="modal fade" id="exampleModal_{{ $driver->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Order № {{$loop->iteration}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td style="width: 40%">Driver Name:</td>
                                            <td>
                                                <b>{{$driver->full_name}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Track Num:</td>
                                            <td>
                                                <b>{{$driver->track_num}}</b>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Company Name:</td>
                                            <td>
                                                <b>{{$driver->company->name_ru}}</b>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Eastern time:</td>
                                            <td>
                                                <b>
                                                    {{$driver->eastern_time}}
                                                </b>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>

                                <br>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tag</th>
                                            <th>Is Block</th>
                                            <th>created_at</th>
                                            <th>updated_at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="@if($driver->tag === 'DOT') bg-warning @elseif($driver->tag === 'NOT DOT') bg-success @endif">
                                                {{$driver->tag}}</td>
                                            <td>
                                                {{ isset($driver->blocked_until) ?
                                                $driver->blocked_until : 'Accessible'}}

                                            </td>
                                            <td>
                                                {{ $driver->created_at }}

                                            </td>
                                            <td>
                                                {{ $driver->updated_at }}
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>

                                <p><strong>Driver-Comment: </strong>
                                    {{$driver->comment}}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                @auth

                                @if(auth()->user()->roles[0]->name == 'Employee')

                                @php
                                $isdriverInOrder = auth()->user()->orders()->where('driver_id',
                                $driver->id)->exists();
                                @endphp
                                <form action="{{ route('submit.order', $driver->id) }}" method="post">
                                    @csrf
                                    <div class="btn-group">
                                        <input name="_method" type="hidden" value="POST">



                                        @if($isdriverInOrder)
                                        <button type="button" class="btn btn-success btn-sm py-2"
                                            disabled>Submited</button>
                                        @else
                                        <button class="btn btn-success btn-sm py-2">Submits</button>
                                        @endif

                                    </div>
                                </form>



                                @endif
                                @endauth
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                @endforeach
                {{-- Modal end --}}

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection