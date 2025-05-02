<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = Auth::user();
        //Check if the user making the request is an admin
        if ($user->role!="admin") {
            return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
        }
    
        // If the user is an admin, proceed to send the users
        $commands = Command::all();
    
        return response()->json(['commands' => $commands],200);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $user = Auth::user();

    $commands = $request->input('commands');

    foreach ($commands as $commandData) {
        Command::create([
            'user_id' => $user->id,
            'product_id' => $commandData['product_id'],
            'quantity' => $commandData['quantity'],
            'is_validate' =>false,
            'date_commande' => null ,
            'adresse' => $request->input('adresse'),
            'telephone' => $request->input('phoneNumber'),
            'received' => false ,
        ]);
    }


    return response()->json(['message' => 'Commands created successfully'], 201);
    }
     
    /**
     * Display the specified resource.
     */

    function getCombinedData()
    {
        $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

        $result = DB::table('commands')
            ->join('users', 'commands.user_id', '=', 'users.id')
            ->join('products', 'commands.product_id', '=', 'products.id')
            ->select(
            'commands.id as id_command',
            'users.id as user_id',
            'users.name as user_name',
            'users.email',
            'products.id as product_id',
            'products.title as product_title',
            'products.price as product_price',
            'products.image',
            'commands.adresse',
            'commands.telephone',
            'commands.quantity',
            'commands.is_validate',
            'commands.received',
            'commands.created_at as created_date' )
            ->get();
    
        return response()->json([
            'data' => $result
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    function getClientCommands(Request $request)
    {
        $user = Auth::user();

    $result = DB::table('commands')
        ->join('users', 'commands.user_id', '=', 'users.id')
        ->join('products', 'commands.product_id', '=', 'products.id')
        ->select(
            'commands.id as id_command',
            'users.id as user_id',
            'users.name as user_name',
            'users.email',
            'products.id as product_id',
            'products.title as product_title',
            'products.price as product_price',
            'products.image',
            'commands.adresse',
            'commands.telephone',
            'commands.quantity',
            'commands.is_validate',
            'commands.received',
            'commands.created_at as created_date' 
        )
        ->where('users.id', $user->id)
        ->get();

    return response()->json([
        'data' => $result
    ], 200);
    }
/**
     * Display the specified resource.
     */
     function updateCommandValidation(Request $request)
     {
        $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

         $validation = $request->input('validation');
     
         $command = Command::find($request->input('id'));
     
         if (!$command) {
             return response()->json(['message' => 'Command not found'], 404);
         }
     
         $command->is_validate = ($validation == 0) ? true : false ;
         $command->save();
     
         return response()->json(['message' => 'Command validation status updated successfully'], 200);
     }
    /**
     * Display the specified resource.
     */
    function updateCommandReceived(Request $request)
     {
        
         $validation = $request->input('validation');
     
         $command = Command::find($request->input('id'));
     
         if (!$command) {
             return response()->json(['message' => 'Command not found'], 404);
         }
     
         $command->Received = ($validation == 0) ? true : false ;
         $command->save();
     
         return response()->json(['message' => 'Command validation status updated successfully'], 200);
     }



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
        $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

        $command = Command::findOrFail($id);
    
        // Delete any related resources or perform any additional logic
    
        $command->delete();
    
        return response()->json(['message' => 'Command deleted'], 200);
    }
    
}
