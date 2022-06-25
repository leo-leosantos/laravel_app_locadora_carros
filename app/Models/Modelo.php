<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;


    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];


    public function rules()
    {
        return  [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,' . $this->id . '|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg',
            'numero_portas'=>'required|integer|digits_between:1,5',
            'lugares'=> 'required|integer|digits_between:1,20',
            'air_bag'=> 'required|boolean',
            'abs'=> 'required|boolean',//true, false, 1 ou 0, "1" true, "0" false

        ];

        /**
         * unique
         * 1) tabela
         * 2) nome da coluna pesquisa na tabela
         * 3) id do registro que sera desconsiderado na pesquisa
         *
         * @return void
         */
    }

  public function feedback()
    {
        return  [
            'required' => 'O campo :attribute  obrigatorio',
            'imagem.mimes' => 'O arquivo dever ser uma imagem no formato (png ou jpeg)',
            'nome.unique' => 'O nome do modelo já existe',
            'nome.min' => 'o nome deve ter no minino 3 caracteres'
        ];
    }

    public function marca()
    {
        //um modelo pertence a uma marca
        return $this->belongsTo('App\Models\Marca');

    }

}
