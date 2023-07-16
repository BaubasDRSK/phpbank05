@extends('layouts.app')

@section('content')
<?php $page = 1; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Are You shure, You want to delte the Client?</h5>

                    <div class="container">
                        <div class="row justify-content-center">
                            <form class='col-4' action="{{route('client-destroy', [$client])}}" method="post" class="login-form">
                                <h4 class="main-h">Please edit personal details</h4>

                                    <div class="input mb-4">
                                        <label class="mr-3" for="fname">First name</label>
                                        {{-- <img src="/img/person.svg" alt="fname"> --}}
                                        <input class="form-control" type="text" name="fname" id="fname"  placeholder="Enter your first name" value="{{$client->fname}}" required>
                                    </div>

                                    <div class="input mb-4">
                                        <label  class="mr-3" for="lname">Last name</label>
                                        {{-- <img src="/img/person.svg" alt="lname"> --}}
                                        <input  class="form-control" type="text" name="lname" id="lname" placeholder="Enter your last name" value="{{$client->lname}}" required>
                                    </div>

                                    <div class=" mb-4">
                                         <h6>{{$client->pid}}</h6>
                                    </div>

                                    <button class="btn btn-danger" type="submit">Delete</button>
                                    <a class="btn btn-warning" href="{{route('client-index')}}" class="btn-red" >Cancel</a>
                                    @method('delete')
                                    @csrf
                                </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
