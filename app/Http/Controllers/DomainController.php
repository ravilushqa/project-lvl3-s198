<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class DomainController extends BaseController
{
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

        return view('show', compact('domain'));
    }
}
