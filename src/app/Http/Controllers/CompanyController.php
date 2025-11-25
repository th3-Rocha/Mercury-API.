<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyController extends Controller
{
    /**
     * Retorna os detalhes da empresa do usuário autenticado
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('owner_id', $user->id)->firstOrFail();
        return new JsonResource($company);
    }

    /**
     * Atualiza os dados da empresa do usuário autenticado
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('owner_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'string|max:100',
            'status' => 'in:trial,active,suspended',
            'wallet_balance' => 'numeric|min:0',
        ]);

        $company->update($validated);
        return new JsonResource($company);
    }
}
