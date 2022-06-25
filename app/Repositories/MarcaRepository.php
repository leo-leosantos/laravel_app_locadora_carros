<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;



class MarcaRepository
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function selectAtributosRegistrosRelacionados($atributos)
    {
        $this->model =  $this->model->with($atributos);
        //atualizar sempre a query
    }


    public function filtro($filtros)
    {
        $filtros = explode(';', $filtros);

        foreach ($filtros as $key => $condicao) {
            $c = explode(':', $condicao);
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
            //atualizar sempre a query pq ela esta sendo montado

        }
    }
    public function selectAtributos($atributos)
    {
        $this->model = $this->model->selectRaw($atributos);
    }

    public function getResultado()
    {
        return $this->model->get();
    }
}