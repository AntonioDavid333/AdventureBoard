<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    /*public function attach(Request $request)
    {
        $request->validate([
            'heroe_id' => 'required|exists:heroes,id',
            'purchase_id' => 'required|exists:purchases,id',
        ]);

        Equipment::create([
            'heroe_id' => $request->heroe_id,
            'purchase_id' => $request->purchase_id,
            
        ]);

        return response()->json(['success' => true]);
    }*/

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($EquipmentId)
    {
        $equipment = Equipment::findOrFail($EquipmentId);
        $equipment->delete();
        return redirect()->route('heroes.index')/*->with('success', 'Equipamiento eliminado correctamente.')*/;
    }
}
