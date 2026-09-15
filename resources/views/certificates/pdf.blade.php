<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion - {{ $certificate->certificate_number }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 25px;
            background-color: #F5EFDF;
            color: #0B2545;
            -webkit-print-color-adjust: exact;
        }
        .outer-border {
            border: 4px solid #0B2545;
            padding: 6px;
            height: 94%;
            background-color: #FFFFFF;
            position: relative;
        }
        .inner-border {
            border: 2px dashed #C89B3C;
            padding: 30px 40px;
            height: 90%;
            text-align: center;
            background-color: #FFFFFF;
        }
        .logo-text {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #0B2545;
            text-transform: uppercase;
        }
        .logo-gold {
            color: #C89B3C;
        }
        .subtitle {
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #777777;
            margin-top: 4px;
        }
        .cert-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 3px;
            color: #0B2545;
            text-transform: uppercase;
            margin-top: 25px;
            margin-bottom: 8px;
        }
        .presented-to {
            font-size: 13px;
            font-style: italic;
            color: #555555;
            margin-top: 15px;
        }
        .recipient-name {
            font-size: 34px;
            font-weight: bold;
            color: #0B2545;
            border-bottom: 2px solid #C89B3C;
            display: inline-block;
            padding-bottom: 4px;
            margin-top: 8px;
            margin-bottom: 12px;
            min-width: 320px;
        }
        .achievement-text {
            font-size: 14px;
            color: #444444;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .course-title {
            font-size: 22px;
            font-weight: bold;
            color: #C89B3C;
            margin-top: 6px;
            margin-bottom: 20px;
        }
        .footer-table {
            width: 100%;
            margin-top: 30px;
        }
        .footer-table td {
            vertical-align: bottom;
            text-align: center;
        }
        .signature-line {
            width: 180px;
            border-top: 1px solid #0B2545;
            margin: 0 auto 5px auto;
        }
        .signer-title {
            font-size: 10px;
            font-weight: bold;
            color: #0B2545;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .seal-circle {
            width: 75px;
            height: 75px;
            border: 3px solid #C89B3C;
            border-radius: 50%;
            margin: 0 auto;
            background-color: #FDFBF7;
            text-align: center;
            line-height: 70px;
            font-size: 10px;
            font-weight: bold;
            color: #C89B3C;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cert-meta {
            font-size: 9px;
            color: #888888;
            margin-top: 20px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="outer-border">
        <div class="inner-border">
            <div class="logo-text">
                Fin<span class="logo-gold">Pulse</span>
            </div>
            <div class="subtitle">Financial Education & Market Intelligence</div>

            <div class="cert-title">Certificate of Completion</div>

            <div class="presented-to">This is proudly awarded to</div>
            <div class="recipient-name">{{ $certificate->user->name }}</div>

            <div class="achievement-text">
                for successfully completing all curriculum modules, master lessons, and rigorous competency assessments in
            </div>
            <div class="course-title">{{ $certificate->course->title }}</div>

            <table class="footer-table">
                <tr>
                    <td style="width: 33%;">
                        <div class="signature-line"></div>
                        <div class="signer-title">{{ $certificate->course->author->name ?? 'Academic Director' }}</div>
                        <div style="font-size: 9px; color: #777;">Course Lead Instructor</div>
                    </td>
                    <td style="width: 34%;">
                        <div class="seal-circle">
                            Verified
                        </div>
                    </td>
                    <td style="width: 33%;">
                        <div class="signature-line"></div>
                        <div class="signer-title">{{ $certificate->issued_at->format('F d, Y') }}</div>
                        <div style="font-size: 9px; color: #777;">Date of Issuance</div>
                    </td>
                </tr>
            </table>

            <div class="cert-meta">
                Certificate ID: <strong>{{ $certificate->certificate_number }}</strong> &bull; Authenticity verified by FinPulse Academy
            </div>
        </div>
    </div>
</body>
</html>
