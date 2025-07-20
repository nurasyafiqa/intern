<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $this->fetch('title') ?></title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
        }

        .letter-header img,
        .letter-footer img {
            width: 100%;
            height: auto;
            display: block;
        }

        .content-wrapper {
            padding: 20mm 20mm 25mm 20mm;
        }

        .footer-text {
            text-align: center;
            font-size: 9pt;
            color: #555;
            margin-top: 5px;
        }

        .letter-top-block-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .letter-top-block-table td {
            vertical-align: top;
            font-size: 10.5pt;
            padding: 0;
        }

        .receiver-address {
            width: 60%;
        }

        .ref-date {
            width: 15%;
        }

        h5.title {
            text-align: center;
            margin: 10px 0 15px 0;
            text-transform: uppercase;
            font-size: 11pt;
        }

        .letter-body p {
            margin: 0 0 0.6em 0;
            font-size: 10.5pt;
        }

        .signature {
            margin-top: 20px;
            font-size: 10pt;
        }
    </style>
</head>
<body>

    <div class="letter-header">
        <?= $this->Html->image('header/top.png', ['fullBase' => true]) ?>
    </div>


        <div class="letter-body">
            <?= $this->fetch('content') ?>
        </div>
    </div>

    <div class="letter-footer">
        <?= $this->Html->image('header/bottom.png', ['fullBase' => true]) ?>
        <div class="footer-text">
            <i>This letter is system-generated. No signature is required.</i>
        </div>
    </div>

</body>
</html>
