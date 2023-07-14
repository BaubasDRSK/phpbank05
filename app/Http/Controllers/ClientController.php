<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $clients = Client::all();

        $sortBy = $request->sort_by ?? '';
        $orderBy = $request->order_by ?? '';
        if ($orderBy && !in_array($orderBy, ['asc', 'desc'])) {
            $orderBy = '';
        }
        $filterBy = $request->filter_by ?? '';
        $filterValue = $request->filter_value ?? '0';
        $perPage = (int) $request->per_page ?? 5;
        $perPage = $perPage == 0 ? 5 : $perPage;

        if ($request->s) {

            $clients = Client::where('lname', 'like', '%'.$request->s.'%')->paginate($perPage)->withQueryString();

        } else {

            // $clients = Client::all();
            $clients = Client::where('lname','like','%');

            //filtravimas
            $clients = match($filterBy) {
                'lname' => $clients->where('lname', '=', $filterValue),
                default => $clients
            };

            //rikiavimas
            $clients = match($sortBy) {
                'lname' => $clients->orderBy('lname', $orderBy),
                // 'rate' => $clients->orderBy('rate', $orderBy),
                default => $clients
            };

            // $clients = $clients->get();
            $clients = $clients->paginate($perPage)->withQueryString();

        }




        return view('clients.index',
        [
            'clients' => $clients,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
            'filterBy' => $filterBy,
            'filterValue' => $filterValue,
            'perPage' => $perPage,
            's' => $request->s ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lname' => 'required|max:50|min:3|alpha',

                'fname' => 'required|max:50|min:3|alpha',

                'pid' => ['required','integer','regex:/^(3[0-9]{2}|4[0-9]{2}|6[0-9]{2}|5[0-9]{2})(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/']
            ],
            [
                'lname.required' => 'Please enter last name!',
                'lname.max' => 'Looks like last name is too long!',
                'lname.min' => 'Is Your  last name so short?',
                'lname.regex' => 'Check the last name again!',

                'fname.required' => 'Please enter first name!',
                'fname.max' => 'Looks like name is too long!',
                'fname.min' => 'Is Your name so short?',
                'fname.regex' => 'Check the name again!',

                'pid.required' => 'Fill PID field!',
                'pid.integer' => 'PID must contain only digits!',
                'pid.regex' => 'PID is not valid!'


            ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $client = new Client;
        $client->fname = $request->fname;
        $client->lname = $request->lname;
        $client->pid = $request->pid;
        $client->info = $request->info ?? '';
        $client->save();
        return redirect()
        ->route('client-index')
        ->with('success', 'New color has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
