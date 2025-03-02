<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\History;
use App\Models\Owner;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!rolecheck(['bank'])) {
            return abort(404);
        }

        $banks = BankAccount::query()

            ->withSum(['histories as current_balance' => function ($query) {
                $query->where('type', '+');
            }], 'amount')
            ->withSum(['histories as withdraw' => function ($query) {
                $query->where('type', '-');
            }], 'amount')
            ->get();

        return view('bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'max:256'],
            'opening_balance' => ['required', 'numeric']
        ]);

        try {
            DB::beginTransaction();

            $bank =  BankAccount::create([
                'name' => request('name'),
                'opening_balance'=>request('opening_balance')
            ]);

            $bank->histories()->create([
                'type' => '+',
                'amount' => request('opening_balance'),
                'note' => 'Opening balance',
                'date' => now()
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return back()->with('message', 'Bank account created');
    }


    function addbalance($id)
    {
        if (!rolecheck(['bank'])) {
            return abort(404);
        }
        $owners = Owner::all();
        BankAccount::findOrfail($id);
        return view('bank.addbalance', compact('owners', 'id'));
    }

    function addbalanceStore(Request $request, $bankid)
    {
        $request->validate([
            'amount' => ['required', 'min:0', 'numeric'],
            'owner' => ['required', 'exists:owners,id'],
            'note' => ['nullable', 'max:2000'],
        ]);

        BankAccount::findOrFail($bankid);

        $ownerid = request('owner');
        $amount = request('amount');
        $note = $request->note;

        $owner = Owner::findOrFail($ownerid);

        HistoryService::Transition($owner, $bankid, $amount, '+', $note);

        return to_route('bank.index')->with('message', 'Balance added successfully');
    }

    function withdraw($id)
    {
        if (!rolecheck(['bank'])) {
            return abort(404);
        }
        BankAccount::findOrFail($id);
        $owners = Owner::all();
        return view('bank.withdraw', compact('id', 'owners'));
    }

    function withdrawStore(Request $request, $id)
    {
        $request->validate([
            'amount' => ['required', 'min:0', 'numeric'],
            'owner' => ['required', 'exists:owners,id'],
            'note' => ['nullable', 'max:2000'],
        ]);

        $ownerid = request('owner');
        $owner = Owner::findOrFail($ownerid);
        $amount = request('amount');
        $note = request('note');

        BankAccount::findOrFail($id);

        HistoryService::Transition($owner, $id, $amount, '-', $note);

        return to_route('bank.index')->with('message', 'Balance withdraw successfully');
    }

    function transfer($id)
    {
        if (!rolecheck(['bank'])) {
            return abort(404);
        }
        BankAccount::findOrFail($id);
        $banks = BankAccount::query()->where('id', '!=', $id)->get();
        return view('bank.transfer', compact('id', 'banks'));
    }

    function transferStore(Request $request, $id)
    {
        $request->validate([
            'amount' => ['required', 'min:0', 'numeric'],
            'bank' => ['required', 'exists:bank_accounts,id'],
            'note' => ['nullable', 'max:2000'],
        ]);

        $transferFrorm = BankAccount::findOrFail($id);
        $transferTo = BankAccount::findOrFail(request('bank'));

        $amount = request('amount');
        $note = request('note');

        try {
            DB::beginTransaction();

            // HistoryService::Transition($transferFrorm, $id, $amount, '-', $note);
            // HistoryService::Transition($transferTo, request('bank'), $amount, '+', $note);
            $transferFrorm->histories()->create([
                'amount' => $amount,
                'type' => '-',
                'note' => $note,
                'date' => now(),
            ]);

            $transferTo->histories()->create([
                'amount' => $amount,
                'type' => '+',
                'note' => $note,
                'date' => now(),
            ]);


            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'something wrong');
        }


        return to_route('bank.index')->with('message', 'Balance transfer successfully');
    }
    function transaction($id)
    {
        if (!rolecheck(['bank'])) {
            return abort(404);
        }
        $bank =  BankAccount::findOrFail($id);
        $histories = $bank->histories()
            ->latest()
            ->paginate(15);

        return view('bank.history', compact('histories', 'bank'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }
}
