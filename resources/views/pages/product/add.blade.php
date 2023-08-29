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
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('taskCreate') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label>Описание</label>
                                    <textarea rows="3" name="description_ru" class="form-control"
                                        value="{{ old('description_ru') }}" required></textarea>
                                </div>
                            </div>
                        </div>

                      


                        <div class="form-group">
                            <div class="row">

                                <div class="col">
                                    <label>Level of task</label>
                                    <select class="form-control select2" style="width: 100%;" name="level"
                                        value="{{ old('level') }}" required>
                                        <option value="hard" class="hard">hard</option>
                                        <option value="middle">middle</option>
                                        <option value="easy">easy</option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label>Category</label>
                                    <select class="form-control select2" style="width: 100%;" name="category_id"
                                        value="{{ old('category_id') }}" required>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name_ru}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        {{-- company and drivers --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Company</label>
                                    <select class="form-control select2" style="width: 100%;" name="company_id"
                                        value="{{ old('company_id') }}" id="company_id" required>
                                        <option value="" disabled selected>Выберите компанию</option>
                                        @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name_ru}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Driver</label>
                                    {{-- @dump($drivers->company_id->full_name) --}}
                                    <select class="form-control select2" style="width: 100%;" name="driver_id"
                                        value="{{ old('driver_id') }}" id="driver_id" required>
                                        <option value="" disabled selected>Выберите водителя</option>
                                    </select>
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <label>Is this an Extra task?</label>
                            <input type="checkbox" name="is_extra" value="1">
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
@section('scripts')
<script>
    $(document).ready(function () {
        $('#company_id').on('change', function () {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: '/drivers/get-drivers-by-company',
                    type: 'GET',
                    data: { company_id: companyId },
                    dataType: 'json',
                    success: function (data) {
                        $('#driver_id').empty();
                        $.each(data, function (key, value) {
                            $('#driver_id').append('<option value="' + value.id + '">' + value.full_name + '</option>');
                        });
                    }
                });
            } else {
                $('#driver_id').empty();
            }
        });
    });
</script>

@endsection