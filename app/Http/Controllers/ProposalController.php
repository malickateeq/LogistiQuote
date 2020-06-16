<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Quotation;
use App\Proposal;
use Carbon\Carbon;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['proposals'] = Proposal::where('partner_id', Auth::user()->id)
        ->get();
        $data['page_name'] = 'proposals';
        $data['page_title'] = 'View proposals | LogistiQuote';
        return view('panels.proposal.index', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proposals_received()
    {
        $data['proposals'] = Proposal::where('user_id', Auth::user()->id)
        ->get();
        $data['page_name'] = 'proposals';
        $data['page_title'] = 'View proposals | LogistiQuote';
        return view('panels.proposal.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($quotation_id)
    {
        dd('here');
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function make_proposal($id)
    {
        $data['quotation'] = Quotation::findOrFail($id);
        $data['page_name'] = 'make_proposal';
        $data['page_title'] = 'Make Proposal | LogistiQuote';
        return view('panels.proposal.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'quotation_id' => ['required'],
            'local_charges' => ['required', 'numeric', 'min:1', 'max:1000000000'],
            'freight_charges' => ['required', 'numeric', 'min:1', 'max:1000000000'],
            'destination_local_charges' => ['required', 'numeric', 'min:1', 'max:1000000000'],
            'customs_clearance_charges' => ['required', 'numeric', 'min:1', 'max:1000000000'],
            'local_charges' => ['required', 'numeric', 'min:1', 'max:1000000000'],
            'valid_till' => ['required', 'string', 'min:3', 'max:255'],
            'remarks' => ['required', 'string', 'min:3', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $proposal = new Proposal;
        $proposal->quotation_id = $request->quotation_id;
        $proposal->partner_id = Auth::user()->id;
        // $proposal->proposal_id = mt_rand();
        $proposal->local_charges = $request->local_charges;
        $proposal->freight_charges = $request->freight_charges;
        $proposal->destination_local_charges = $request->destination_local_charges;
        $proposal->customs_clearance_charges = $request->customs_clearance_charges;
        $proposal->total = (float)$request->customs_clearance_charges+(float)$request->destination_local_charges+(float)$request->freight_charges+(float)$request->local_charges;

        $valid_till = Carbon::createFromFormat('d-m-Y', $request->valid_till );
        $proposal->valid_till = $valid_till;

        $proposal->remarks = $request->remarks;


        $quotation = Quotation::findOrFail($request->quotation_id);
        $quotation->proposals_received += 1;

        $proposal->user_id = $quotation->user_id;

        $proposal->save();
        $quotation->save();
        
        return redirect(route('proposal.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['proposal'] = Proposal::findOrFail($id);
        $data['page_name'] = 'view_proposal';
        $data['page_title'] = 'View Proposal | LogistiQuote';
        return view('panels.proposal.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function accept_proposal($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'completed';
        $quotation = Quotation::findOrFail($proposal->quotation_id);
        $quotation->status = 'completed';
        $proposal->save();
        $quotation->save();
        //
    }
}