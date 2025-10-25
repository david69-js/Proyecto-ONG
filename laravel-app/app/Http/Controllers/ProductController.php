<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar lista de productos
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $query = Product::with(['creator', 'updater']);

        // Aplicar filtros
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('subcategory')) {
            $query->bySubcategory($request->subcategory);
        }

        if ($request->filled('stock_status')) {
            $query->where('stock_status', $request->stock_status);
        }

        if ($request->filled('condition')) {
            $query->byCondition($request->condition);
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        if ($request->filled('is_digital')) {
            $query->where('is_digital', $request->boolean('is_digital'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $products = $query->paginate(12);

        // Obtener categorías para el filtro
        $categories = Product::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->sort();

        $subcategories = Product::select('subcategory')
            ->distinct()
            ->whereNotNull('subcategory')
            ->pluck('subcategory')
            ->sort();

        return view('products.index', compact('products', 'categories', 'subcategories'));
    }

    /**
     * Mostrar formulario para crear producto
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        return view('products.create');
    }

    /**
     * Almacenar nuevo producto
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'subcategory' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => ['required', Rule::in(['in_stock', 'out_of_stock', 'low_stock', 'discontinued'])],
            'manage_stock' => 'boolean',
            'cost_price' => 'nullable|numeric|min:0',
            'suggested_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_digital' => 'boolean',
            'requires_shipping' => 'boolean',
            'ngo_notes' => 'nullable|string|max:1000',
            'donation_source' => 'nullable|string|max:255',
            'received_date' => 'nullable|date',
            'condition' => ['required', Rule::in(['new', 'like_new', 'good', 'fair', 'poor'])],
            'specifications' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'care_instructions' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['created_by'] = Auth::id();

        // Procesar tags
        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Procesar especificaciones
        if ($request->filled('specifications')) {
            $specs = [];
            $lines = explode("\n", $request->specifications);
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    [$key, $value] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($value);
                }
            }
            $data['specifications'] = $specs;
        }

        // Procesar imagen principal
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        // Procesar galería de imágenes
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store('products/gallery', 'public');
            }
            $data['gallery_images'] = $galleryImages;
        }

        $product = Product::create($data);

        return redirect()->route('products.show', $product)
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar producto específico
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        $product->load(['creator', 'updater']);

        return view('products.show', compact('product'));
    }

    /**
     * Mostrar formulario para editar producto
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'subcategory' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => ['required', Rule::in(['in_stock', 'out_of_stock', 'low_stock', 'discontinued'])],
            'manage_stock' => 'boolean',
            'cost_price' => 'nullable|numeric|min:0',
            'suggested_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_digital' => 'boolean',
            'requires_shipping' => 'boolean',
            'ngo_notes' => 'nullable|string|max:1000',
            'donation_source' => 'nullable|string|max:255',
            'received_date' => 'nullable|date',
            'condition' => ['required', Rule::in(['new', 'like_new', 'good', 'fair', 'poor'])],
            'specifications' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'care_instructions' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['updated_by'] = Auth::id();

        // Procesar tags
        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Procesar especificaciones
        if ($request->filled('specifications')) {
            $specs = [];
            $lines = explode("\n", $request->specifications);
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    [$key, $value] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($value);
                }
            }
            $data['specifications'] = $specs;
        }

        // Procesar imagen principal
        if ($request->hasFile('main_image')) {
            // Eliminar imagen anterior
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        // Procesar galería de imágenes
        if ($request->hasFile('gallery_images')) {
            // Eliminar imágenes anteriores
            if ($product->gallery_images) {
                foreach ($product->gallery_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store('products/gallery', 'public');
            }
            $data['gallery_images'] = $galleryImages;
        }

        $product->update($data);

        return redirect()->route('products.show', $product)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar producto
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        // Eliminar imágenes
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        if ($product->gallery_images) {
            foreach ($product->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Mostrar catálogo público
     */
    public function catalog(Request $request)
    {
        $query = Product::active()->with(['creator']);

        // Aplicar filtros
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('subcategory')) {
            $query->bySubcategory($request->subcategory);
        }

        if ($request->filled('condition')) {
            $query->byCondition($request->condition);
        }

        if ($request->filled('featured')) {
            $query->featured();
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $products = $query->paginate(12);

        // Obtener categorías para el filtro
        $categories = Product::active()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->sort();

        $subcategories = Product::active()
            ->select('subcategory')
            ->distinct()
            ->whereNotNull('subcategory')
            ->pluck('subcategory')
            ->sort();

        return view('products.catalog', compact('products', 'categories', 'subcategories'));
    }

    /**
     * Mostrar estadísticas de productos
     */
    public function statistics()
    {
        $this->authorize('viewAny', Product::class);

        $statistics = Product::getStatistics();
        $categoryStats = Product::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        $conditionStats = Product::selectRaw('`condition`, COUNT(*) as count')
            ->groupBy('condition')
            ->orderBy('count', 'desc')
            ->get();

        return view('products.statistics', compact('statistics', 'categoryStats', 'conditionStats'));
    }

    /**
     * Mostrar lista pública de productos
     */
    public function publicIndex(Request $request)
    {
        // Obtener productos activos de la base de datos
        $query = Product::where('is_active', true)->with(['creator']);

        // Aplicar filtros
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('condition')) {
            $query->byCondition($request->condition);
        }

        if ($request->filled('featured')) {
            $query->featured();
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $products = $query->get();

        // Obtener categorías para el filtro
        $categories = Product::where('is_active', true)
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->sort();

        return view('products.public-index', compact('products', 'categories'));
    }

    /**
     * Mostrar producto específico en vista pública
     */
    public function publicShow(Product $product)
    {
        // Verificar que el producto esté activo
        if (!$product->is_active) {
            abort(404);
        }

        $product->load(['creator']);

        return view('products.public-show', compact('product'));
    }
}
