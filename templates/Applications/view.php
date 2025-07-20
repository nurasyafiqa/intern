<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Internship Application Letter</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background-color: #fff !important;
            color: #000 !important;
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .letter-container {
            width: 793.7px;
            margin: 1in auto;
            padding: 0;
            background-color: #fff !important;
            color: #000 !important;
        }

        .letter-header-image {
            text-align: center;
            margin-bottom: 10px;
        }

        .letter-header-image img,
        .letter-footer-image img {
            width: 100%;
            object-fit: contain;
        }

        .letter-footer-image img {
            max-height: 80px;
            margin-top: 40px;
        }

        .letter-metadata table {
            width: 100%;
            border-collapse: collapse;
        }

        .letter-metadata td {
            padding: 3px 8px;
            vertical-align: top;
            font-size: 12pt;
        }

        .address p {
            margin: 0;
            margin-bottom: 0.8em;
            font-size: 12pt;
        }

        .letter-body {
            margin-top: 20px;
        }

        .letter-body p {
            margin: 0;
            margin-bottom: 1em;
        }

        .letter-footer-text {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
            color: #555 !important;
        }

        .capital {
            text-transform: uppercase;
            font-weight: bold;
        }

        .signature {
            margin-top: 40px;
            font-style: italic;
            font-size: 12pt;
        }

        .letter-top-block {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .address {
            width: 60%;
        }

        .letter-metadata {
            width: 35%;
        }

        h5.capital {
            margin-bottom: 20px;
        }

        /* PDF Button Styling */
        .pdf-button-container {
            text-align: right;
            margin: 40px auto;
            width: 793.7px;
        }

        .pdf-button-container a {
            background-color: #ffc107;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .pdf-button-container a:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

<div class="letter-container">

    <!-- Header Image -->
    <div class="letter-header-image">
        <img src="<?= $this->Url->image('header/top.png') ?>" alt="Top Header">
    </div>

    <!-- Address + Metadata -->
    <div class="letter-top-block">
        <div class="address">
            <p><strong><?= h($application->student->name ?? 'Student Name') ?></strong></p>
            <p>
                Universiti Teknologi MARA (UiTM),<br>
                40450 Shah Alam,<br>
                Selangor Darul Ehsan,<br>
                Selangor
            </p>
        </div>

        <div class="letter-metadata">
            <table>
                <tr>
                    <td><strong>Letter</strong></td>
                    <td>:</td>
                    <td><?= h($application->id) ?></td>
                </tr>
                <tr>
                    <td><strong>Date</strong></td>
                    <td>:</td>
                    <td><?= date('d F Y', strtotime($application->created)) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Letter Title -->
    <h5 class="capital">Acknowledgement and Resolution of Your Internship Application <?= date('Y') ?></h5>

    <!-- Body Content -->
    <div class="letter-body">
        <p>
            We acknowledge receipt of your internship application dated 
            <strong><?= h(date('n/j/y', strtotime($application->application_date))) ?></strong>,
            regarding your internship at 
            <strong><?= h($application->company->name ?? 'PROTON') ?></strong>
            in the field of <strong><?= h($application->internship_field ?? '[Insert Field]') ?></strong>.
        </p>

        <p>After reviewing your submission, the following details are noted:</p>

        <p>1. Application Reference ID: <strong><?= h($application->id) ?></strong></p>
        <p>2. Student Name: <strong><?= h($application->student->name ?? 'N/A') ?></strong></p>
        <p>3. Program: <strong><?= h($application->student->program ?? 'N/A') ?></strong></p>
        <p>4. Company Name: <strong><?= h($application->company->name ?? 'N/A') ?></strong></p>
        <p>5. Application Status: 
            <strong>
                <?php
                    switch ($application->status) {
                        case 1: echo 'Ongoing'; break;
                        case 2: echo 'Completed'; break;
                        default: echo 'Pending';
                    }
                ?>
            </strong>
        </p>
        <p>6. Internship Duration: 
            <strong><?= h($application->start_date) ?> to <?= h($application->end_date) ?></strong>
        </p>

        <p>
            We appreciate your patience and cooperation. If the status is unsatisfactory or if you have further questions, 
            kindly reach out to the internship office.
        </p>

        <p>Thank you for your application.</p>
    </div>

    <!-- Signature Block -->
    <div class="signature">
        <p>Warm regards,<br><br>
        <strong>Dr Husain Hashim</strong><br>
        Internship Program Coordinator<br>
        UiTMFSM@gmail.com<br>
        +60 301722456</p>
    </div>

    <!-- Note -->
    <div class="letter-footer-text">
        <i>This letter is generated by a computer. No signature is required.</i>
    </div>

    <!-- Footer Image -->
    <div class="letter-footer-image">
        <img src="<?= $this->Url->image('header/bottom.png') ?>" alt="Bottom Footer">
    </div>
</div>

<!-- PDF Download Button -->
<div class="pdf-button-container">
    <?= $this->Html->link(
        '📄 Download Letter as PDF',
        ['action' => 'pdfLetter', $application->id],
        ['target' => '_blank']
    ) ?>
</div>

</body>
</html>
