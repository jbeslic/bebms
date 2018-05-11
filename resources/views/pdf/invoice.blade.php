<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>

    <style type="text/css">
        .invoice-box{
            max-width:800px;
            margin:auto;
            padding:30px;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:10px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', dejavusans, Arial, sans-serif;
            color:#555;
        }

        .invoice-box table{
            width:100%;
            text-align:left;
        }

        .invoice-box table td{
            vertical-align:top;
        }

        .invoice-box table tr td.right{
            text-align:right;
        }

        .invoice-box table tr.top table td{
            padding-bottom:10px;
        }

        .invoice-box table tr.top table td.title{
            font-size:45px;
            color:#333;
        }

        .invoice-box table tr.information table td{
            padding-bottom:20px;
        }

        .invoice-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
        }

        .invoice-box table tr.details td{
            padding-bottom:10px;
        }

        .invoice-box table tr.item td{
            border-bottom:1px solid #eee;
        }

        .invoice-box table tr.item.last td{
            border-bottom:none;
        }

        .invoice-box table tr.total td:nth-child(4){
            border-top:2px solid #eee;
            font-weight:bold;
        }

        .invoice-box table td.text {

        }
        .invoice-box table td.barcode {
            padding-top: 50px;
        }

    </style>
</head>

<body>
<div class="invoice-box" style="height: 850px">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">

            <td class="title text" colspan="4">
                <img src="img/logo_pdf.png" style="width: 200px;">
            </td>
            <td class="text" colspan="3">
                <strong>beDev</strong>, obrt za računalne djelatnosti <br/>
                vl. Josipa Bešlić, Trnjanska cesta 59,<br/>
                10000 Zagreb<br/>
                OIB: 00460997027<br/>
                IBAN: HR4023400091160517112 <br/>

            </td>


        </tr>

        <tr class="information">

            <td  style="padding-top: 13px" class="text" colspan="4">
                <strong><span style="color: #86c035;">RAČUN br. – invoice_number </span></strong>
            </td>

            <td colspan="3" class="text">
                <strong>Rechnungsempfänger:</strong><br/>
                company  <br/>
                person  <br/>
                street  <br/>
                city <br/>

            </td>
        </tr>

        <tr>
            <td colspan="2" class="text">
                Mjesto, datum i vrijeme izdavanja:
            </td>
            <td colspan="4" class="text">
                description
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text">
                Dospijeće plaćanja:
            </td>
            <td colspan="4" class="text">
                description
            </td>
        </tr>

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

        <tr class="item">
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

        <tr class="item">
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

        <tr>
            <td colspan="4">

            </td>
            <td colspan="2">
                IZNOS
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">

            </td>
            <td colspan="2">
                RABAT
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">

            </td>
            <td colspan="2">
                OSNOVICA
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">

            </td>
            <td colspan="2">
                PDV (25%)
            </td>
            <td></td>
        </tr>
        <tr class="total">
            <td colspan="4">

            </td>
            <td colspan="2">
                UKUPNI IZNOS
            </td>
            <td></td>
        </tr>

        <tr class="footer">
            <td colspan="2" class="text">Napomena:</td>
            <td colspan="5" class="text">
                Oslobođeno PDV-a temeljem članka 90. Zakona o PDV-u
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text">Račun ispostavio:</td>
            <td colspan="5" class="text">
                Josipa Bešlić
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text">Način plaćanja:</td>
            <td colspan="5" class="text">
                Transakcijski račun
            </td>
        </tr>
        <tr class="footer">
            <td colspan="2" class="text">Poziv na broj:</td>
            <td colspan="5" class="text">
                1-2018
            </td>
        </tr>
        <tr>
            <td class="barcode" colspan="5">
                <img style="width: 58mm; height: 26mm" src="data:image/png;base64,'{{ $data['barcode'] }}">
            </td>
        </tr>




    </table>

    <p style="position:fixed; bottom:15px; color: gray;  font-size: 10px; vertical-align:bottom; border-top: 1px solid grey; text-align: center;">
        beDev, obrt za računalne djelatnosti, vl. Josipa Bešlić, Trnjanska cesta 59, 10000 Zagreb,OIB 00460997027 <br />
        Žiro račun IBAN HR4023400091160517112 otvoren u Privredna banka Zagreb, SWIFT CODE: PBZGHR2X
    </p>
</div>
</body>
</html>