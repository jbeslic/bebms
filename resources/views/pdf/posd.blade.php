<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>

    <style type="text/css">
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size:12px;
            color: black;
        }
        .offer-box{
            max-width:800px;
            margin:auto;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            color:#555;
        }

        .offer-box table{
            width:100%;
            text-align:left;
        }

        .offer-box table td{
            vertical-align:top;
        }
        .offer-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
        }
        .offer-box table tr.date_place td{
            padding-bottom: 30px;
        }
        .offer-box table tr.information td{
            padding-top: 30px;
            padding-bottom: 15px;
        }

        .offer-box table tr.item td{
            border-bottom:1px solid #eee;
        }

        .offer-box table tr.item.last td{
            border-bottom:none;
        }

        .offer-box table tr.total td{
            border-top:2px solid #eee;
            font-weight:bold;
            padding-bottom: 30px;
        }

         .offer-box table td.barcode {
            padding-top: 50px;
        }

    </style>
</head>

<body>

    <table>
        <tr>
            <td>
                Obrazac PO-SD
            </td>
        </tr>
        <tr>
            <td>
                IZVJEŠĆE O PAUŠALNOM DOHOTKU OD SAMOSTALNE DJELATNOSTI I UPLAĆENOM PAUŠALNOM POREZU NA DOHODAK I PRIREZU POREZA NA DOHODAK U 2018. GODINI
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="3">
                I. PODACI O POREZNOM OBVEZNIKU/NOSITELJU ZAJEDNIČKE DJELATNOSTI
            </td>
        </tr>
        <tr>
            <td>
                IME I PREZIME
            </td>
            <td>
                OIB
            </td>
            <td>
                ADRESA PREBIVALIŠTA/ UOBIČAJENOG BORAVIŠTA
            </td>
        </tr>
        <tr>
            <td>
                {{ $data['company']->owner }}
            </td>
            <td>
                {{ $data['company']->oib }}
            </td>
            <td>
                {{ $data['company']->address }}, {{ $data['company']->zip_code }} {{ $data['company']->city }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2">
                II. PODACI O DJELATNOSTI
            </td>
        </tr>
        <tr>
            <td>
                1. NAZIV I VRSTA DJELATNOSTI
            </td>
            <td>
                {{ $data['company']->name }}
            </td>

        </tr>
        <tr>
            <td>
                2. BROJ ZAPOSLENIH NA DAN 31.12.
            </td>
            <td>
                1
            </td>

        </tr>
    </table>

    <table>
        <tr>
            <td colspan="6">
                III. PODACI O OSTVARENIM PRIMICIMA I UPLAĆENOM PAUŠALNOM POREZU NA DOHODAK I PRIREZU POREZA NA DOHODAK
            </td>
        </tr>
        <tr>
            <td>
                POREZNO RAZDOBLJE (KVARTALI)
            </td>
            <td>
                BROJ ZAPOSLENIH
            </td>
            <td>
                PRIMICI NAPLAĆENI U GOTOVINI
            </td>
            <td>
                PRIMICI NAPLAĆENI VIRMANSKI
            </td>
            <td>
                UKUPNO NAPLAĆENI PRIMICI
            </td>
            <td>
                UPLAĆENI POREZ NA DOHODAK I PRIREZ POREZU NA DOHODAK
            </td>
        </tr>

        <tr>
            <td>
                1
            </td>
            <td>
                2
            </td>
            <td>
                3
            </td>
            <td>
                4
            </td>
            <td>
                5 (3+4)
            </td>
            <td>
                6
            </td>
        </tr>

        <tr>
            <td>
                1.1.-31.3.
            </td>
            <td>
                1
            </td>
            <td>
                0,00
            </td>
            <td>
                {{  number_format($data['invoice'][1], 2, ',', '.') }}
            </td>
            <td>
                {{  number_format($data['invoice'][1], 2, ',', '.') }}
            </td>
            <td>
                0,00
            </td>
        </tr>

        <tr>
            <td>
                1.4.-30.6.
            </td>
            <td>
                1
            </td>
            <td>
                0,00
            </td>
            <td>
                {{  number_format($data['invoice'][2], 2, ',', '.') }}
            </td>
            <td>
                {{ number_format($data['invoice'][2], 2, ',', '.') }}
            </td>
            <td>
                0,00
            </td>
        </tr>

        <tr>
            <td>
                1.7.-30.9.
            </td>
            <td>
                1
            </td>
            <td>
                0,00
            </td>
            <td>
                {{  number_format($data['invoice'][3], 2, ',', '.') }}
            </td>
            <td>
                {{  number_format($data['invoice'][3], 2, ',', '.') }}
            </td>
            <td>
                0,00
            </td>
        </tr>

        <tr>
            <td>
                1.10.-31.12.
            </td>
            <td>
                1
            </td>
            <td>
                0,00
            </td>
            <td>
                {{  number_format($data['invoice'][4], 2, ',', '.') }}
            </td>
            <td>
                {{  number_format($data['invoice'][4], 2, ',', '.') }}
            </td>
            <td>
                0,00
            </td>
        </tr>

        <tr>
            <td>
                UKUPNO
            </td>
            <td>
                1
            </td>
            <td>
                0,00
            </td>
            <td>
                {{  number_format($data['invoice']['sum'], 2, ',', '.') }}
            </td>
            <td>
                {{  number_format($data['invoice']['sum'], 2, ',', '.') }}
            </td>
            <td>
                0,00
            </td>
        </tr>

    </table>




</body>
</html>