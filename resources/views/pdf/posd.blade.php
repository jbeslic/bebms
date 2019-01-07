<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Obrazac PO-SD</title>

    <style type="text/css">
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size:12px;
            color: black;
        }
        table {
            border: 1 solid;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td {
            border: 1 solid;
            padding: 5px 15px;
        }
        table.no-border, .no-border td {
            border: none;
        }


    </style>
</head>

<body>

    <table class="no-border">
        <tr>
            <td style="text-align: right; font-weight: bold;">
                Obrazac PO-SD
            </td>
        </tr>
        <tr>
            <td style="padding: 0 150px; text-align: center; font-weight: bold;">
                IZVJEŠĆE O PAUŠALNOM DOHOTKU OD SAMOSTALNE DJELATNOSTI I UPLAĆENOM PAUŠALNOM POREZU NA DOHODAK I PRIREZU POREZA NA DOHODAK U 2018. GODINI
            </td>
        </tr>
    </table>

    <table>
        <tr style="font-weight: bold; background-color: #d1d1d1;">
            <td colspan="3" >
                I. PODACI O POREZNOM OBVEZNIKU/NOSITELJU ZAJEDNIČKE DJELATNOSTI
            </td>
        </tr>
        <tr style="font-weight: bold; background-color: #d1d1d1;">
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
        <tr style="font-weight: bold; background-color: #d1d1d1;">
            <td colspan="2">
                II. PODACI O DJELATNOSTI
            </td>
        </tr>
        <tr >
            <td style="font-weight: bold; background-color: #d1d1d1; width: 35%;">
                1. NAZIV I VRSTA DJELATNOSTI
            </td>
            <td>
                {{ $data['company']->name }}
            </td>

        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #d1d1d1; width: 35%;">
                2. BROJ ZAPOSLENIH NA DAN 31.12.
            </td>
            <td>
                0
            </td>

        </tr>
    </table>

    <table>
        <tr style="font-weight: bold; background-color: #d1d1d1;">
            <td colspan="6">
                III. PODACI O OSTVARENIM PRIMICIMA I UPLAĆENOM PAUŠALNOM POREZU NA DOHODAK I PRIREZU POREZA NA DOHODAK
            </td>
        </tr>
        <tr style="font-weight: bold; background-color: #d1d1d1; text-align: center;">
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

        <tr style="text-align: center;">
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

        <tr style="text-align: right;">
            <td style="font-weight: bold; background-color: #d1d1d1;">
                1.1.-31.3.
            </td>
            <td>
                0
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
                {{  number_format($data['tax'][1], 2, ',', '.') }}
            </td>
        </tr>

        <tr style="text-align: right;">
            <td style="font-weight: bold; background-color: #d1d1d1;">
                1.4.-30.6.
            </td>
            <td>
                0
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
                {{ number_format($data['tax'][2], 2, ',', '.') }}
            </td>
        </tr>

        <tr style="text-align: right;">
            <td style="font-weight: bold; background-color: #d1d1d1;">
                1.7.-30.9.
            </td>
            <td>
                0
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
                {{  number_format($data['tax'][3], 2, ',', '.') }}
            </td>
        </tr>

        <tr style="text-align: right;">
            <td style="font-weight: bold; background-color: #d1d1d1;">
                1.10.-31.12.
            </td>
            <td>
                0
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
                {{  number_format($data['tax'][4], 2, ',', '.') }}
            </td>
        </tr>

        <tr style="font-weight: bold; text-align: right;">
            <td style="background-color: #d1d1d1;">
                UKUPNO
            </td>
            <td>
                0
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
                {{  number_format($data['tax']['sum'], 2, ',', '.') }}
            </td>
        </tr>

    </table>

    <table class="no-border" style="margin-top: 90px;">
        <tr>
            <td style="border-top: 1 solid; width: 33%; text-align: center;">
                NADNEVAK
            </td>
            <td style="width: 33%;">

            </td>
            <td style="border-top: 1 solid; width: 33%; text-align: center;">
                POTPIS
            </td>
        </tr>
    </table>


</body>
</html>