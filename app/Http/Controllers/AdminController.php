<?php

namespace App\Http\Controllers;

use App\Models\reserv;
use App\Models\User;
use App\Models\Veh;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $users = User::where('role','client')->get();
        return view('partials.admin.showUsers',compact('users'));
    }
    public function addUser() {
        return view('partials.admin.addUser'); // Vue pour afficher le formulaire d'ajout
    }
    public function storeUser(Request $request) {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);
    
        // Créer un nouvel utilisateur
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hacher le password
            'role' => $request->role,
        ]);
        // Rediriger vers la liste des utilisateurs
        return redirect('/showUsers');
    }

    public function showR() {
        $rs = reserv::all();
        return view('partials.admin.showReserv',compact('rs'));
    }

    public function editUser($id) {
        $us = User::find($id);
        return view('partials.admin.editUser',compact('us'));
    }

    public function updateUser(Request $request, $id) {
        User::find($id)->update($request->all()); 
        return redirect('/showUsers');
    }

    public function destroyU($id) {
        User::find($id)->delete();
        return redirect('/showUsers');
    }

    public function showV() {
        $vs = Veh::all();
        return view('partials.admin.showVehicul',compact('vs'));
    }

    public function addVehicule() {
        return view('partials.admin.addVehicule');
    }

    public function storeVehicule(Request $request) {
        // $validated = $request->validate([
        //     'dispo' => 'required|string',
        //     'marque' => 'required|string',
        //     'prix' => 'required|numeric',
        // ]);
    
        // Stocker les données dans la base de données
        Veh::create([
            'dispo' => $request->dispo,
            'marque' => $request->marque,
            'prix' => $request->prix
        ]);
        return redirect('/showVehicule');
    }

    public function editVeh($id) {
        $veh = Veh::find($id);
        return view('partials.admin.editVeh',compact('veh'));
    }

    public function updateVeh(Request $request, $id) {
        Veh::find($id)->update([
            'dispo' => $request->dispo,
            'marque' => $request->marque,
            'prix' => $request->prix
        ]);
        return redirect('/showVehicule');
    }

    public function destroy($id) {
        Veh::find($id)->delete();
        return redirect('/showVehicule');
    }
    public function showReservation() {

        $reservations = reserv::join('users', 'reservs.userId', '=', 'users.id')
        ->join('vehs', 'reservs.vehId', '=', 'vehs.id')
        ->select('reservs.*', 'users.name as user_name', 'vehs.marque as veh_marque')
        ->get();

    return view('partials.admin.showReservation', compact('reservations'));
    }
    public function createReservation()
{
    $users = User::all(); // Récupère tous les utilisateurs
    $vehs = Veh::all();   // Récupère tous les véhicules
    return view('partials.admin.createReservation', compact('users', 'vehs'));
}
public function storeReservation(Request $request)
{
    $validated = $request->validate([
        'userId' => 'required|exists:users,id',
        'vehId' => 'required|exists:vehs,id',
        'date_reservation' => 'required|date',
    ]);

    try {
        Reserv::create([
            'userId' => $validated['userId'],
            'vehId' => $validated['vehId'],
            'date_reservation' => $validated['date_reservation'],
        ]);
        
        return redirect()->route('showReservation')->with('success', 'Réservation ajoutée avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}
public function editReservation($id)
{
    $reservation = reserv::findOrFail($id);
    $users = User::all();
    $vehs = Veh::all();
    return view('partials.admin.editReservation', compact('reservation', 'users', 'vehs'));
}
public function updateReservation(Request $request, $id)
{
    $validated = $request->validate([
        'userId' => 'required|exists:users,id',
        'vehId' => 'required|exists:vehs,id',
        'date_reservation' => 'required|date',
    ]);

    reserv::findOrFail($id)->update($validated);
    return redirect()->route('showReservation')->with('success', 'Réservation mise à jour avec succès.');
}
public function destroyReservation($id)
{
    reserv::findOrFail($id)->delete();
    return redirect()->route('showReservation')->with('success', 'Réservation supprimée avec succès.');
}

}
