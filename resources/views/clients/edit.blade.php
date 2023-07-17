@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add new Client</h5>

                    <div class="container">
                        <div class="row justify-content-center">
                            <form class='col-4' action="{{route('client-update', [$client, $page])}}" method="post" class="login-form">
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

                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <a class="btn btn-warning" href="{{route('client-index',['page'=>$page])}}" class="btn-red" >Close</a>
                                    @method('put')
                                    @csrf
                                </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-5">
                        <h3 class="card-title">Client Accounts</h3>
                        <a class="btn btn-primary mt-3" href="{{route('account-create',[$client, $page])}}">Create New Account</a>
                    </div>

                    <div class="container">
                        <div class="row justify-content-center">
                            @forelse($accounts as $account)
                                <ul>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="ms-2">
                                                        <div>{{$account->iban}} / Balance: {{$account->balance}}€ </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a class="btn btn-success" href="{{route('account-edit', ['account'=>$account, 'client'=>$client])}}" >
                                                    Edit
                                                </a>
                                                <a class="btn btn-danger" href="{{route('account-delete', ['account'=>$account])}}" >
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                @empty
                                <li class="list-group-item">
                                    <p class="text-center">No accounts yet</p>
                                </li>
                                @endforelse
                        </div>
                    </div>
                    <div class="mt-3">{{ $accounts->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
