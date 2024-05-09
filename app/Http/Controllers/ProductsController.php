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
        return Product::all();
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
            'preco' => 'required'
        ], [
            'nome.required' => 'O campo nome deve ser preenchido',
            'preco.required' => 'O campo preço deve ser preenchido'
        ]);

        if($request->hasFile('foto')) {
            $filename = "tteste"; // Pega o nome da imagem
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // Pega o nome sem a extensão
            $getfileExtension = $req->file('foto')->getClientOriginalExtension(); // Pega a extensão da imagem
            $createnewFileName = time().'_'.str_replace(' ','_', $getfilenamewitoutext).'.'.$getfileExtension; // Cria um random name
            $img_path =  public_path().'/produtos_img/'.$createnewFileName; 
            $req->file('foto')->move($img_path, $createnewFileName);

            $request->request->add(['foto' => $createnewFileName]);
        }

        $request->request->add(['client_id' => auth()->id()]);
        $request->merge(['slug' => Str::slug($request->input('nome'))]);

        return Product::create($request->all());
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
