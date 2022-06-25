<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];


    public function rules()
    {
        return  [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg'
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
            'imagem.mimes'=>'O arquivo dever ser uma imagem no formato (png ou jpeg)',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'o nome deve ter no minino 3 caracteres'
        ];
    }

    public function modelos()
    {
        //uma marca possui muitos modelos para
        return $this->hasMany('App\Models\Modelo');
    }
}
