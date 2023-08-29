@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Control Company</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">Control Company</li>
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
                    <div class="card-header">
                        <h3 class="card-title">Company</h3>
                        @can('company.add')
                            <a href="{{ route('companyAdd') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                @lang('global.add')
                            </a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>created_at</th>
                                 
                                    <th class="w-25">@lang('global.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)
                            {{-- @dump($company) --}}
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name_ru }}</td>
                                    <td>{{ $company->created_at  }}</td>
                         
                                    <td class="text-center">
                                        @can('company.delete')
                                            <form action="{{ route('companyDestroy',$company->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('company.edit')
                                                    <a href="{{ route('companyEdit',$company->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="submitButton btn btn-danger btn-sm mx-2"> @lang('global.delete')</button>
                                                </div>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
