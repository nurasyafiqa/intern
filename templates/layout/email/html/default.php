<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $this->fetch('title') ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
        }

        .letter-header-image img,
        .letter-footer-image img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .letter-top-block {
            display: flex;
            justify-content: space-between;
            margin: 10px 0 15px 0;
        }

        .address {
            width: 60%;
        }

        .letter-metadata {
            width: 38%;
            font-size: 10pt;
        }

        .letter-body p {
            margin: 0 0 0.6em 0;
            font-size: 10.5pt;
        }

        .signature {
            margin-top: 20px;
            font-size: 10pt;
        }

        .letter-footer-text {
            text-align: center;
            font-size: 9pt;
            color: #555;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>
