<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Contact;
use App\Models\Picture;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $view = request()->expectsJson() ? 'json.doctor.'.__FUNCTION__ : 'nojson.doctor.'.__FUNCTION__;
        return response()->view($view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request): Response
    {
        $doctor = null;
        // DB::beginTransaction();
        DB::transaction(function () use ($request, &$doctor) {
            $attributes = null;
            $request->whenFilled('password', function () use ($request, &$attributes) {
                $attributes = array_merge($request->only(['first_name', 'last_name', 'username',]), ['password'=>Hash::make($request->password)]);
            }, function () use ($request, &$attributes) {
                $attributes = $request->only(['first_name', 'last_name', 'username',]);
            });
            $doctor = Doctor::create($attributes);
            $doctor->contact()->create($request->only(['email', 'phone_number', 'preference',]));
            $doctor->picture()->create(['url'=>$request->passport->storeAs('/', "doc_$doctor->id.jpg")]);
        });
        // $doctorPicture = Picture::create(array_merge($request->only(['email', 'phone', 'preference',]), ['owner_id'=>$doctor->id, 'owner_type'=>Doctor::class]));
        // if ($request->expectsJson()) {
            return response()->json(['username' => $doctor->username]);
        // }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor): Response {
        $view = request()->expectsJson() ? 'json.doctor.'.__FUNCTION__ : 'nojson.doctor.'.__FUNCTION__;
        return response()->view($view, ['doctor'=>$doctor]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor): Response {
        // Session::put('doctor', $value);
        $view = request()->expectsJson() ? 'json.doctor.'.__FUNCTION__ : 'nojson.doctor.'.__FUNCTION__;
        return response()->view($view, ['doctor'=>$doctor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor): Response {
        // return response()->json(["doctor"=>$doctor], 400, $headers);
        // global $doctor;
        // DB::beginTransaction();
        DB::transaction(function () use ($request, &$doctor) {
            // global $doctor;
            $attributes = null;
            $request->whenFilled('password', function () use ($request, &$attributes) {
                // dd('password is filled');
                $attributes = array_merge($request->only(['first_name', 'last_name', 'username',]), ['password'=>Hash::make($request->password)]);
            }, function () use ($request, &$attributes) {
                $attributes = $request->only(['first_name', 'last_name', 'username',]);
            });
            // dd('here in before update', $attributes);
            $doctor->update($attributes);
            $doctor->contact->update($request->only(['email', 'phone_number', 'preference',]));
            if ($request->hasFile('passport')) {
                $filename = "doc_$doctor->id.jpg";
                // dd('passport is present',$filename);
                \Storage::delete($filename);
                $doctor->picture->update(['url'=>$request->passport->storeAs('/', $filename)]);
            }
        });

        $doctor->refresh();
        // $doctorPicture = Picture::create(array_merge($request->only(['email', 'phone', 'preference',]), ['owner_id'=>$doctor->id, 'owner_type'=>Doctor::class]));
        // if ($request->expectsJson()) {
        return response()->json(['username' => $doctor->username]);
        // }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor) : Response {
        DB::transaction(function () use (&$doctor) {
            $filename = "doc_$doctor->id.jpg";
            $doctor->contact->delete();
            $doctor->picture->delete();
            $doctor->delete();
            \Storage::delete($filename);
        });
        return response()->json(['status'=>'success']);
    }
}
