<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>

    <style type="text/css">
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size:12px;
            color: gray;
        }
        .invoice-box{
            max-width:800px;
            margin:auto;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            color:#555;
        }

        .invoice-box table{
            width:100%;
            text-align:left;
        }

        .invoice-box table td{
            vertical-align:top;
        }
        .invoice-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
        }
        .invoice-box table tr.date_place td{
            padding-bottom: 30px;
        }
        .invoice-box table tr.information td{
            padding-top: 30px;
            padding-bottom: 15px;
        }

        .invoice-box table tr.item td{
            border-bottom:1px solid #eee;
        }

        .invoice-box table tr.item.last td{
            border-bottom:none;
        }

        .invoice-box table tr.total td{
            border-top:2px solid #eee;
            font-weight:bold;
            padding-bottom: 30px;
        }

         .invoice-box table td.barcode {
            padding-top: 50px;
        }

    </style>
</head>

<body>

    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td class="title text" style="width: 460px;" colspan="4">
                <img src="img/logo_pdf.PNG" style="width: 200px;">
            </td>
            <td class="text" colspan="3">
                <strong>beDev</strong>, obrt za računalne djelatnosti <br/>
                vl. Josipa Bešlić, Trnjanska cesta 59,<br/>
                10000 Zagreb<br/>
                OIB: 00460997027<br/>
                IBAN: HR4023400091160517112 <br/>

            </td>
        </tr>
    </table>
    <p style="border-top: 1px solid grey;"></p>

    <div class="invoice-box">
        <table>
            <tr class="information">

                <td colspan="2" style="width: 450px;">
                    <strong><span style="color: #6ba3ff;">RAČUN br. – invoice_number </span></strong>
                </td>

                <td>
                    <strong>company</strong><br/>
                    street  <br/>
                    zip code, city  <br/>
                    OIB  <br/>
                </td>
            </tr>

            <tr class="date_place">
                <td>
                    Mjesto, datum i vrijeme izdavanja:
                </td>
                <td colspan="2">
                    description
                </td>
            </tr>
        </table>

        <table>
            <tr class="heading">
                <td>
                    #
                </td>
                <td width="30%">
                    Trgovački naziv dobra - usluge
                </td>
                <td>
                    JM
                </td>
                <td>
                    Količina.
                </td>
                <td>
                    Cijena
                </td>
                <td>
                    Rabat
                </td>
                <td>
                    Iznos
                </td>
            </tr>

            <tr class="item last">
                <td>
                    1
                </td>
                <td width="30%">
                    Usluga programiranja
                </td>
                <td>
                    sat
                </td>
                <td>
                    80
                </td>
                <td>
                    150,00
                </td>
                <td>
                    0%
                </td>
                <td>
                    12500,00
                </td>
            </tr>


            {{--@foreach($items as $item)

            <tr class="item @if($loop->last) last @endif">
                <td width="30%">
                    item->product_title  <br/>
                    fullname  <br/>
                    course_date
                </td>
                <td>
                    items->count()
                </td>
                <td>
                   {{ Price::euroFormat($item->price) }}
                </td>
                <td>
                    {{ Price::numberFormat($item->tax) }}
                </td>
                <td>
                   {{ Price::euroFormat($item->price) }}
                </td>
            </tr>

            @endforeach--}}

            <tr class="total">
                <td colspan="4">

                </td>
                <td colspan="2">
                    UKUPNI IZNOS
                </td>
                <td></td>
            </tr>
        </table>

        <table class="info">
            <tr>
                <td>Napomena:</td>
                <td>
                    Oslobođeno PDV-a temeljem članka 90. Zakona o PDV-u
                </td>
            </tr>
            <tr>
                <td>Račun ispostavio:</td>
                <td>
                    Josipa Bešlić
                </td>
            </tr>
            <tr>
                <td>
                    Dospijeće plaćanja:
                </td>
                <td>
                    description
                </td>
            </tr>
            <tr>
                <td>Način plaćanja:</td>
                <td>
                    Transakcijski račun
                </td>
            </tr>
            <tr>
                <td>Poziv na broj:</td>
                <td>
                    1-2018
                </td>
            </tr>
            <tr>
                <td class="barcode" colspan="2">
                    <img style="width: 58mm; height: 26mm" src="data:image/png;base64,'{{ $data['barcode'] }}">
                </td>
            </tr>




        </table>
    </div>
    <p style="position:fixed; bottom:15px; color: gray;  font-size: 10px; vertical-align:bottom; border-top: 1px solid grey; text-align: center;">
        beDev, obrt za računalne djelatnosti, vl. Josipa Bešlić, Trnjanska cesta 59, 10000 Zagreb,OIB 00460997027 <br />
        Žiro račun IBAN HR4023400091160517112 otvoren u Privredna banka Zagreb, SWIFT CODE: PBZGHR2X
    </p>

</body>
</html>