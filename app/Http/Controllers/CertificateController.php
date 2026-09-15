<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CertificateController extends Controller
{
    public function download(Request $request, int $id): Response
    {
        $certificate = Certificate::with(['user', 'course'])->findOrFail($id);

        if ($request->user()->id !== $certificate->user_id && ! $request->user()->hasRole('Admin')) {
            abort(403, 'You are not authorized to download this certificate.');
        }

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('FinPulse-Certificate-'.$certificate->certificate_number.'.pdf');
    }
}
