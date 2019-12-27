<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>offer</title>

    <style type="text/css">
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size:12px;
            color: gray;
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

<table cellpadding="0" cellspacing="0">
    <tr class="top">
        <td class="title text" style="width: 460px;" colspan="4">
            <img src="{{ asset('storage/'.$data['company']->logo_path) }}" style="width: 150px;">
        </td>
        <td class="text" colspan="3">
            <strong>{{ $data['company']->name }}</strong> <br/>
            @if($data['company']->type == 'FO') vl.{{ $data['company']->owner }},@endif {{ $data['company']->address }},<br/>
            {{ $data['company']->zip_code }} {{ $data['company']->city }}<br/>
            VAT/OIB: HR{{ $data['company']->oib }}<br/>
            IBAN: {{ $data['company']->iban }} <br/>

        </td>
    </tr>
</table>
<p style="border-top: 1px solid grey;"></p>

<div class="offer-box">

    <table>
        <tr class="information">

            <td colspan="2" style="width: 450px;">
                <strong>
                        <span style="color: #{{ $data['company']->color }};">
                            PONUDA br. – {{ $data['offer_number'] }}/1/1 <br/>
                            (offer #)
                        </span>

                </strong>
            </td>



            <td>
                <strong>{{ $data['client']->name }}</strong><br/>
                {{ $data['client']->address }}  <br/>
                {{ $data['client']->zip_code }} {{ $data['client']->city }}  <br/>
                VAT/OIB: {{ $data['client']->oib }}  <br/>
            </td>
        </tr>

        <tr class="date_place">
            <td>
                Mjesto, datum i vrijeme izdavanja: <br/>
                (Place, date and time)
            </td>
            <td colspan="2">
                {{ $data['place'] }}, {{ $data['offer_date'] }} u {{ $data['offer_time'] }}
            </td>
        </tr>
    </table>

    <table>
        <tr class="heading">
            <td>
                #
            </td>
            <td width="30%">
                Trgovački naziv dobra - usluge <br/>
                (Description)
            </td>
            <td>
                JM <br/>
                (UM)
            </td>
            <td>
                Količina<br/>
                (Quantity)
            </td>
            <td>
                Cijena<br/>
                (Price)
            </td>
            <td>
                Rabat<br/>
                (Discount)
            </td>
            <td>
                Iznos<br/>
                (Total)
            </td>
        </tr>



        @foreach($data['items'] as $key => $item)

            <tr class="item @if($loop->last) last @endif">
                <td>
                    {{ $key+1 }}
                </td>
                <td width="30%">
                    {{ $item['product']->description }} - <br>
                    {!! $item['description'] !!}
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
                    {{ $item['discount'] }}%
                </td>
                <td style="text-align: right;">
                    {{ number_format($item['price'], 2, ',', '.') }}
                </td>
            </tr>

        @endforeach


        <tr class="total">
            <td colspan="3">

            </td>
            <td colspan="2">
                UKUPNI IZNOS<br/>
                (TOTAL)
            </td>
            <td colspan="2" style="text-align: right;">{{ number_format($data['total_price'], 2, ',', '.') }} {{ $data['currency'] }}</td>
        </tr>
    </table>

    <table class="info">
        @if($data['currency'] == 'EUR')
            <tr>
                <td>Tecaj HNB:</td>
                <td>
                    {{ $data['hnb_middle_exchange'] }}
                </td>
            </tr>
            <tr>
                <td>Ukupno:</td>
                <td>
                    {{ number_format($data['total_price_HRK'], 2, ',', '.') }} HRK
                </td>
            </tr>
        @endif
        <tr>
            <td>Napomena:</td>
            <td>
                {{ $data['remark']->output }}
            </td>
        </tr>
        <tr>
            <td>Ponudu ispostavio:</td>
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
                {{ $data['offer_number'] }}-{{ $data['year'] }}
            </td>
        </tr>
        <tr>
            <td class="barcode" colspan="2">
                @if($data['currency'] != 'EUR')
                    <img style="width: 58mm; height: 26mm" src="data:image/png;base64,'{{ $data['barcode'] }}">
                @endif
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