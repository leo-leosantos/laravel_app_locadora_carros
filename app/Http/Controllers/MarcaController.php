<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function index(Request $request)
    {

        $marcaRepository = new MarcaRepository($this->marca);


        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,' . $request->atributos_modelo;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if ($request->has('filtro')) {

            $marcaRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json($marcaRepository->getResultado(), 200);
    }


    public function store(Request $request)
    {

        $request->validate($this->marca->rules(), $this->marca->feedback());


        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');



        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return response()->json($marca, 201);
    }


    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($marca, 200);
    }


    public function edit(Marca $marca)
    {
    }


    public function update(Request $request, $id)
    {


        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Recurso nao localizado para atualização'], 404);
        }


        if ($request->method() === 'PATCH') {
            //return ['teste' => 'Verbo patch'];

            $regrasDinamincas = array();
            //percorendo todas as regras definidas no model
            foreach ($marca->rules() as $input => $regra) {
                //coletar apenas as regras aplicaveis aos paramentros parcias da requisiçao pacth

                if (array_key_exists($input, $request->all())) {
                    $regrasDinamincas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamincas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        if ($request->file('imagem')) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;

        $marca->save();

        return response()->json($marca, 200);

        // preencher o objeto $marca com os dados do request
        // $marca->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);
    }


    public function destroy($id)
    {

        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Recurso nao localizado para remoção'], 404);
        }


        Storage::disk('public')->delete($marca->imagem);


        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso'], 200);
    }
}
