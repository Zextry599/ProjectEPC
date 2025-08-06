<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .kartu-member {
            width: 370px;
            height: 210px;
            border: 1px solid #000;
            padding: 15px;
            position: relative;
            background: url('{{ public_path("img/bg-kartu.png") }}') no-repeat center center;
            background-size: cover;
        }

        .logo {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 50px;
        }

        .judul {
            text-align: center;
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .info {
            margin-top: 140px;
            font-size: 15px;
        }

        .info p {
            margin: 2px 0;
            /* <== ini yang menghilangkan spasi besar antar baris */
        }

        .barcode {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #fff;
            padding: 4px 5px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="kartu-member">
        <img class="logo" src="{{ public_path('img/logo.png') }}" alt="Logo">
        <div class="judul">KARTU MEMBER</div>
        <div class="info">
            <p>Nama: <strong>{{ $member->nama }}</strong></p>
            <p>No.ID: {{ $member->id }}</p>
        </div>
        <div class="barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($member->id, 'C39') }}" height="40" alt="barcode" />
        </div>
    </div>
</body>

</html>