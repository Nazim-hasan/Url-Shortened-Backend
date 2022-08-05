<?php

namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Http\Requests\StorePendingUserRequest;
use App\Http\Requests\UpdatePendingUserRequest;

class PendingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePendingUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePendingUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PendingUser  $pendingUser
     * @return \Illuminate\Http\Response
     */
    public function show(PendingUser $pendingUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendingUser  $pendingUser
     * @return \Illuminate\Http\Response
     */
    public function edit(PendingUser $pendingUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePendingUserRequest  $request
     * @param  \App\Models\PendingUser  $pendingUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePendingUserRequest $request, PendingUser $pendingUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendingUser  $pendingUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendingUser $pendingUser)
    {
        //
    }
}
