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
                    <li class="breadcrumb-item"><a href="{{ route('driverIndex') }}">Control Driver</a></li>
                    <li class="breadcrumb-item active">@lang('global.add')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->

<section class="content">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('global.add')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('driverCreate') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <input name="full_name"
                                class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}"
                                value="{{ old('full_name') }}" placeholder="Full name" required />
                            @if($errors->has('full_name') || 1)
                            <span class="error invalid-feedback">{{ $errors->first('full_name') }}</span>
                            @endif
                        </div>



                        <div class="form-group">
                            <label>Введите track_num</label>
                            <div class="input-group mb-3">
                                <input type="text" name="track_num" class="form-control" value="{{ old('track_num') }}"
                                    placeholder="AA 077 F" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Введите eastern_time</label>
                            <div class="input-group mb-3">
                                <input type="text" name="eastern_time" class="form-control"
                                    value="{{ old('eastern_time') }}" placeholder="Eastern time" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Введите Comment</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="comment" cols="30" rows="10"
                                    placeholder="About">{{ old('comment') }}</textarea>
                            </div>
                        </div>


                        {{-- <select class="form-control select2" style="width: 100%;" name="company_id"
                            value="{{ old('company_id') }}" required>
                            @foreach($drivers[0]->tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                        </select> --}}

                        {{-- @dd($drivers[0]->tag) --}}
                        <div class="form-group">
                            <label>DOT & NOT DOT</label>
                            <select class="form-control select2" style="width: 100%;" name="tag" id="">
                                <option value="DOT">DOT</option>
                                <option value="NOT DOT">NOT DOT</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Company</label>
                            <select class="form-control select2" style="width: 100%;" name="company_id"
                                value="{{ old('company_id') }}" required>
                                @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->name_ru}}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                            <a href="{{ route('driverIndex') }}"
                                class="btn btn-default float-left">@lang('global.cancel')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection