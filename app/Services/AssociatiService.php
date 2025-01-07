<?php

namespace App\Services;
use Log;
use App\Mail\ConfermaAssociazione;
use App\Mail\RichiestaAssociazione;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Mail\ConfermaIscrizione;
use DB;

class AssociatiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function pdfCardAssociato($userData)
    {
        $n_tessera = str_pad($userData->n_tessera, 5, '0', STR_PAD_LEFT);
        $pdf = PDF::loadView('tessera', ['nome' => $userData->nome, 'cognome' => $userData->cognome, 'n_tessera' =>$n_tessera]);
        log::info(url(asset('/css/tessera.css')));
         return $pdf->save(storage_path('app/public/tessere/tessera_'.$n_tessera.'.pdf'));
        // return $pdf->stream();
    }

    public function invioConfermaAssociazione($data) {
        Log::info("dati associato: ". $data->email);
        Mail::
        to($data->email)
        ->send(new ConfermaAssociazione($data));
    }
    public function invioRichiestaAssociazione($data) {
        Mail::to($data->email)
        ->send(new RichiestaAssociazione($data));
    }
    public function invioConfermaIscrizioneCorso($userID, $corsoID) {
        $datiAssociato = $this->datiAssociatoIscritto($userID, $corsoID);
        Mail::to($datiAssociato->email)
        ->send(new ConfermaIscrizione($datiAssociato));
    }

    private function datiAssociatoIscritto($userID, $corsoID) {
        $query = DB::table('iscrizione_corsi')
        ->join('corsi', 'iscrizione_corsi.corso_id', '=', 'corsi.id')
        ->join('associati', 'iscrizione_corsi.associato_id', '=', 'associati.id')
        ->select('associati.nome', 'associati.cognome', 'associati.email', 'corsi.titolo', 'corsi.descrizione' , 'corsi.data_inizio', 'corsi.data_fine')
        ->where('associato_id', $userID)
        ->where('corso_id', $corsoID);
        $dati = $query->first();
        return $dati;
    }
}
