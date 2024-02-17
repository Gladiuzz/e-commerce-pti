<!DOCTYPE html>
<html>

<head>
    <title>Pendaftaran Penjual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #333;
        }

        p {
            color: #666;
        }

        .list-item {
            margin-bottom: 10px;
        }

        .list-item span {
            font-weight: bold;
        }

        .steps {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .step-number {
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #333;
            color: #fff;
            font-size: 16px;
            line-height: 30px;
            text-align: center;
            margin-right: 10px;
        }

        .step-description {
            color: #666;
        }

        .cta-button {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Pendaftaran Penjual</h1>

        <div class="list-item">
            <h2>Persyaratan Pendaftaran:</h2>
            <p><span>KTP:</span> <i>Calon penjual dikhususkan untuk daerah pagaden saja maka diharapkan membawa salinan
                    KTP yang masih berlaku.</i></p>
            <p><span>Nama dan Alamat:</span> <i>Calon penjual diharapkan memberikan informasi lengkap mengenai nama dan
                    alamat tempat tinggal serta nomer telepon.</i></p>
            <p><span>Produk yang akan dijual:</span> <i>Calon penjual diharapkan menyampaikan informasi mengenai produk
                    yang akan dijual, termasuk deskripsi singkat dan kategori produk.</i></p>
        </div>

        <div class="steps">
            <h2>Pendaftaran Offline:</h2>
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-description"><i>Calon penjual diharapkan
                        untuk datang ke kantor BPP Pagaden pada jam
                        kerja.
                    </i></div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-description"><i>Mengisi formulir pendaftaran yang disediakan oleh petugas pendaftaran.
                    </i></div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-description">
                    <i>Menyerahkan salinan KTP dan informasi produk yang akan dijual kepada
                        petugas pendaftaran.</i>
                </div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-description"><i>Menyelesaikan proses pendaftaran dan mendapatkan konfirmasi
                        pendaftaran.</i>
                </div>
            </div>
        </div>

        <a href="/" class="cta-button">kembali</a>
    </div>
</body>

</html>
