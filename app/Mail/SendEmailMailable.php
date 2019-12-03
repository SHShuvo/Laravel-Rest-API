<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Question;

class SendEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $date = new \DateTime();
        $date->modify('-48 hours');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $question = Question::orderBy('created_at','asc')->where('created_at', '>',$formatted_date);
        $count=$question->count();
        $latest=Question::orderBy('created_at','asc')->where('created_at', '>',$formatted_date)->limit(5)->get();
        return $this->view('mailpage')->with('latest',$latest)->with('count', $count);
    }
}
