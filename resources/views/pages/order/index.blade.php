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
                                            Time expired
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
                                                <button type="submit" class="btn btn-primary" id="finishButton_{{ $order->id }}">Finish</button>
                                            </form>
                                            @else
                                            <button class="btn btn-success" disabled>Finished</button>
                                            @endif

                                        @else
                                            <button type="submit" class="bg-primary rounded py-2 px-4 border disabled">You Can't</button>
                                        @endif
                                        <!-- ... Rest of your actions ... -->
                                        <button type="button" class="bg-primary rounded py-2 px-4 border " data-toggle="modal"
                                        data-target="#exampleModal_{{ $order->id }}">
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
$(document).ready(function() {
    const timers = {}; // Store interval IDs for each order

    function fetchAndDisplayTimer(orderId) {
        $.ajax({
            url: `/update-timer/${orderId}`,
            method: 'GET',
            success: function(data) {
                updateTimer(orderId, data.deadline);
            }
        });
    }

    function updateTimer(orderId, deadlineTimestamp) {
        const timerElement = document.getElementById(`timer_${orderId}`);
        const currentTime = moment();
        const deadline = moment.unix(deadlineTimestamp);
        const duration = moment.duration(deadline.diff(currentTime));
        
        if (duration <= 0) {
            timerElement.textContent = 'Time expired';
        } else {
            const minutes = Math.floor(duration.asMinutes());
            const seconds = Math.floor(duration.seconds());

            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
    }

    $('.finish-button').on('click', function(event) {
        const orderId = $(this).data('order-id');
        finishOrderAndStopTimer(orderId);
    });

    function finishOrderAndStopTimer(orderId) {
        clearInterval(timers[orderId]); // Clear the interval for this order
        
        $.ajax({
            url: `/orders/${orderId}/finish`,
            method: 'POST',
            success: function(data) {
                $('#finishButton_' + orderId).prop('disabled', true); // Disable the finish button
                $('#timer_' + orderId).text('Time expired'); // Set timer text to 'Time expired'
            }
        });
    }

    // Start updating timers on page load
    @foreach ($orders as $order)
        fetchAndDisplayTimer({{ $order->id }});
    @endforeach

    // Set interval to keep updating timers
    @foreach ($orders as $order)
        timers[{{ $order->id }}] = setInterval(function() {
            fetchAndDisplayTimer({{ $order->id }});
        }, 1000); // Update every 1 second
    @endforeach
});
</script>
@endsection
