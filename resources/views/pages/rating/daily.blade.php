@extends('layouts.admin')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control Ratings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Control Ratings</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ratings</h3>
                </div>
                <div class="card-body">
                    <table id="dataTable"
                        class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                        role="grid" aria-describedby="dataTable_info">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>email</th>
                                <th>Category name</th>
                                <th>Ball</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalDefaultQuantity = 0;
                            @endphp
                            @foreach($ratings as $rating)
                            @if(auth()->user()->id == $rating->user_id)
                            @php
                            $totalDefaultQuantity += $rating->order->product->category->default_quantity;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $rating->user->name }}
                                </td>
                                <td> 
                                    {{ $rating->user->email }}
                                </td>
                                <td>{{$rating->order->product->category->name_ru}}</td>
                                <td>{{$rating->order->product->category->default_quantity}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <p class="text-center">Umumiy bal: <b> {{ $totalDefaultQuantity }} </b></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 