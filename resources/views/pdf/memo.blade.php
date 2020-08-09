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

                </td>
                <td>
                    <strong>{{ $data['client']->name }}</strong><br/>
                    {{ $data['client']->address }}  <br/>
                    {{ $data['client']->zip_code }} {{ $data['client']->city }}  <br/>
                    OIB: {{ $data['client']->oib }}  <br/>
                </td>
            </tr>


        </table>

        <div>
            {!! $data['content'] !!}
        </div>


    </div>
    <p style="position:fixed; bottom:15px; color: gray;  font-size: 10px; vertical-align:bottom; border-top: 1px solid grey; text-align: center;">
        {{ $data['company']->name }}, @if($data['company']->type == 'FO') vl.{{ $data['company']->owner }},@endif {{ $data['company']->address }}, {{ $data['company']->zip_code }} {{ $data['company']->city }},OIB {{ $data['company']->oib }} <br />
        Račun IBAN {{ $data['company']->iban }} otvoren u {{ $data['company']->bank_info }}
    </p>

</body>
</html>