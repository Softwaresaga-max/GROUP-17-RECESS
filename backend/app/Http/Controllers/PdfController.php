<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function discussionPdf(Discussion $discussion)
    {
        $discussion->load('user', 'replies.user');

        $pdf = Pdf::loadView('pdf.discussion', [
            'discussion' => $discussion
        ]);

        return $pdf->download(
            'discussion-'.$discussion->id.'.pdf'
        );
    }
}