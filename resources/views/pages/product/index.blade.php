@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control Task</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Control Task</li>
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
                    <h3 class="card-title">Продукты</h3>
                    @can('task.add')
                    <a href="{{ route('taskAdd') }}" class="btn btn-success btn-sm float-right">
                        <span class="fas fa-plus-circle"></span>
                        @lang('global.add')
                    </a>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <button>
                        <a href="{{ route('extraTaskView') }}">View Extra Tasks</a>

                    </button> --}}
                    <!-- Data table -->
                    <table id="dataTable"
                        class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid"
                        aria-describedby="dataTable_info">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company name</th>
                                <th>Driver name</th>
                                <th>Category</th>
                                <th>Task name</th>
                                <th>Task level</th>
                                <th>Ball</th>
                                <th>Deadline</th>

                                <th>Activate</th>
                                <th class="w-25">@lang('global.actions')</th>
                                @if(auth()->user()->roles[0]->name != 'Employee')

                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sortedProducts as $product)
                                @if ($product->is_extra != 1)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ isset($product->company->name_ru) ? $product->company->name_ru : 'Deleted' }}
                                        </td>
                                        <td>{{ isset($product->driver->full_name) ? $product->driver->full_name : 'Deleted' }}
                                        </td>
                                        <td>{{ isset($product->category->name_ru) ? $product->category->name_ru : 'Deleted' }}
                                        </td>
                                        <td class="desc_name">{{ $product->description_ru }}</td>
                                        <style>
                                            .desc_name {
                                                width: 200px;
                                                display: -webkit-box;
                                                -webkit-box-orient: vertical;
                                                -webkit-line-clamp: 1;
                                                overflow: hidden;
                                                border: none;
                                                outline: none
                                            }
                                        </style>
                                        <td
                                            class="@if($product->level === 'hard') bg-danger @elseif($product->level === 'middle') bg-warning @elseif($product->level === 'easy') bg-success @endif">
                                            {{ $product->level }}</td> <!-- Display level from the current $product -->
                                        <td>{{ isset($product->category->default_quantity) ?
                                            $product->category->default_quantity : 'Null' }}</td>
                                        <td>{{ $product->category->deadline }} minute</td>
                                        <td class="text-center">
                                            @php
                                            $currentUser = auth()->user();
                                            $isProductInOrder = $currentUser->orders()->where('product_id',
                                            $product->id)->exists();
                                            @endphp

                                            @if($product->in_stock)




                                            <i style="cursor: pointer" id="product_{{ $product->id }}"
                                                class="fas {{ $product->in_stock ? " fa-check-circle text-success"
                                                : "fa-times-circle text-danger" }}"
                                                onclick="toggle_instock({{ $product->id }})"></i>
                                            @else

                                            <i style="cursor: pointer" id="product_{{ $product->id }}"
                                                class="fas {{ $product->in_stock ? " fa-check-circle text-success"
                                                : "fa-times-circle text-danger" }}"
                                                onclick="toggle_instock({{ $product->id }})"></i>
                                            @endif


                                        </td>



                                        <td class="text-center d-flex">
                                            @can('task.delete')
                                            <form action="{{ route('taskDestroy',$product->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('task.edit')
                                                    <a href="{{ route('taskEdit',$product->id) }}" type="button"
                                                        class="btn btn-info btn-sm"> @lang('global.edit')</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="submitButton btn btn-danger btn-sm mx-2">
                                                        @lang('global.delete')</button>
                                                </div>
                                            </form>
                                            @endcan
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#exampleModal_{{ $product->id }}">
                                                Details
                                            </button>

                                        </td>


                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Modal start --}}
                    @foreach($sortedProducts as $product)


                    <div class="modal fade" id="exampleModal_{{ $product->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Left Request № {{$loop->iteration}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="width: 40%">Company Name:</td>
                                                <td>
                                                    <b>{{$product->company->name_ru}}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Driver name:</td>
                                                <td>
                                                    <b>{{$product->driver->full_name}}</b>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Category Name:</td>
                                                <td>
                                                    <b>
                                                        {{$product->category->name_ru}}
                                                    </b>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>

                                    <br>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Level</th>
                                                <th>Ball</th>
                                                <th>Deadline</th>
                                                <th>Active</th>
                                                <th>Created_at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="@if($product->level === 'hard') bg-danger @elseif($product->level === 'middle') bg-warning @elseif($product->level === 'easy') bg-success @endif">
                                                    {{$product->level}}
                                                </td>

                                                <td>
                                                    {{$product->category->default_quantity}}
                                                </td>
                                                <td>
                                                    {{ $product->category->deadline }}
                                                </td>
                                                <td>
                                                    @if($isProductInOrder)
                                                    <i style="cursor: pointer" id="product_{{ $product->id }}"
                                                        class="fas {{ $product->in_stock ? " fa-check-circle
                                                        text-success" : "fa-times-circle text-danger" }}"
                                                        onclick="toggle_instock({{ $product->id }})"></i>
                                                    @else
                                                    <i style="cursor: pointer" id="product_{{ $product->id }}"
                                                        class="fas {{ $product->in_stock ? " fa-check-circle
                                                        text-success" : "fa-times-circle text-danger" }}"
                                                        onclick="toggle_instock({{ $product->id }})"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{$product->created_at}}
                                                </td>

                                            </tr>



                                            {{-- <tr>
                                                <td colspan="2">
                                                    <b>Barcha ball</b>
                                                </td>
                                                <td colspan="2">
                                                    {{$product->category->default_quantity}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <b>Sarflangan voqt</b>
                                                </td>
                                                <td colspan="2">
                                                    <b>5 minut</b>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>

                                    <p><strong>Task-description: </strong>{{$product->description_ru}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                    @php
                                    $employeeWithProduct = false; // Ikkala shartning bajarilishi kerak
                                    $currentUser = auth()->user();

                                    // 1. Employee mahsulotni sotib olganda
                                    if ($currentUser->hasRole('Employee')) {
                                    $employeeWithProduct = $currentUser->orders()->where('product_id',
                                    $product->id)->exists();
                                    }

                                    // 2. Boshqalar hali mahsulotni sotib olmagan bo'lsa
                                    $othersWithoutProduct = !$employeeWithProduct && $product->in_stock;
                                    @endphp

                                    @if(auth()->user()->status == 'online')
                                        @if($employeeWithProduct || $othersWithoutProduct)
                                        <form action="{{ route('submit.order', $product->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group">
                                                <input name="_method" type="hidden" value="POST">

                                                @if($employeeWithProduct)
                                                <button type="button" class="btn btn-success btn-sm py-2"
                                                    disabled>Submitted</button>
                                                @else
                                                <button class="btn btn-success btn-sm py-2">Submit</button>
                                                @endif
                                            </div>
                                        </form>
                                        @endif
                                    @else
                                    <button class="btn btn-success btn-sm py-2 disabled">you should to be online</button>
                                    @endif   

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

@section('scripts')
<script>
    function toggle_instock(id) {
        $.ajax({
            url: "/product/toggle-status/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (result) {
                if (result.is_active) {
                    $("#product_" + id).attr('class', "fas fa-check-circle text-success");
                } else {
                    $("#product_" + id).attr('class', "fas fa-times-circle text-danger");
                }
            },
            error: function (errorMessage) {
                console.log(errorMessage);
            }
        });
    }
</script>
<script>
    function submitOrder(productId) {
        $.ajax({
            url: "/submit/order/" + productId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    // Update the icon or display a success message
                    // Disable the submit button after successful submission if needed
                } else {
                    alert("Failed to submit order: " + response.message);
                }
            },
            error: function(error) {
                console.log(error);
                alert("An error occurred.");
            }
        });
    }
</script>
@endsection