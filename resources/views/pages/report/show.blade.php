@extends('layouts.admin')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control Reports</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Control Reports</li>
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
                    <h3 class="card-title">Reports</h3>
                </div>
                <div class="card-body">
                    <table id="dataTable"
                    class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                    role="grid" aria-describedby="dataTable_info">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Company</th>
                                <th>Driver</th>
                                <th>Category</th>
                                <th>level</th>
                                <th>Ball</th>
                                <th>Deadline</th>
                                <th>Created_at</th>
                                <th>finished_at</th>
                                <th class="w-15">@lang('global.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ratings  as $rating)
                            {{-- @dump($rating->user_id == $desiredUserId) --}}
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rating->user->name }}</td>
                                <td>{{ $rating->order->product->company->name_ru }}</td>
                                <td>{{ $rating->order->product->driver->full_name }}</td>
                                <td>{{ $rating->order->product->category->name_ru }}</td>
                                <td
                                    class="@if($rating->order->product->level === 'hard') bg-danger @elseif($rating->order->product->level === 'middle') bg-warning @elseif($rating->order->product->level === 'easy') bg-success @endif">
                                    {{$rating->order->product->level}}
                                 </td>
                                <td>{{ $rating->order->product->category->default_quantity }}</td>
                                <td>{{ $rating->order->product->category->deadline }} minute</td>
                                <td>{{ $rating->order->created_at }}</td>
                                <td>{{ $rating->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#exampleModal_{{ $rating->id }}">
                                    Details
                                  </button>


                                </td>
                              
                            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                   
                       {{-- Modal start --}}
                       @foreach($ratings as $rating)
                       <div class="modal fade" id="exampleModal_{{ $rating->id }}" tabindex="-1" role="dialog"
                           aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-lg">
                               <div class="modal-content">
                                   <div class="modal-header">
                                       <h4 class="modal-title">Report № {{$loop->iteration}}</h4>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                       </button>
                                   </div>
                                   <div class="modal-body">
   
                                       <table class="table table-striped">
                                           <tbody>
                                            <tr>
                                                <td style="width: 40%">User Name:</td>
                                                <td>
                                                    <b>{{$rating->user->name}}</b>
                                                </td>
                                            </tr>
                                               <tr>
                                                   <td style="width: 40%">Company Name:</td>
                                                   <td>
                                                       <b>{{$rating->order->product->company->name_ru}}</b>
                                                   </td>
                                               </tr>
                                               <tr>
                                                   <td>Driver name:</td>
                                                   <td>
                                                       <b>{{$rating->order->product->driver->full_name}}</b>
   
                                                   </td>
                                               </tr>
                                               <tr>
                                                   <td>Category Name:</td>
                                                   <td>
                                                       <b>
                                                           {{$rating->order->product->category->name_ru}}
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
                                                   <th>Created_at</th>
                                                   <th>Finished_at</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               <tr>
                                                   <td
                                                       class="@if($rating->order->product->level === 'hard') bg-danger @elseif($rating->order->product->level === 'middle') bg-warning @elseif($rating->order->product->level === 'easy') bg-success @endif">
                                                       {{$rating->order->product->level}}
                                                   </td>
   
                                                   <td>
                                                       {{$rating->order->product->category->default_quantity}}
                                                   </td>
                                                   <td>
                                                       {{ $rating->order->product->category->deadline }}
                                                   </td>
                                                  
   
                                                   <td>{{ $rating->order->created_at }}</td>

                                                   <td>{{ $rating->updated_at }}</td>
                                              
                                               </tr>
   
   
   
                                         
                                           </tbody>
                                       </table>
   
                                       <p><strong><i class="fas fa-car"></i>  comment: </strong> {{$rating->order->product->driver->comment}}</p>
                                       <hr>
                                       <p><strong><i class="fas fa-user"></i> comment: </strong> {{$rating->order->product->description_ru}}</p>


                                       <div>
                                        {{-- <form action="{{ route('user.reports', $user->id) }}" method="GET"> --}}
                                        <form id="filterForm" action="{{ route('generate.pdf', ['userId' => $user->id]) }}" method="GET">

                                            <label for="start_date">From:</label>
                                            <input class="form-control" type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                            
                                            <label for="end_date">To:</label>
                                            <input class="form-control" type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                            
                                            <button class="btn btn-primary my-3" type="submit">Apply Filter</button>
                                        </form>

                                       </div>
                                   </div>
                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
   
                                      
   
                                   </div>
                               </div>
                               <!-- /.modal-content -->
                           </div>
                           <!-- /.modal-dialog -->
                       </div>
                       @endforeach
                       {{-- Modal end --}}
                    </div>
                    
                </div>

                    {{-- <a class="btn btn-primary" href="{{ route('generate.pdf', ['userId' => $user->id]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}">Generate PDF for User {{ $user->name }}</a> --}}
                   {{-- <form action="{{ route('generate.pdf', ['userId' => $user->id]) }}">
                    <button class="btn btn-primary" type="submit">pdf</button>
                </form> --}}
                    <a class="btn btn-primary" href="{{ route('generate.pdf', ['userId' => $user->id]) }}">Generate PDF for User {{ $user->name }}</a>

        </div>
    </div>
</section>
@endsection