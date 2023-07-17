<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;



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
        if ($orderBy && !in_array($orderBy, ['asc', 'desc'])) { $orderBy = ''; }

        $filterBy = $request->searchBy ?? 'fname';
        $filterValue = $request->searchFor ?? '';

        $perPage = (int) $request->per_page ?? 5;
        $perPage = $perPage == 0 ? 5 : $perPage;

        if ($request->s) {
            if ($filterBy == 'iban'){
                $accounts = Account::where($filterBy, 'like', '%'.$filterValue.'%')->get();
                $ids = $accounts->pluck('client_id')->toArray();
                $clients = Client::whereIn('id', $ids)->paginate($perPage)->withQueryString();
            }else {
            $clients = Client::where($filterBy, 'like', '%'.$filterValue.'%')->paginate($perPage)->withQueryString();}
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



        $request->flash();
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
        $clients = Client::all();
       if ($clients->where('pid', '=', $request->pid)->count()){
        $request->flash();
        return redirect()
        ->back()
        ->withErrors(['This personal code already exist']);
        die();
       }
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
    public function show(Client $client, Int $page)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, Int $page)
    {
        // $page = $page ?? 1;
        $accounts = $client->accounts()->paginate(10)->withQueryString();

        return view('clients.edit', [
            'client' => $client,
            'page'=>$page,
            'accounts'=>$accounts
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client, Int $page)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lname' => 'required|max:50|min:3|alpha',

                'fname' => 'required|max:50|min:3|alpha'
            ],
            [
                'lname.required' => 'Please enter last name!',
                'lname.max' => 'Looks like last name is too long!',
                'lname.min' => 'Is Your  last name so short?',
                'lname.regex' => 'Check the last name again!',

                'fname.required' => 'Please enter first name!',
                'fname.max' => 'Looks like name is too long!',
                'fname.min' => 'Is Your name so short?',
                'fname.regex' => 'Check the name again!'

                ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $client->fname = $request->fname;
        $client->lname = $request->lname;
        $client->save();
        return redirect()
        ->route('client-index', ['page'=>$page])
        ->with('success', 'Details was saved!');
    }


     /**
     * Open delete form.
     */
    public function delete(Client $client)
    {
        $accounts = $client->accounts()->get();
        $countZeroBalance = $accounts->where('balance', '!=', 0)->count();
        if ($countZeroBalance == 0) {
                    return view('clients.delete', [
                        'client' => $client
                        // 'page'=>$page
                    ]);
                    die();
                }
        return redirect()->back()->withErrors(['Client can not be deltete. Non 0 accounts exist']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $accounts = $client->accounts();
        if ($accounts->count() != 0) {
            $accounts->each(function($item){
                $deleteAcc = Account::find($item['id']);
                $deleteAcc->delete();
            });
        }
        $client->delete();
        return redirect()
        ->route('client-index')
        ->with('success', 'Client has been deleted!');
    }
}
