@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Control orders</li>
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
                    <h3 class="card-title">Order</h3>
                    <!-- You can add any buttons or actions related to orders here -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Data table -->
                    <table id="dataTable"
                        class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid"
                        aria-describedby="dataTable_info">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company name</th>
                                <th>Driver name</th>
                                <th>Employer name</th>
                                <th>Task name</th>
                                <th>Category</th>
                                <th>Category ball</th>
                                <th>Status</th>
                                
                                <th>Timer</th>
                              
                                <th class="w-25">@lang('global.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through your orders and display them -->
                            @foreach($orders as $order)
                            @if(auth()->user()->id == $order->user_id)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->product->company->name_ru }}</td>
                                    <td>{{ $order->product->driver->full_name }}</td>
                                    <td>{{ $order->user->name}}</td>
                                    <td class="desc_name">{{ $order->product->description_ru }}</td>

                                    <style>
                                        .desc_name {
                                            width: 200px;
                                            display: -webkit-box;
                                            -webkit-box-orient: vertical;
                                            -webkit-line-clamp: 1;
                                            overflow: hidden;
                                        }
                                    </style>
                                    <td>{{ $order->product->category->name_ru }}</td>
                                    <td>{{ $order->product->category->default_quantity }}</td>
                                    <td>  {{ $order->status }} </td>            
                                    {{-- <td>{{ $order->product->category->deadline }} minute</td> --}}
                                    <td id="timer_{{ $order->id }}">
                                        @if ($order->timer_expired)
                                            Done
                                        @else
                                            {{ $order->product->category->deadline }}:00
                                        @endif
                                    </td>
                                    

                                    @if(auth()->user()->roles[0]->name == 'Employee')

                                    @endif
                                    <td class="d-flex">
                                        @if(auth()->user()->id == $order->user_id)
                                            @if(!$order->is_finished)
                                                <form id="finishOrderForm_{{ $order->id }}" method="POST" action="{{ route('orders.finish', ['order' => $order->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Finish</button>
                                                </form>
                                            @else
                                                <button class="btn btn-success" disabled>Finished</button>
                                            @endif
                                        @else
                                            <button type="button" class="bg-primary rounded py-2 px-4 border disabled">You Can't</button>
                                        @endif
                                    
                                        <!-- ... Rest of your actions ... -->
                                        <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#exampleModal_{{ $order->id }}">
                                            Details
                                        </button>                         
                                    </td>
                                </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>

                         {{-- Modal start --}}
                         @foreach($orders as $order)

                         <div class="modal fade" id="exampleModal_{{ $order->id }}" tabindex="-1" role="dialog"
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
                                                     <td style="width: 40%">Company Name:</td>
                                                     <td>
                                                         <b>{{$order->product->company->name_ru}}</b>
                                                     </td>
                                                 </tr>
                                                 <tr>
                                                     <td>Driver name:</td>
                                                     <td>
                                                         <b>{{$order->product->driver->full_name}}</b>
     
                                                     </td>
                                                 </tr>
                                                 <tr>
                                                    <td>User name:</td>
                                                    <td>
                                                        <b>      
                                                           {{ $order->user->name}}
                                                        </b>
    
                                                    </td>
                                                </tr>
                                                 <tr>
                                                     <td>Category Name:</td>
                                                     <td>
                                                         <b>
                                                             {{$order->product->category->name_ru}}
                                                         </b>
                                                     </td>
                                                 </tr>
     
     
                                             </tbody>
                                         </table>
     
                                         <br>
                                         <table class="table table-striped">
                                            {{-- @dump($order->product->level) --}}
                                             <thead>
                                                 <tr>
                                                     <th>Level</th>
                                                     <th>Ball</th>
                                                     <th>Deadline</th>
                                                     <th>Status</th>
                                                     <th>Created_at</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <tr>
                                                     <td
                                                         class="@if($order->product->level === 'hard') bg-danger @elseif($order->product->level === 'middle') bg-warning @elseif($order->product->level === 'easy') bg-success @endif">
                                                         {{$order->product->level}}
                                                     </td>
     
                                                     <td>
                                                         {{$order->product->category->default_quantity}}
                                                     </td>
                                                     <td>
                                                         {{ $order->product->category->deadline }} minute
                                                     </td>
                                                     <td>  {{ $order->status }} </td>            

                                                  
                                                     <td>
                                                         {{$order->created_at}}
                                                     </td>
     
                                                 </tr>
     
                                             </tbody>
                                         </table>
     
                                         <p><strong>Task-description: </strong>{{$order->product->description_ru}}</p>
                                         <hr>
                                         <p><strong>Driver-comment: </strong>{{$order->product->driver->comment}}</p>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    @foreach ($orders as $order)
        var timerElement_{{ $order->id }} = document.getElementById('timer_{{ $order->id }}');
        var orderDeadline_{{ $order->id }} = {{ $orderDeadlines[$order->id] }};
        var interval_{{ $order->id }}; // Declare interval variable

        function updateTimer_{{ $order->id }}() {
            var currentTime = Math.floor(Date.now() / 1000);
            var remainingTime = orderDeadline_{{ $order->id }} - currentTime;

            if (remainingTime <= 0) {
                clearInterval(interval_{{ $order->id }});
                timerElement_{{ $order->id }}.textContent = 'Done';
            } else {
                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;

                timerElement_{{ $order->id }}.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            }
        }

        function stopTimer_{{ $order->id }}() {
            clearInterval(interval_{{ $order->id }});
        }

        interval_{{ $order->id }} = setInterval(updateTimer_{{ $order->id }}, 1000);

        // Update the timer status and stop the timer when order is finished
        $('#finishButton_{{ $order->id }}').click(function () {
            stopTimer_{{ $order->id }}();
            timerElement_{{ $order->id }}.textContent = 'Done';

            // Optionally, update other parts of the UI to indicate the order is finished
            $('#status_{{ $order->id }}').text('Finished');
            // Add any other UI updates you want to perform
        });
    @endforeach
</script>


@endsection
