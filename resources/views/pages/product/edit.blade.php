@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control tasks</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('taskIndex') }}">Control tasks</a></li>
                    <li class="breadcrumb-item active">@lang('global.edit')</li>
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
                    <h3 class="card-title">@lang('global.edit')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('taskUpdate',$product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label>Описание</label>
                                    <textarea rows="3" name="description_ru" class="form-control"
                                        value="{{ old('description_ru', $product->description_ru) }}"
                                        >{{ $product->description_ru }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="price">
                            <div class="row">

                                <div class="col">
                                    <label>Level of task</label>
                                    <select class="form-control select2" style="width: 100%;" name="level"
                                        value="{{ old('level', $product->level) }}" required>
                                        <option value="hard" class="hard">hard</option>
                                        <option value="middle">middle</option>
                                        <option value="easy">easy</option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label>Category</label>
                                    <select class="form-control select2" style="width: 100%;" name="category_id"
                                        value="{{ old('category_id',$product->category_id) }}" required>
                                        @foreach($categories as $category)
                                        <option @if($product->category_id == $category->id) {{'selected'}} @endif
                                            value="{{$category->id}}" >{{" ".$category->name_ru}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="price">
                            <div class="row">
                                <div class="col">
                                    <label>Companies</label>
                                    <select class="form-control select2" style="width: 100%;" name="company_id"
                                        value="{{ old('company_id',$product->company_id) }}" required>
                                        @foreach($companies as $company)
                                        <option @if($product->company_id == $company->id) {{'selected'}} @endif
                                            value="{{$company->id}}" >{{" ".$company->name_ru}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Drivers</label>
                                    <select class="form-control select2" style="width: 100%;" name="driver_id"
                                        value="{{ old('driver_id',$product->driver_id) }}" required>
                                        @foreach($drivers as $driver)
                                        <option @if($product->driver_id == $driver->id) {{'selected'}} @endif
                                            value="{{$driver->id}}" >{{" ".$driver->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is this an Extra task?</label>
                            <input type="checkbox" name="is_extra" {{ old('is_extra', $product->is_extra) ? 'checked' : '' }}>
                        </div>


                        <div class="form-group ">
                            <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                            <a href="{{ route('taskIndex') }}"
                                class="btn btn-default float-left">@lang('global.cancel')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection