<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklySummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    public function build()
    {
        return $this->subject('Laporan Ringkasan Mingguan - Bank Waway CMS')
                    ->view('emails.weekly_summary')
                    ->with($this->stats);
    }
}