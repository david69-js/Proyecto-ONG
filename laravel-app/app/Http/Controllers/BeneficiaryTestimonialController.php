<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\BeneficiaryTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeneficiaryTestimonialController extends Controller
{
    public function index(Request $request)
    {
        $beneficiaries = Beneficiary::orderBy('name')->get();

        $testimonials = BeneficiaryTestimonial::with('beneficiary')
            ->when($request->search, function($query) use($request) {
                $s = '%'.$request->search.'%';
                $query->where(function($q) use ($s) {
                    $q->where('body','like',$s)
                      ->orWhere('author_name','like',$s)
                      ->orWhere('company','like',$s)
                      ->orWhere('role','like',$s);
                })->orWhereHas('beneficiary', fn($qb)=>$qb->where('name','like',$s));
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        // Vista única
return view('sections.testimonials.index', compact('testimonials','beneficiaries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'beneficiary_id' => ['required','exists:ng_beneficiaries,id'],
            'title'          => ['nullable','string','max:150'],
            'body'           => ['required','string','max:2000'],
            'rating'         => ['required','integer','min:1','max:5'],
            'role'           => ['nullable','string','max:100'],
            'company'        => ['nullable','string','max:150'],
            'author_name'    => ['nullable','string','max:150'],
            'avatar'         => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $data = $request->only([
            'beneficiary_id','title','body','rating','role','company','author_name'
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('beneficiaries/avatars','public');
        }
        $data['created_by'] = auth()->id();

        BeneficiaryTestimonial::create($data);

        cache()->forget('home:testimonials');
        return back()->with('ok','Testimonio creado.');
    }

    public function update(Request $request, BeneficiaryTestimonial $testimonial)
    {
        $request->validate([
            'beneficiary_id' => ['required','exists:ng_beneficiaries,id'],
            'title'          => ['nullable','string','max:150'],
            'body'           => ['required','string','max:2000'],
            'rating'         => ['required','integer','min:1','max:5'],
            'role'           => ['nullable','string','max:100'],
            'company'        => ['nullable','string','max:150'],
            'author_name'    => ['nullable','string','max:150'],
            'avatar'         => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $data = $request->only([
            'beneficiary_id','title','body','rating','role','company','author_name'
        ]);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar_path) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('beneficiaries/avatars','public');
        }
        $data['updated_by'] = auth()->id();

        $testimonial->update($data);

        cache()->forget('home:testimonials');
        return back()->with('ok','Testimonio actualizado.');
    }

    public function destroy(BeneficiaryTestimonial $testimonial)
    {
        if ($testimonial->avatar_path) {
            Storage::disk('public')->delete($testimonial->avatar_path);
        }
        $testimonial->delete();

        cache()->forget('home:testimonials');
        return back()->with('ok','Testimonio eliminado.');
    }

    public function togglePublish(BeneficiaryTestimonial $testimonial)
    {
        if ($testimonial->is_published) {
            $testimonial->update(['is_published'=>false, 'published_at'=>null]);
            $msg = 'Testimonio despublicado.';
        } else {
            $testimonial->update(['is_published'=>true, 'published_at'=>now()]);
            $msg = 'Testimonio publicado.';
        }
        cache()->forget('home:testimonials');
        return back()->with('ok', $msg);
    }
}
