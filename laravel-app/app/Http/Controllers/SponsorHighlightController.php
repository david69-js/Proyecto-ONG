<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\SponsorHighlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorHighlightController extends Controller
{
    public function index(Request $request)
    {
        $sponsors = Sponsor::orderBy('id')->get();

        $items = SponsorHighlight::with('sponsor')
            ->when($request->search, function($q) use ($request) {
                $s = '%'.$request->search.'%';
                $q->where(function($w) use ($s) {
                    $w->where('title','like',$s)
                      ->orWhere('category','like',$s)
                      ->orWhere('description','like',$s);
                })->orWhereHas('sponsor', fn($qq) => $qq->where('name','like',$s));
            })
            ->orderBy('is_featured','desc')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20)->withQueryString();

        return view('sections.sponsors.index', compact('items','sponsors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sponsor_id'  => ['required','exists:ng_sponsors,id'],
            'title'       => ['nullable','string','max:150'],
            'category'    => ['nullable','string','max:150'],
            'description' => ['nullable','string','max:2000'],
            'logo'        => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:2048'],
            'is_featured' => ['nullable','boolean'],
            'sort_order'  => ['nullable','integer','min:0','max:9999'],
        ]);

        $data = $request->only(['sponsor_id','title','category','description','is_featured','sort_order']);
        $data['is_featured'] = (bool)($data['is_featured'] ?? false);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('sponsors/logos','public');
        }
        $data['created_by'] = auth()->id();

        SponsorHighlight::create($data);
        cache()->forget('home:sponsors');

        return back()->with('ok','Patrocinador agregado a la vitrina.');
    }

    public function update(Request $request, SponsorHighlight $highlight)
    {
        $request->validate([
            'sponsor_id'  => ['required','exists:ng_sponsors,id'],
            'title'       => ['nullable','string','max:150'],
            'category'    => ['nullable','string','max:150'],
            'description' => ['nullable','string','max:2000'],
            'logo'        => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:2048'],
            'is_featured' => ['nullable','boolean'],
            'sort_order'  => ['nullable','integer','min:0','max:9999'],
        ]);

        $data = $request->only(['sponsor_id','title','category','description','is_featured','sort_order']);
        $data['is_featured'] = (bool)($data['is_featured'] ?? false);

        if ($request->hasFile('logo')) {
            if ($highlight->logo_path) Storage::disk('public')->delete($highlight->logo_path);
            $data['logo_path'] = $request->file('logo')->store('sponsors/logos','public');
        }
        $data['updated_by'] = auth()->id();

        $highlight->update($data);
        cache()->forget('home:sponsors');

        return back()->with('ok','Patrocinador actualizado.');
    }

    public function destroy(SponsorHighlight $highlight)
    {
        if ($highlight->logo_path) Storage::disk('public')->delete($highlight->logo_path);
        $highlight->delete();

        cache()->forget('home:sponsors');
        return back()->with('ok','Patrocinador eliminado de la vitrina.');
    }

    public function togglePublish(SponsorHighlight $highlight)
    {
        if ($highlight->is_published) {
            $highlight->update(['is_published'=>false, 'published_at'=>null]);
            $msg = 'Despublicado.';
        } else {
            $highlight->update(['is_published'=>true, 'published_at'=>now()]);
            $msg = 'Publicado.';
        }
        cache()->forget('home:sponsors');

        return back()->with('ok', "Patrocinador $msg");
    }
}
