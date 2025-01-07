<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatiIscrizioni extends Model
{
    public $nome;
    public $cognome;
    public $tilolo_corso;
    public $data_iscrizione;
    public $pagato;

    public function __construct($nome, $cognome, $tilolo_corso, $data_iscrizione, $pagato)
    {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->tilolo_corso = $tilolo_corso;
        $this->data_iscrizione = $data_iscrizione;
        $this->pagato = $pagato;
    }
    
}
