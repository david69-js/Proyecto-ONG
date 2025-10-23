<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PublicIndexSelectorController extends Controller
{
    /**
     * Muestra la vista donde se selecciona la página pública principal.
     */
    public function index()
    {
        $file = 'settings/home_index.json';
        $selected = 'index';

        if (Storage::disk('local')->exists($file)) {
            $data = json_decode(Storage::disk('local')->get($file), true);
            $selected = $data['selected'] ?? 'index';
        }

        $options = [
            'index'  => 'Página Principal (index.blade.php)',
            'index2' => 'Página Alternativa (index2.blade.php)',
        ];

        // 👉 Renderiza directamente la vista que tú mencionas
        return view('admin.settings.home-index-selector', compact('selected', 'options'));
    }

    /**
     * Guarda la página seleccionada como principal.
     */
    public function update(Request $request)
    {
        $request->validate([
            'home_index' => 'required|string|in:index,index2',
        ]);

        Storage::disk('local')->put('settings/home_index.json', json_encode([
            'selected' => $request->home_index,
        ]));

        return back()->with('ok', 'Página pública predeterminada actualizada correctamente.');
    }
}
