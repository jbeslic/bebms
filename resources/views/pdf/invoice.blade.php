<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rechnung</title>

    <style type="text/css">
        .invoice-box{
            max-width:800px;
            margin:auto;
            padding:30px;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#555;
        }

        .invoice-box table{
            width:100%;
            text-align:left;
        }

        .invoice-box table td{
            padding:5px;
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
            padding: 10px 0;
        }

    </style>
</head>

<body>
<div class="invoice-box" style="height: 850px">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">

            <td class="title text" colspan="4">
                <img src="assets/img/logo_pdf.png" style="width: 200px;">
            </td>
            <td class="text">
                <strong>beDev</strong>, obrt za računalne djelatnosti<br/>
                vl. Josipa Bešlić, Trnjanska cesta 59, 10000 Zagreb<br/>
                OIB: 00460997027<br/>
                IBAN: HR4023400091160517112 <br/>

            </td>


        </tr>

        <tr class="information">

                        <td colspan="4" class="text">
                            <strong>PRIMEROS Qualification GmbH</strong>
                            <br>
                            Bahnhofstraße 25
                            <br>
                            74072 Heilbronn <br/>


                            Tel.: 07131 3903881 <br/>
                            Fax: 07131 3903882 <br/><br/>

                            Rückfragen zur Rechnung?<br/>
                            rechnungswesen@primeros.de


                        </td>

                        <td class="text">
                            <strong>Rechnungsempfänger:</strong><br/>
                            company  <br/>
                            person  <br/>
                            street  <br/>
                            city <br/>

                        </td>
        </tr>

        <tr>
            <td  style="padding-top: 13px" class="text" colspan="5">
                <strong><span style="color: #86c035;">Rechnung Nr. godina – invoice_number </span></strong><br>
                invoice_date
                <br>
            </td>
        </tr>

        <tr>
            <td colspan="5" class="text">
                description
            </td>
        </tr>

        <tr class="heading">
            <td>
                &nbsp;
            </td>
            <td>
                Menge
            </td>

            <td>
                Einzelpreis
            </td>
            <td>
                Mwst.
            </td>
            <td>
                Gesamtpreis
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
            <td colspan="5">USt: befreit nach §4 Nr. 21a, bb UStG
            </td>
        </tr>

        <tr class="total">
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Gesamtbetrag</strong>
            </td>
            <td>
                <strong>cijena </strong>
            </td>
        </tr>

        <tr class="footer">
            <td colspan="5" class="text">
                Herzlichen Dank für Ihren Auftrag. <br/>

                Bitte überweisen Sie den Rechnungsbetrag innerhalb der nächsten 10 Tage. <br/>
                    IBAN: DE23 6205 0000 0000 1233 89 <br/>
                    Subjekt: Rechnung Nr. godina  – invoice_number


            </td>
        </tr>





    </table>

        <p style="position:fixed; bottom:15px; left:75px; color: gray;  font-size: 10px; vertical-align:bottom;">
            Fidor Bank, München | IBAN: DE25 7002 2200 0020 1157 50 | BIC-/SWIFT-Code: FDDODEMMXXX
            <br/>
            Amtsgericht Jena, HRB 513149, UStID Nr.: DE263593825, Geschäftsführer: Christian Meier
        </p>
</div>
</body>
</html>