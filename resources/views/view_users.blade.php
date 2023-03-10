@extends('main')

@section('content')
    <main>
        <div class="row">
            <div class="col-md-12 text-center pb-5">
                <h1>{{ $title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered col-12">
                    <tr>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                    </tr>

@foreach($users as $k=>$user)
    <tr>
        <td>{{$k+1}}</td>
        <td>{{$user['name']}}</td>
        <td>{{$user['email']}}</td>
        <td class="text-center">
            @if($user['user_type']==1)
           <label class="btn btn-sm btn-primary">Doctor</label>
            @elseif($user['user_type']==2)
                <label class="btn btn-sm btn-danger">Patient</label>
            @else
                <label class="btn btn-sm btn-warning">Admin</label>
            @endif
        </td>

    </tr>

                    @endforeach
                </table>
            </div>
        </div>
    </main>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

@endsection('content')
