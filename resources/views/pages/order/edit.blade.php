@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Order User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orderIndex') }}">Control orders</a></li>
                    <li class="breadcrumb-item active">Edit Order User</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->roles[0]->name != 'Employee')
                    <form method="POST" action="{{ route('orderUpdate', ['order_id' => $order->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="user_id">Select User</label>
                            <select class="form-control select2" id="user_id" name="user_id">
                                @foreach($users as $user)
                                    @if(!$user->hasRole('Manager') && !$user->hasRole('Super Admin'))
                                        <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                    @else
                    <p>You don't have the permission to change the employer.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

{{-- @extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Order</h1>
        <!-- Your form for editing the order goes here -->
    </div>
@endsection --}}
