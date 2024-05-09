<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::paginate(5);
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
            'cpf' => 'required|cpf',
            'sexo' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'cidade' => 'required',
            'estado' => 'required'
        ], [
            'nome.required' => 'O campo Nome deve ser preenchido',
            'cpf.required' => 'O campo CPF deve ser preenchido',
            'cpf.cpf' => 'CPF inválido',
            'sexo.required' => 'O campo Sexo deve ser preenchido',
            'cep.required' => 'O campo CEP deve ser preenchido',
            'logradouro.required' => 'O campo Logradouro deve ser preenchido',
            'numero.required' => 'O campo Número deve ser preenchido',
            'cidade.required' => 'O campo Cidade deve ser preenchido',
            'estado.required' => 'O campo Estado deve ser preenchido'
        ]);

        if($request->hasFile('foto')) {
            $filename = $request->file('foto')->getClientOriginalName();// Pega o nome da imagem
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // Pega o nome sem a extensão
            $getfileExtension = $request->file('foto')->getClientOriginalExtension(); // Pega a extensão da imagem
            $createnewFileName = time().'_'.str_replace(' ','_', $getfilenamewitoutext).'.'.$getfileExtension; // Cria um random name
            $img_path =  public_path().'/clientes_img'; 
            $request->file('foto')->move($img_path, $createnewFileName);

            $request->request->add(['foto' => $createnewFileName]);
        }

        $request->request->add(['user_id' => auth()->id()]);

        return Client::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Client::find($id);

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
        $client = Client::find($id);
        $client->update($request->all());

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Client::destroy($id);
    }
}
