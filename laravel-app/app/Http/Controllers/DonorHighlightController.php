<?php

namespace App\Http\Controllers;

use App\Models\DonorHighlight;
use App\Models\Donation;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonorHighlightController extends Controller
{
    public function index(Request $request)
    {
        $donations = Donation::orderByDesc('id')->limit(50)->get(); // para vincular rápidamente si quieres
        $sponsors  = Sponsor::orderBy('name')->get();

        $items = DonorHighlight::query()
            ->when($request->search, function($q) use ($request) {
                $s = '%'.$request->search.'%';
                $q->where(function($w) use ($s){
                    $w->where('name','like',$s)
                      ->orWhere('position','like',$s)
                      ->orWhere('bio','like',$s)
                      ->orWhere('skills','like',$s);
                });
            })
            ->orderBy('is_featured','desc')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('sections/donors/index', compact('items','donations','sponsors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required','string','max:150'],
            'position'    => ['nullable','string','max:150'],
            'email'       => ['nullable','email','max:150'],
            'phone'       => ['nullable','string','max:50'],
            'bio'         => ['nullable','string','max:2000'],
            'badge_text'  => ['nullable','string','max:100'],
            'skills'      => ['nullable','string','max:300'],
            'donation_id' => ['nullable','exists:donations,id'],
            'sponsor_id'  => ['nullable','exists:ng_sponsors,id'],
            'avatar'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'linkedin_url'=> ['nullable','url','max:255'],
            'twitter_url' => ['nullable','url','max:255'],
            'facebook_url'=> ['nullable','url','max:255'],
            'instagram_url'=>['nullable','url','max:255'],
            'website_url' => ['nullable','url','max:255'],
            'is_featured' => ['nullable','boolean'],
            'sort_order'  => ['nullable','integer','min:0','max:9999'],
        ]);

        $data = $request->except('avatar');
        $data['is_featured'] = (bool)($data['is_featured'] ?? false);

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('donors/avatars','public');
        }
        $data['created_by'] = auth()->id();

        DonorHighlight::create($data);
        cache()->forget('home:donors');

        return back()->with('ok','Donador agregado a la vitrina.');
    }

    public function update(Request $request, DonorHighlight $highlight)
    {
        $request->validate([
            'name'        => ['required','string','max:150'],
            'position'    => ['nullable','string','max:150'],
            'email'       => ['nullable','email','max:150'],
            'phone'       => ['nullable','string','max:50'],
            'bio'         => ['nullable','string','max:2000'],
            'badge_text'  => ['nullable','string','max:100'],
            'skills'      => ['nullable','string','max:300'],
            'donation_id' => ['nullable','exists:donations,id'],
            'sponsor_id'  => ['nullable','exists:ng_sponsors,id'],
            'avatar'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'linkedin_url'=> ['nullable','url','max:255'],
            'twitter_url' => ['nullable','url','max:255'],
            'facebook_url'=> ['nullable','url','max:255'],
            'instagram_url'=>['nullable','url','max:255'],
            'website_url' => ['nullable','url','max:255'],
            'is_featured' => ['nullable','boolean'],
            'sort_order'  => ['nullable','integer','min:0','max:9999'],
        ]);

        $data = $request->except('avatar');
        $data['is_featured'] = (bool)($data['is_featured'] ?? false);

        if ($request->hasFile('avatar')) {
            if ($highlight->avatar_path) Storage::disk('public')->delete($highlight->avatar_path);
            $data['avatar_path'] = $request->file('avatar')->store('donors/avatars','public');
        }
        $data['updated_by'] = auth()->id();

        $highlight->update($data);
        cache()->forget('home:donors');

        return back()->with('ok','Donador actualizado.');
    }

    public function destroy(DonorHighlight $highlight)
    {
        if ($highlight->avatar_path) Storage::disk('public')->delete($highlight->avatar_path);
        $highlight->delete();

        cache()->forget('home:donors');
        return back()->with('ok','Donador eliminado de la vitrina.');
    }

    public function togglePublish(DonorHighlight $highlight)
    {
        if ($highlight->is_published) {
            $highlight->update(['is_published'=>false, 'published_at'=>null]);
            $msg = 'Despublicado.';
        } else {
            $highlight->update(['is_published'=>true, 'published_at'=>now()]);
            $msg = 'Publicado.';
        }
        cache()->forget('home:donors');

        return back()->with('ok', "Donador $msg");
    }
}
