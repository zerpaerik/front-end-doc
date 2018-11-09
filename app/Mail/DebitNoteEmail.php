<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use Config;

class DebitNoteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $demo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $client = new Client();
        $url = '' . env('API_HOST', NULL). '/mailconfiguration/company/' . $this->demo->company;        
        $response = $client->get($url, 
                            array(
                                'headers'   =>  array('Authorization' => 'Bearer ' . $this->demo->token)
                            )
                        );

        $response->getBody()->rewind();
        $emailObject    = json_decode($response->getBody()->getContents());        
        $body           = $emailObject->body;
        $legend         = $emailObject->legend;
        $mailResponse   = $emailObject->companyEmail;
        $companyName    = $emailObject->companyName; 

        if(isset($this->demo->xml_file)){
            return $this->from('no.reply.quantumapp@gmail.com')
                    ->subject($emailObject->subject)
                    ->view('mails.debitnote', compact('body', 'legend', 'mailResponse', 'companyName'))                    
                    ->text('mails.debitnote_plain', compact('body', 'legend', 'mailResponse', 'companyName'))                    
                    ->attach($this->demo->pdf_file, ['as' => 'debitNote.pdf', 'mime' => 'application/pdf'])
                    ->attach($this->demo->xml_file, ['as' => 'debitNote.xml', 'mime' => 'text/xml']);
        }
        else{
            return $this->from('no.reply.quantumapp@gmail.com')
                    ->subject($emailObject->subject)
                    ->view('mails.debitnote', compact('body', 'legend', 'mailResponse', 'companyName'))                    
                    ->text('mails.debitnote_plain', compact('body', 'legend', 'mailResponse', 'companyName'))                    
                    ->attach($this->demo->pdf_file, ['as' => 'debitNote.pdf', 'mime' => 'application/pdf']);
        }
    }
}