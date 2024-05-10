<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nome.required' => 'O campo nome deve ser preenchido',
            'preco.required' => 'O campo preço deve ser preenchido',
            'foto.image' => 'Não é permitido enviar aquivos, somente imagens.',
            'foto.mimes' => 'Envie um arquivo nos formatos jpeg, png, jpg ou gif.'
        ]);

        $request->merge(['slug' => Str::slug($request->input('nome'))]);
        $request->request->add(['client_id' => auth()->id()]);
        $create = Product::create($request->all());

        if($request->file('foto')) {
            $imageName = time() . '.' . $request->file('foto')->getClientOriginalExtension();
            $public_path_lg = 'public/imagens/produtos/' .$create->id;

            $filePath = $request->file('foto')->storeAs($public_path_lg, $imageName);

            $create->foto = $imageName;
            $create->save();
        }        

        return $create;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $request->merge(['slug' => Str::slug($request->input('nome'))]);        
        $product->update($request->all());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

    /**
     * Buscar por cliente.
     *
     * @param  int  $client_id
     * @return \Illuminate\Http\Response
     */
    public function search_client($id)
    {
        return Product::where('client_id', $id)->paginate(5);
    }

    /**
     * Buscar por nome.
     *
     * @param  str  $nome
     * @return \Illuminate\Http\Response
     */
    public function search($nome)
    {
        return Product::where('nome', 'like', '%'.$nome.'%')->get();
    }
}
