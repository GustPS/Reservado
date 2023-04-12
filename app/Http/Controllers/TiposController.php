<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TiposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        // $tipos = Tipo::all();
        $tipos = Tipo::paginate(25);
        //dd($tipos);
        // echo $tipos;
        return view('tipo.lista', compact('tipos'));
        // return view('tipo.lista', ['tipo' => $tipos]);
    }

    public function create()
    {
        return view('tipo.formulario');
    }

    public function store(Request $request)
    {
        $tipo = new tipo();
        $tipo->fill($request->all());
        if ($tipo->save()) {
            $request->session()->flash('mensagem_sucesso', "Tipo salvo!");
        } else {
            $request->session()->flash('mensagem_erro', 'Deu erro');
        }
        return redirect::to('tipo/create');
    }

    public function update(Request $request, $tipo_id)
    {
        $tipo = Tipo::findOrFail($tipo_id);
        $tipo->fill($request->all());
        if ($tipo->save()) {
            $request->session()->flash('mensagem_sucesso', "Tipo alterado!");
        } else {
            $request->session()->flash('mensagem_erro', 'Deu erro');
        }
        return redirect::to('tipo/' . $tipo->id);
    }

    public function show($id)
    {
        $tipo = Tipo::findOrFail($id);
        return view('tipo.formulario', compact('tipo'));
    }

    public function deletar(Request $request, $tipo_id)
    {
        $tipo = Tipo::findOrFail($tipo_id);
        $tipo->delete();
        $request->session()->flash(
            'Mensagem_sucesso',
            'Tipo removido com sucesso'
        );
        return Redirect::to('tipo');
    }
}
