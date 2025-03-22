<?php

namespace App\Http\Controllers;

use App\Models\Criptomoedas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CriptomoedasController extends Controller
{

    public function index()
    {
        $regBook = Criptomoedas::All();
        $contador = $regBook->count();

        return Response()->json($regBook);
    }


    public function store(Request $request)  
    {

        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);  
        }

        $registros = Criptomoedas::create($request->all());

        if ($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda cadastrada com sucesso!', 
                'data' => $registros
            ], 201);  
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'Erro ao cadastrar a criptomoeda'
            ], 500); 
        }
    }

    public function show(Criptomoedas $id)
    {
        $regCripto = Criptomoedas::find($id);

        if($regCripto){
            return 'Critptomoedas Localizadas: '.$regCripto.Response()->json([],Response::HTTP_NO_CONTENT);
        } else {
            return 'Criptomoedas não localizadas: '.Response()->json([],Response::HTTP_NO_CONTENT);
        }
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $regCriptoBanco = Criptomoedas::find($id);

        if(!$regCriptoBanco) {
            return response()->json([
                'success' => false, 
                'message' => 'Criptomoeda não encontrada'
            ], 404);
        }

        $regCriptoBanco->siglaCripto = $request->siglaCripto;
        $regCriptoBanco->nomeCripto = $request->nomeCripto;
        $regCriptoBanco->valorCripto = $request->valorCripto;

        if ($regCriptoBanco->save()) {
            return response()->json([
                'success' => true, 
                'message' => 'Criptomoeda atualizada com sucesso!',
                'data' => $regCriptoBanco
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a criptomoeda'
            ], 500);
        }
        
    }


    public function destroy($id)
    {

    $regCripto = Criptomoedas::find($id);

    if (!$regCripto) {
        return response()->json([
            'success' => false,
            'message' => 'criptomoeda não encontrada'
        ], 404 );
    }

    if ($regCripto->delete()) {
        return response()->json([
            'success' => true, 
            'message' => 'Criptomoeda deletado com sucesso'
        ], 200);
    }

    return response()->json([
        'success' => false, 
        'message' => 'Erro ao deletar a criptomoeda'
    ], 500); 
}
}
