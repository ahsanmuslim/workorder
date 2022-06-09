<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Work Order - Print Session</title>
    <link rel="icon" type="image/png" href="<?= BASEURL; ?>/img/icon.png">
    
    <style>

    body {
      background: white; 
    }
    page[size="A4"] {
      background: white;
      width: 21cm;
      height: 30cm;
      display: block;
      margin: 0 auto;
    }
    @media print {
      body, page[size="A4"] {
        margin: 0;
        box-shadow: 0;
      }
    }

    .wo-box table td.header2 {
        background-color: #3B3B3B;
        color: white;
        font-weight: bold;
        text-align: center;
        width: 30%;
    }

    .wo-box table td.header1 {
        background-color: #e4e7eb;
        color: black;
        font-weight: bold;
        text-align: center;
        width: 60%;
    }

    .image {
        text-align: center;
        padding: 0.2rem;
    }

    table#judul tr, table#judul td {
        border: 1px solid black;
    }

    table#general th, table#general td {
        border: 1px solid black;
        text-align: left;
        padding: 0.3rem;
    }

    table#material th, table#material td {
        border: 1px solid black;
        text-align: center;
        padding: 0.3rem;
        height: 1rem;
    }

    table#drawing th, table#drawing td {
        border: 1px solid black;
        text-align: center;
        padding: 0.3rem;
        height: 1rem;
    }

    table#sign th, table#sign td {
        border: 1px solid black;
        text-align: center;
    }

    table#nodokumen tr, table#nodokumen td {
        border: 1px solid black;
        text-align: center;
        font-size: 14px;
        padding: 0.3rem;
    }
    th {
        background-color: #e4e7eb;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 10px;
    }

    table#general tr {
        height: 1rem;
        border: 1px solid black;
    }

    table#sign tr#rowsign {
        height: 45px;
    }

    table#sign tr#namapic {
        border: 1px solid black;
        text-align: center;
        font-size: 14px;
        padding: 0.3rem;

    }



    </style>
</head>

<body>
<page size="A4">
    <div class="wo-box">
        <table id="judul" cellpadding="0" cellspacing="0">
            <tr>
                <td class="image" rowspan="3" width="50px">
                    <img src="<?= BASEURL; ?>/img/agp.png" style="width:100%; max-width:50px;">
                </td>                
                <td class="header1">
                    <?= $data['detailWO']['nama_wo']; ?>
                </td>
                <td class="header2">
                    FORM WORK ORDER 
                </td>
            </tr>

        </table>
        <table id="general">
            <tr>
                <th width="20%">Tanggal WO</th>
                <td width="30%"><?= date('d M y',strtotime($data['detailWO']['tanggal'])) ?></td>
                <th width="20%">Kategori</th>
                <td width="30%"><?= $data['detailWO']['nama_kategori']; ?></td>
            </tr>
            <tr>
                <th>No WO</th>
                <td><?= $data['detailWO']['id_wo']; ?></td>
                <th>Priority</th>
                <td><?php if ( $data['detailWO']['prioritas'] == 1 ) { echo 'Urgent'; } else { echo 'Normal'; } ?></td>
            </tr>
            <tr>
                <th>Department</th>
                <td><?= $data['detailWO']['nama_dept']; ?></td>
                <th>PIC</th>
                <td><?= $data['detailWO']['nama_user']; ?></td>
            </tr>
            <tr>
                <th>Penggunaan</th>
                <td><?= date('d M y',strtotime($data['detailWO']['target_selesai'])) ?></td>
                <th>Teknisi</th>
                <td><?= $data['detailWO']['nama_teknisi']; ?></td>
            </tr>
            <tr id="deskripsi">
                <th>Deskripsi</th>
                <td colspan="3"><?= $data['detailWO']['deskripsi']; ?></td>
            </tr>
        </table>
        <table id="drawing">
            <tr>
                <td class="header2">Rincian Pekerjaan ( Gambar / Drawing / Sketch / Ilustrasi )</td>
            </tr>
            <tr  height="300px">
                <td class="image"><img src="<?= BASEURL; ?>/img/drawing/<?= $data['detailWO']['drawing']; ?>" style="width:100%; max-width:400px; max-height: 350px"></td>
            </tr>
        </table>
        <table id="material">
            <tr>
                <td colspan="7" class="header2">Rincian Raw Material & Estimasi Biaya</td>
            </tr>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Material</th>
                <th width="5">Qty.</th>
                <th width="10%">Satuan</th>
                <th width="15%">Harga</th>
                <th width="15%">Total Biaya</th>
                <th width="20%">Keterangan</th>
            </tr>
            <?php 
            $no = 1;
            foreach ( $data['detailMaterial'] as $rm ): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td style="text-align: left;"><?= $rm['nama_material'] ?></td>
                <td><?= $rm['qty_plan'] ?></td>
                <td><?= $rm['satuan'] ?></td>
                <td>Rp <?= number_format($rm['harga_rm']) ?></td>
                <td>Rp <?= number_format($rm['harga_rm'] * $rm['qty_plan']) ?></td>
                <td><?= $rm['keterangan'] ?></td>
            </tr>
            <?php endforeach; ?>
            <?php 
            $row = count($data['detailMaterial']);
            for ($i=$row+1 ; $i<=10 ; $i++) { 
            ?>
            <tr>
                <td></td>
                <td style="text-align: left;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>   
            <?php } ?>
            <tr>
                <th colspan="5">Total Biaya</th>
                <th>Rp <?= number_format($data['detailWO']['plan_biaya']) ?></th>
                <th></th>
            </tr>
        </table>
        <table id="sign">
            <tr>
                <th width="20%">Dibuat</th>
                <th width="20%">Diketahui</th>
                <th width="20%">Diverifikasi</th>
                <th width="20%">Diperiksa</th>
                <th width="20%">Disetujui</th>
            </tr>
            <tr id="rowsign">
                <td class="image"><img src="<?= BASEURL; ?>/img/signed.jpg" style="width:80%; max-width:80px;"></td>
                <?php if(is_null($data['detailWO']['approve_dept'])){ ?>
                    <td></td>
                <?php } else { ?>
                    <td class="image"><img src="<?= BASEURL; ?>/img/signed.jpg" style="width:80%; max-width:80px;"></td>
                <?php } ?>

                <?php if(is_null($data['detailWO']['verified'])){ ?>
                    <td></td>
                <?php } else { ?>
                    <td class="image"><img src="<?= BASEURL; ?>/img/signed.jpg" style="width:80%; max-width:80px;"></td>
                <?php } ?>

                <?php if(is_null($data['detailWO']['approve_hr'])){ ?>
                    <td></td>
                <?php } else { ?>
                    <td class="image"><img src="<?= BASEURL; ?>/img/signed.jpg" style="width:80%; max-width:80px;"></td>
                <?php } ?>

                <?php if(is_null($data['detailWO']['approve_div'])){ ?>
                    <td></td>
                <?php } else { ?>
                    <td class="image"><img src="<?= BASEURL; ?>/img/signed.jpg" style="width:80%; max-width:80px;"></td>
                <?php } ?>

            </tr>
            <tr id="namapic">
                <th><?= $data['detailWO']['nama_user']; ?></th>
                <th>Dept Head</th>
                <th>Admin MTC</th>
                <th>HR Dept Head</th>
                <th>Division Head</th>
            </tr>
        </table>
        <table id="nodokumen">
            <tr>
                <td width="30%">No. Form : FRM-HM-02-01</td>
                <td width="30%">Tanggal : 24 Januari 2014</td>
                <td width="20%">Revisi : 00</td>
                <td width="20%">Halaman : 1  dari 1</td>
            </tr>
        </table>
    </div>
</page>
</body>
<script type="text/javascript">
    window.print();
</script>
</html>
