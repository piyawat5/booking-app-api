<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $field = $request->validate([
            'reserve_id' => 'required|integer',
            'ac' => 'nullable|boolean',
            'temp' => 'nullable|string',
            'monitor' => 'nullable|boolean',
            'micro' => 'nullable|boolean',
            'add_lightblub' => 'nullable|boolean',
            'towel' => 'nullable|boolean',
            'paper' => 'nullable|boolean',
            'white_board' => 'nullable|boolean',
            'add_table' => 'nullable|boolean',
            'water' => 'nullable|boolean',
            'coffee' => 'nullable|boolean',
            'juice' => 'nullable|boolean',
            'apitize' => 'nullable|boolean',
            'perfume' => 'nullable|boolean',
            'clean_before' => 'nullable|boolean',
            'clean_after' => 'nullable|boolean',
            'security' => 'nullable|boolean',
        ]);

        $res = Config::create([
            'reserve_id' => $field['reserve_id'],
            'ac' => $field['ac'],
            'temp' => $field['temp'],
            'monitor' => $field['monitor'],
            'micro' => $field['micro'],
            'add_lightblub' => $field['add_lightblub'],
            'towel' => $field['towel'],
            'paper' => $field['paper'],
            'white_board' => $field['white_board'],
            'add_table' => $field['add_table'],
            'water' => $field['water'],
            'coffee' => $field['coffee'],
            'juice' => $field['juice'],
            'apitize' => $field['apitize'],
            'perfume' => $field['perfume'],
            'clean_before' => $field['clean_before'],
            'clean_after' => $field['clean_after'],
            'security' => $field['security'],
        ]);

        return response([
            'data' => $res
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Config $config)
    {

        $field = $request->validate([
            'reserve_id' => 'required|integer',
            'ac' => 'nullable|boolean',
            'temp' => 'nullable|string',
            'monitor' => 'nullable|boolean',
            'micro' => 'nullable|boolean',
            'add_lightblub' => 'nullable|boolean',
            'towel' => 'nullable|boolean',
            'paper' => 'nullable|boolean',
            'white_board' => 'nullable|boolean',
            'add_table' => 'nullable|boolean',
            'water' => 'nullable|boolean',
            'coffee' => 'nullable|boolean',
            'juice' => 'nullable|boolean',
            'apitize' => 'nullable|boolean',
            'perfume' => 'nullable|boolean',
            'clean_before' => 'nullable|boolean',
            'clean_after' => 'nullable|boolean',
            'security' => 'nullable|boolean',
        ]);

        $config->update($field);
        return response([
            'data' => $config
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Config $config)
    {
        //
    }
}
