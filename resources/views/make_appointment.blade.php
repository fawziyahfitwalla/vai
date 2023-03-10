@extends('main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <style>

        .radio-toolbar input[type="radio"] {
            opacity: 0;
            position: fixed;
            width: 0;
        }

        .radio-toolbar label {
            display: inline-block;
            padding: 5px 10px;
            font-family: sans-serif, Arial;
            font-size: 14px;
            margin: 3px;
            border-radius: 4px;
        }




        .radio-toolbar input[type="radio"]:checked + label {
            background-color: #117a8b;

        }

    </style>
    @if($message = Session::get('error'))

        <div class="alert alert-danger">
            {{ $message }}
        </div>

    @endif

    <main>
        <div class="row">
            <div class="col-md-12 text-center pb-5">
                <h1>Book Appointment</h1>
            </div>
        </div>
        <div class="bd-example">
            <form method="post" id="actForm" action="{{route('appointment.make')}}" data-action="{{route('appointment.booked')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Doctor</label>
                        <select id="doctor" name="doctor_id" class="form-control">
                            <option selected="" value="-1">Select Doctor</option>
                            @foreach($doctors as $doc)
                            <option value="{{$doc['id']}}">{{$doc['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(session('user_type')!=2)
                    <div class="form-group col-md-6">
                        <label for="patient">Patient</label>
                        <select id="patient" name="patient_id" class="form-control">
                            <option selected="" value="-1">Select Patient</option>
                            @foreach($patients as $pat)
                            <option value="{{$pat['id']}}">{{$pat['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="form-row">



                    <div class="form-group col-md-6">
                        <label>Select Date</label>
                        <div class='input-group date' id='datetimepicker'>
                        <input type='text' name="date" id="dateSelect" class="form-control" />
                        <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
                    </div>
                </div>
                    <div class="form-group col-md-6" id="time_slot">
                    </div>
                </div>




                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </form>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#datetimepicker').datetimepicker({
                stepping:60,
                format: 'YYYY/MM/DD',
                defaultDate:new Date(),
                minDate: new Date()+1
            });

        });
    </script>

    <script>
        $(function() {
            $('#datetimepicker').on('dp.change',function (e){
                $('#time_slot').html('');
                console.log(e.date);
                console.log(new Date(e.date));
                var selected_date=new Date(e.date);
                var today=new Date();
                var obj='<label>Select Time</label><div class="radio-toolbar">';
                console.log(selected_date.getDate());
                console.log(today.getDate());
                if(selected_date.getTime() == today.getTime())
                {
                    time_now=today.getHours();
                    next_hour=parseFloat(time_now+1);
                }
                else{
                    next_hour=(10.00);
                }


                url=($(this).parents().find('form').attr('data-action'));


                $.ajax({
                    url:url,
                    type: 'get',
                    dataType: 'json',
                    data:{year:selected_date.getFullYear(), month:selected_date.getMonth()+1, date:selected_date.getDate()},
                    success:function(resp){
                        resp=(JSON.parse(JSON.stringify(resp)));
                        console.log(resp);


                        for(i=next_hour; i<=22; i++)
                        {
                            if(resp.indexOf(i)==-1)
                                obj +='<input type="radio" name="time" value="'+i.toFixed(2)+'" id="'+i+'"><label for="'+i+'" class="btn-info">'+i.toFixed(2)+'</label>';
                        }
                        obj +='</div>';
                        $('#time_slot').html(obj);
                    }
                });
            });
        });
    </script>
@endsection('content');
