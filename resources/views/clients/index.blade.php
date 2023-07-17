@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <form class='contianer' action="{{route('client-index')}}" method="get">
                <h3 class="info">Search clients:</h3>
                <div class="d-flex  align-items-center">
                    <div class="input mb-4">
                        <label class="mr-3" for="searchBy">Search by:</label>
                        <?php
                            $filter = old('searchBy') ?? 'fname';
                            $filter = match($filter) {
                                    'fname' => 'First name',
                                    'lname' => 'Last name',
                                    'pid' => 'Personal ID',
                                    'iban' => 'IBAN Nr.',
                                    default => 'fname'
                                    };
                        ?>
                        <select class="form-control" name="searchBy" id="searchBy">
                            <option value="{{old('searchBy')}}">{{$filter}}</option>
                            <option value="fname">First name</option>
                            <option value="lname">Last name</option>
                            <option value="pid">Personal ID</option>
                            <option value="iban">IBAN Nr.</option>
                          </select>
                    </div>
                    <div class="input mb-4 ms-3">
                        <label class="mr-3" for="per_page">No per page:</label>
                        <select class="form-control" name="per_page" id="per_page" value="{{old('per_page')}}">
                            <option value="{{old('per_page')}}">{{old('per_page')}}</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="input mb-4 ms-3">
                        <label class="mr-3" for="searchFor">Search for:</label>
                        <input class="form-control" type="text" name="searchFor" id="searchFor"   value="{{old('searchFor')}}">
                    </div>
                    <button class="btn btn-primary ms-3" type="submit" name="s" value="1">Search</button>
                    <button class="btn btn-warning ms-3" type="submit" name="reset" value="1">Reset</button>
                </div>
                @csrf
        </form>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Clients List</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($clients as $client)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="d-flex">
                                        <div class="ms-2">
                                            <div><h5 class="fw-bold text-primary">{{$client->fname}} {{$client->lname}}</h5> PID: {{$client->pid}}/ Total accounts [{{$client->accounts()->count()}}] / Total balance [{{$client->accounts()->sum('balance')}}]</div>

                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <?php $page = $_GET['page']??null; ?>
                                    @if ($page)
                                    <a class="btn btn-success" href="{{route('client-edit', ['client'=>$client, 'page'=>$page])}}" >
                                    @else
                                    <a class="btn btn-success" href="{{route('client-edit', ['client'=>$client, 'page'=>'1'])}}" >
                                    @endif
                                        {{-- {{route('authors-edit', $author)}} --}}
                                        Edit
                                    </a>
                                    <a class="btn btn-danger" href="{{route('client-delete', ['client'=>$client])}}" >
                                        {{-- {{route('authors-delete', $author)}} --}}
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <p class="text-center">No clients</p>
                        </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $clients->links() }}</div>
</div>
@endsection
