<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class DomainController extends BaseController
{
    public function index()
    {
        $domains = Domain::paginate(5);

        return view('domain.index', compact('domains'));
    }
    
    public function store(Request $request, Domain $domain)
    {
        $this->validate($request, [
            'domain' => 'required|url'
        ]);

        $domain->name = $request->input('domain');

        $domain->save();

        return redirect()->route('domains.show', ['id' => $domain->getKey()]);
    }

    public function show(Request $request, $id)
    {
        $domain = Domain::findOrFail($id);

        return view('domain.show', compact('domain'));
    }
}
