<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<style>
    h5.title {
        text-align: left;
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

    .letter-top-block-table {
        width: 100%;
        margin-bottom: 20px;
        font-size: 10.5pt;
    }

    .receiver-address {
        width: 70%;
        vertical-align: top;
    }

    .ref-date {
        width: 30%;
        text-align: right;
        vertical-align: top;
    }
</style>

<div class="content-wrapper">
    <table class="letter-top-block-table">
        <tr>
            <td class="receiver-address">
                <strong><?= h($application->student->name ?? 'Student Name') ?></strong><br>
                Universiti Teknologi MARA (UiTM)<br>
                40450 Shah Alam<br>
                Selangor Darul Ehsan, Malaysia
            </td>
            <td class="ref-date">
                Our Ref: <?= h($application->id) ?><br>
                Date: <?= date('j F Y') ?>
            </td>
        </tr>
    </table>

    <h5 class="title">Acknowledgement and Resolution of Your Internship Application <?= date('Y') ?></h5>

    <div class="letter-body">
        <p>We acknowledge receipt of your internship application dated <strong><?= h($application->application_date) ?></strong> at <strong><?= h($application->company->name ?? 'Company Name') ?></strong>.</p>

        <p>Application Details:</p>
        <ol style="padding-left: 18px; margin: 5px 0;">
            <li>Reference ID: <strong><?= h($application->id) ?></strong></li>
            <li>Status:
                <strong>
                    <?php
                        echo match ($application->status) {
                            1 => 'Ongoing',
                            2 => 'Completed',
                            default => 'Pending',
                        };
                    ?>
                </strong>
            </li>
            <li>Student: <strong><?= h($application->student->name ?? 'N/A') ?></strong></li>
            <li>Program: <strong><?= h($application->student->program ?? 'N/A') ?></strong></li>
            <li>Company: <strong><?= h($application->company->name ?? 'N/A') ?></strong></li>
            <li>Duration: <strong><?= h($application->start_date) ?> to <?= h($application->end_date) ?></strong></li>
        </ol>

        <p>We appreciate your cooperation. If you have any questions, feel free to contact the internship office.</p>

        <p>Thank you.</p>

        <div class="signature">
            <p>Warm regards,<br><br>
            <strong>Dr Husain Hashim</strong><br>
            Internship Program Coordinator<br>
            UiTMFSMp@gmail.com<br>
            +60 301722456</p>
        </div>
    </div>
</div>
