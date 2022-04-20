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
            'imagem' => 'required'
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
            'required' => 'O campo :attribute é obrigatorio',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'o nome deve ter no minino 3 caracteres'
        ];
    }
}
