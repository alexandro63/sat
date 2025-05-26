<?php

namespace App\Http\Controllers;

use App\Helpers\UtilHelper;
use Illuminate\Http\Request;

class TeacherSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ajustes_docente.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $discount_reason = UtilHelper::discountReason();
        return view('ajustes_docente.create', compact('discount_reason'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
