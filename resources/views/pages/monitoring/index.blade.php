@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Monitoring</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Monitoring</li>
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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Data table -->
                    <table id="dataTable"
                        class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid"
                        aria-describedby="dataTable_info">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Employer name</th>

                                <th>Task name</th>
                                <th>Category ball</th>
                                <th>Is Online</th>
                                <th>Status</th>
                                <th>Timer</th>
                                <th>Timer Left</th>
                              
                                <th class="w-25">@lang('global.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through your orders and display them -->
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user->name}}</td>
                                    <td class="desc_name">{{ $order->product->description_ru }}</td>

                                    <style>
                                        .desc_name {
                                            width: 400px;
                                            display: -webkit-box;
                                            -webkit-box-orient: vertical;
                                            -webkit-line-clamp: 1;
                                            overflow: hidden;
                                        }
                                    </style>
                                    <td>{{ $order->product->category->default_quantity }}</td>
                                    <td>  
                                        @if($order->user->status == 'offline')
                                        <button class="m-auto d-flex justify-content-center bg-gray rounded">{{ $order->user->status }}</button>
                                    
                                    @else
                                        <button class="m-auto d-flex justify-content-center bg-success rounded">{{ $order->user->status }}</button>

                                    @endif
                                    </td>            
                                    <td>  {{ $order->status }} </td>  
                                    {{-- <td>{{ $order->product->category->deadline }} minute</td> --}}
                                    <td id="timer_{{ $order->id }}">
                                        @if ($order->timer_expired)
                                            Time expired
                                        @else
                                            {{ $order->product->category->deadline }}:00
                                        @endif
                                    </td>
                                    
                                    <td id="timer_{{ $order->id }}">
                                        {{ now()->diffForHumans($order->created_at) }}
                                    </td>

                                
                                    <td class="d-flex">
                                        @if(!$order->is_finished)
                                        <a href="{{ route('orderEdit', ['order' => $order->id]) }}" class="bg-primary rounded py-2 px-4 border">Edit</a>
                                        @else
                                        <a class="bg-primary rounded py-2 px-4 border disabled">Not editable</a>

                                        @endif
                                     
                                        <!-- ... Rest of your actions ... -->
                                        <button type="button" class="bg-primary rounded py-2 px-4 border " data-toggle="modal"
                                        data-target="#exampleModal_{{ $order->id }}">
                                        Details
                                    </button>       
                                    <form action="{{ route('send.default.message', ['order' => $order->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-primary rounded py-2 px-4 border"> Message</button>
                                    </form>
                                        </td>
                                </tr>

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
                                         <h4 class="modal-title">Monitoring № {{$loop->iteration}}</h4>
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
<script>
    $(document).ready(function() {
        @foreach ($orders as $order)
            fetchAndDisplayTimer({{ $order->id }});
        @endforeach

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
            const currentTime = Math.floor(Date.now() / 1000);
            const timeLeft = Math.max(deadlineTimestamp - currentTime, 0); // Ensure time doesn't go negative

            if (timeLeft <= 0) {
                timerElement.textContent = 'Time expired';
            } else {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;

                timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
        }

        // Attach event listeners to the finish buttons
        @foreach ($orders as $order)
            $('#finishButton_{{ $order->id }}').on('click', function() {
                finishOrderAndStopTimer({{ $order->id }});
            });
        @endforeach
    });

    function finishOrderAndStopTimer(orderId) {
        $.ajax({
            url: `/finish-order/${orderId}`,
            method: 'POST',
            success: function(data) {
                fetchAndDisplayTimer(orderId); // Update timer immediately

                $('#finishButton_' + orderId).prop('disabled', true); // Disable the finish button
            }
        });
    }
</script>


@endsection
