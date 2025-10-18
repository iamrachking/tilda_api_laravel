<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Enregistrer une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'imageUrl' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create([
            'categoryId' => Str::uuid(),
            'name' => $request->name,
            'imageUrl' => $request->imageUrl,
        ]); 

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Afficher une catégorie spécifique
     */
    public function show($categoryId)
    {
        $category = Category::where('categoryId', $categoryId)->firstOrFail();
        $recipes = $category->recipes()->with('chef')->paginate(10);
        
        return view('categories.show', compact('category', 'recipes'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($categoryId)
    {
        $category = Category::where('categoryId', $categoryId)->firstOrFail();
        return view('categories.edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, $categoryId)
    {
        $category = Category::where('categoryId', $categoryId)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'imageUrl' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update([
            'name' => $request->name,
            'imageUrl' => $request->imageUrl,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy($categoryId)
    {
        $category = Category::where('categoryId', $categoryId)->firstOrFail();
        
        // Vérifier s'il y a des recettes associées
        if ($category->recipes()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des recettes.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}
