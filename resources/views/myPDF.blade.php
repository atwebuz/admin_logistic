<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>PDF Report</title>


<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px; /* Adjust font size */
    }
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 10px; /* Adjust font size */
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 3px; /* Adjust padding */
    }
</style> 
</head>
<body>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reports</h3>
                    </div>

                    
                    <div class="card-body">
                       
                        @if(isset($startDate) && isset($endDate))
                        <p>Filtered from: {{ $startDate }} to {{ $endDate }}</p>

                        @else
                        <p> Nothing to show </p>
                        @endif                    
                    
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
                                    <th>Finished_at</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($ratings  as $rating)
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
                                    
                                    </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
