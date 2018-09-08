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
                <img src="{{ asset('storage/'.$data['company']->logo_path) }}" style="width: 150px;">
            </td>
            <td class="text" colspan="3">
                <strong>{{ $data['company']->name }}</strong> <br/>
                @if($data['company']->type == 'FO') vl.{{ $data['company']->owner }},@endif {{ $data['company']->address }},<br/>
                {{ $data['company']->zip_code }} {{ $data['company']->city }}<br/>
                OIB: {{ $data['company']->oib }}<br/>
                IBAN: {{ $data['company']->iban }} <br/>

            </td>
        </tr>
    </table>
    <p style="border-top: 1px solid grey;"></p>

    <div class="invoice-box">

        <table>
            <tr class="information">

                <td colspan="2" style="width: 450px;">
                    <strong><span style="color: #{{ $data['company']->color }};">RAČUN br. – {{ $data['invoice_number'] }}/1/1 </span></strong>
                </td>



                <td>
                    <strong>{{ $data['client']->name }}</strong><br/>
                    {{ $data['client']->address }}  <br/>
                    {{ $data['client']->zip_code }} {{ $data['client']->city }}  <br/>
                    OIB: {{ $data['client']->oib }}  <br/>
                </td>
            </tr>

            <tr class="date_place">
                <td>
                    Mjesto, datum i vrijeme izdavanja:
                </td>
                <td colspan="2">
                    {{ $data['place'] }}, {{ $data['invoice_date'] }} u {{ $data['invoice_time'] }}
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



            @foreach($data['items'] as $key => $item)

            <tr class="item @if($loop->last) last @endif">
                <td>
                    {{ $key+1 }}
                </td>
                <td width="30%">
                    {{ $item['product']->description }}
                </td>
                <td>
                    {{ $item['unit']->name }}
                </td>
                <td>
                    {{ $item['amount'] }}
                </td>
                <td>
                    {{ number_format($item['price_per_unit'], 2, ',', '.') }}
                </td>
                <td>
                    0%
                </td>
                <td style="text-align: right;">
                    {{ number_format($item['price'], 2, ',', '.') }}
                </td>
            </tr>

            @endforeach


            <tr class="total">
                <td colspan="4">

                </td>
                <td colspan="2">
                    UKUPNI IZNOS
                </td>
                <td style="text-align: right;">{{ number_format($data['total_price'], 2, ',', '.') }} kn</td>
            </tr>
        </table>

        <table class="info">
            <tr>
                <td>Napomena:</td>
                <td>
                    {{ $data['remark']->output }}
                </td>
            </tr>
            <tr>
                <td>Račun ispostavio:</td>
                <td>
                    {{ $data['company']->owner }}
                </td>
            </tr>
            <tr>
                <td>
                    Dospijeće plaćanja:
                </td>
                <td>
                    {{ $data['payment_deadline'] }}
                </td>
            </tr>
            <tr>
                <td>Način plaćanja:</td>
                <td>
                    {{ $data['payment_type'] }}
                </td>
            </tr>
            <tr>
                <td>Poziv na broj:</td>
                <td>
                    {{ $data['invoice_number'] }}-2018
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
        {{ $data['company']->name }}, @if($data['company']->type == 'FO') vl.{{ $data['company']->owner }},@endif {{ $data['company']->address }}, {{ $data['company']->zip_code }} {{ $data['company']->city }},OIB {{ $data['company']->oib }} <br />
        Žiro račun IBAN {{ $data['company']->iban }} otvoren u {{ $data['company']->bank_info }}
    </p>

</body>
</html>