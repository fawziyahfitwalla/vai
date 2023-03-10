@extends('main')

@section('content')


    <div class="card">
        <div class="card-header">Appointments</div>
    <div class="card-body">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tr>
                    <th>Sr.</th>
                    @if(session('user_type')==2 || session('user_type')==0)
                    <th>Doctor</th>
                    @endif
                    @if(session('user_type')==1 || session('user_type')==0)
                    <th>Patient</th>
                    @endif
                    <th>Appointment Date</th>
                    <th>Status</th>
                    @if(session('user_type')!=2)
                    <th>Action</th>
                    @endif
                </tr>
                @foreach($appointments as $k=>$appointment)
                    <tr>
                        <td>{{$k+1}}</td>
                        @if(session('user_type')==2 || session('user_type')==0)
                        <td>{{$appointment['doctors']['name']}}</td>
                        @endif
                        @if(session('user_type')==1 || session('user_type')==0)
                        <td>{{$appointment['users']['name']}}</td>
                        @endif
                        <td>{{date('d-m-Y H:i',strtotime($appointment['appointment_time']))}}</td>
                        <td class="text-center">
                            @if($appointment['status']==1)
                                <label class="btn btn-sm btn-primary">Active</label>
                            @elseif($appointment['status']==2)
                                <label class="btn btn-sm btn-warning">Completed</label>
                            @else
                                <label class="btn btn-sm btn-dark">Cancelled</label>
                            @endif
                            </td>
                        @if(session('user_type')!=2)
                        <td>

                            @if($appointment['status']==1)

                                @if(strtotime($appointment['appointment_time']) < strtotime('now'))
                            <button class="btn btn-sm btn-group-sm btn-success btn-complete" data-appointment-id="{{$appointment['id']}}">Complete</button>
                        @else
                                    <button class="btn btn-sm btn-group-sm btn-danger btn-cancel" data-appointment-id="{{$appointment['id']}}">Cancel</button></td>
                                @endif

                        @endif
                        @endif

                    </tr>
                @endforeach

            </table>
        </div>
    </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


    <script>
        $(document).ready(function(){
            $('.btn-cancel').on('click',function(){
                el=$(this);
                appt_id=$(this).attr('data-appointment-id');
                $.ajax({
                    url:'{{route('appointment.cancel')}}',
                    type: 'get',
                    data:{'appointment_id':appt_id},
                    success:function(resp){
                        el.parent().prev().html('<label class="btn btn-sm btn-dark">Cancelled</label>');
                        el.parent().html('');
                    }
                });
            });
            $('.btn-complete').on('click',function(){
                el=$(this);
                appt_id=$(this).attr('data-appointment-id');
                $.ajax({
                    url:'{{route('appointment.complete')}}',
                    type: 'get',
                    data:{'appointment_id':appt_id},
                    success:function(resp){
                        el.parent().prev().html('<label class="btn btn-sm btn-warning">Completed</label>');
                        el.parent().html('');
                    }
                });
            });
        });
    </script>




@endsection('content')
