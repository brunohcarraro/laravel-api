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
            'client_id' => 'required'
        ], [
            'nome.required' => 'O campo nome deve ser preenchido',
            'preco.required' => 'O campo preço deve ser preenchido',
            'client_id.required' => 'Preencha o ID do cliente'
        ]);

        if($request->hasFile('foto')) {

            $filename = $request->file('foto')->getClientOriginalName();// Pega o nome da imagem
            $createnewFileName = time().'_'.$filename; // Cria um random name
            $img_path =  public_path().'/produtos_img'; 
            $request->file('foto')->move($img_path, $createnewFileName);

            $request->request->add(['foto' => $createnewFileName]);
        }

        $request->merge(['slug' => Str::slug($request->input('nome'))]);

        if (!Client::find($request->client_id)) {
            return response([
                'message' => 'Você precisa cadastrar este cliente primeiramente.'
            ], 401);
        }

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
