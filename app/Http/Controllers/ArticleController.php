<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SousLot;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('sousLot')->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $sousLots = SousLot::all();
        return view('articles.create', compact('sousLots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sous_lot_id' => 'required|exists:sous_lots,id',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $request->merge([
            'budget' => $request->quantite * $request->prix_unitaire,
            'realisation' => 0,
            'marge_estimee' => 0
        ]);

        Article::create($request->all());
        return redirect()->route('articles.index')->with('success', 'Article ajouté avec succès.');
    }

    public function edit(Article $article)
    {
        $sousLots = SousLot::all();
        return view('articles.edit', compact('article', 'sousLots'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'sous_lot_id' => 'required|exists:sous_lots,id',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $request->merge([
            'budget' => $request->quantite * $request->prix_unitaire,
        ]);

        $article->update($request->all());
        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
    public function show(Article $article)
{
    // Charger le sous-lot lié pour l'affichage
    $article->load('sousLot');
    return view('articles.show', compact('article'));
}

}
