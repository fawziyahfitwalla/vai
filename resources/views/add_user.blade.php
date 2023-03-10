@extends('main')

@section('content')
    @if($message = Session::get('error'))

        <div class="alert alert-danger">
            {{ $message }}
        </div>

    @endif
        <main>
    <div class="row">
        <div class="col-md-12 text-center pb-5">
            <h1>Add User</h1>
        </div>
    </div>
            <div class="bd-example">
                <form method="post" action="{{route('user.add')}}">
                    @csrf
                    <div class="row m-3">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="name" value="{{old('name')}}" name="name" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" value="{{old('email')}}" name="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>

                    </div>
                    <div class="row m-3">


                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userType">User Type</label>
                            <select id="userType" name="user_type" class="form-control">
                                <option  value="-1">Doctor / Patient / Admin</option>
                                <option value="1" @if(old('userType')==1) selected @endif>Doctor</option>
                                <option value="2" @if(old('userType')==2) selected @endif>Patient</option>
                                <option value="0" @if(old('userType')==0) selected @endif>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-5"></div>
                        <div class="col-md-2"><button type="submit" class="btn btn-primary">Add</button></div>
                        <div class="col-md-5"></div>
                    </div>




                </form>
            </div>
        </main>
@endsection('content')
