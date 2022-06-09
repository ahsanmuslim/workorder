<?php

require_once '/home/workorder/public_html/app/core/Mailer.php';
require_once '/home/workorder/public_html/app/core/Database.php';
require_once '/home/workorder/public_html/app/core/Controller.php';
require_once '/home/workorder/public_html/app/core/BotTelegram.php';
require_once '/home/workorder/public_html/app/core/WorkingDay.php';
require_once '/home/workorder/public_html/public/vendor/autoload.php';

// require_once 'C:\xampp\htdocs\myapps\project-monitoring\app\core\Mailer.php';
// require_once 'C:\xampp\htdocs\myapps\project-monitoring\app\core\Database.php';
// require_once 'C:\xampp\htdocs\myapps\project-monitoring\app\core\Controller.php';
// require_once 'C:\xampp\htdocs\myapps\project-monitoring\app\core\BotTelegram.php';
// require_once 'C:\xampp\htdocs\myapps\project-monitoring\app\core\WorkingDay.php';
// require_once 'C:\xampp\htdocs\myapps\project-monitoring\public\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new Database();
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

//generate token
$token = bin2hex(random_bytes(20));

//mengambil data outstanding WO dari database
$query = "SELECT work_order.tanggal, work_order.target_selesai, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, user.nama_user, user.email, user.id_telegram FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON work_order.create_by=user.id_user WHERE work_order.status = 'Open' ORDER BY  work_order.department ASC, tanggal DESC";
$db->query($query);
$pesan = $db->resultSet();


//data WO yang belum approve div head
$div = "SELECT work_order.tanggal, work_order.id_wo, work_order.approve_div, work_order.department, department.nama_dept, work_order.nama_wo, work_order.status FROM work_order JOIN department ON work_order.department=department.id_dept WHERE work_order.status = 'Open' AND approve_div IS NULL AND approve_hr IS NOT NULL ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($div);
$data_div = $db->resultSet();


//data WO yang belum diverfikasi
$mtc = "SELECT work_order.tanggal, work_order.id_wo, work_order.verified, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.prioritas, work_order.status, user.nama_user, user.email, user.id_telegram FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON work_order.create_by=user.id_user WHERE work_order.status = 'Open' AND verified IS NULL AND approve_dept IS NOT NULL ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($mtc);
$data_mtc = $db->resultSet();

//data WO yang belum approve dept head
$querydept = "SELECT work_order.tanggal, work_order.id_wo, work_order.approve_dept, work_order.department, department.nama_dept, work_order.nama_wo, work_order.status, user.nama_user, user.email, user.id_telegram FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON department.id_dept=user.id_dept WHERE work_order.status = 'Open' AND approve_dept IS NULL AND (role = 3 OR role=7) ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($querydept);
$data_dept = $db->resultSet();

//mengambil data handover WO
$queryhandover = "SELECT id_wo, nama_wo, status, tgl_penyerahan, id, progress, nama_user, email, dept, nama_dept FROM (SELECT a.nama_wo, a.id_wo, a.status, a.department AS dept, c.nama_user, c.email, d.tgl_penyerahan, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo JOIN user c ON a.create_by=c.id_user JOIN serah_terima d ON d.id_wo=a.id_wo GROUP BY id_wo) AS wo JOIN progress on id=id_progress JOIN department on department.id_dept=dept WHERE id=8 AND status ='Open' ORDER BY nama_dept, nama_wo";
$db->query($queryhandover);
$datahandover = $db->resultSet();

//membuat file report harian
$sheet->setCellValue('A1', 'Data Outstanding Work Order');

$sheet->setCellValue('A3', 'No');
$sheet->setCellValue('B3', 'No Work Order');
$sheet->setCellValue('C3', 'Nama Work Order');
$sheet->setCellValue('D3', 'Department');
$sheet->setCellValue('E3', 'Tanggal');
$sheet->setCellValue('F3', 'Target');
$sheet->setCellValue('G3', 'Status');
$sheet->setCellValue('H3', 'Progress');
$sheet->setCellValue('I3', 'PIC');
$sheet->setCellValue('J3', 'Durasi');

$row = 4;
$no = 1;
foreach ( $pesan as $psn ):
	//mengambil data progress
	$id_wo = $psn['id_wo'];
	$query2 = "SELECT work_order.id_wo, detail_progress.id_progress, progress FROM work_order
	join detail_progress on work_order.id_wo=detail_progress.id_wo 
	join progress on detail_progress.id_progress=progress.id_progress 
	WHERE work_order.id_wo =:id_wo AND detail_progress.id_progress IN 
	(SELECT max(detail_progress.id_progress) FROM detail_progress  WHERE detail_progress.id_wo=:id_wo)";
	$db->query($query2);
	$db->bind ( 'id_wo', $id_wo );
	$prog = $db->single();

	//query untuk menghitung durasi
	$startDate = $psn['tanggal'];
	$endDate = date('Y-m-d');

	$hl = "SELECT tanggal FROM holidays WHERE tanggal >= '$startDate' AND tanggal <= '$endDate'";
	$db->query($hl);
	$data['libur'] = $db->resultSet();
	$holidays = [];

	foreach ($data['libur'] as $libur) :
		$holidays[] = $libur['tanggal'];
	endforeach;

	$durasi = WorkingDay::getWorkingDays($startDate, $endDate, $holidays);

	// var_dump($prog);

	$sheet->setCellValue('A'.$row, $no++);
	$sheet->setCellValue('B'.$row, $psn['id_wo']);
	$sheet->setCellValue('C'.$row, $psn['nama_wo']);
	$sheet->setCellValue('D'.$row, $psn['nama_dept']);	
    $sheet->setCellValue('E'.$row, date('d M y', strtotime($psn['tanggal'])));
    $sheet->setCellValue('F'.$row, date('d M y', strtotime($psn['target_selesai'])));
    $sheet->setCellValue('G'.$row, $psn['status']);
	$sheet->setCellValue('H'.$row, $prog['progress']);
	$sheet->setCellValue('I'.$row, $psn['nama_user']);
	$sheet->setCellValue('J'.$row, $durasi.' hari kerja');
    $row++;
endforeach;

$styleFont = [
                'font' => [
                    'bold' => true,
                    'size' => '16',
                ],
            ];

$styleHeader = [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFA0A0A0',
                    ],    
                ],
            ];

$styleTable = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];


$row = $row - 1;
$sheet->getStyle('A3:J'.$row)->applyFromArray($styleTable);
$sheet->getStyle('A3:J3')->applyFromArray($styleHeader);
$sheet->getStyle('A1')->applyFromArray($styleFont);

$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);

$sheet->getColumnDimension('A')->setWidth(6);

$sheet->setShowGridlines(false);


$writer = new Xlsx($spreadsheet);
//$writer->save('../public/file/email/Outstanding WO.xlsx');
$writer->save('/home/workorder/public_html/public/file/email/Outstanding WO.xlsx');
// $writer->save('C:\xampp\htdocs\myapps\project-monitoring\public\file\email\Outstanding WO.xlsx');


//funsgsi untuk mengambil data unik di array
function unique_data($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}



//mengambil alamat email untuk notifikasi harian WO open
$email = [];
foreach ($pesan as $psn):
	$new = [
		'email' => $psn['email'],
		'user' => $psn['nama_user']
	];
	array_push($email, $new);
endforeach;
$mail = unique_data($email,'email');


//mengambil alamat email Dept Head
$emaildept = [];
foreach ($data_dept as $dept):
	$new2 = [
		'email' => $dept['email'],
		'user' => $dept['nama_user']
	];
	array_push($emaildept, $new2);
endforeach;
$maildept = unique_data($emaildept,'email');

//mengambil alamat email untuk notif Handover
$emailhandover = [];
foreach ($datahandover as $hand):
	$new3 = [
		'email' => $hand['email'],
		'user' => $hand['nama_user']
	];
	array_push($emailhandover, $new3);
endforeach;
$mailhandover = unique_data($emailhandover,'email');

//alamat email division Head
$maildiv = [
	[
		'email' => 'adith.jayanegara@argapura.com',
		'user' => 'Adithia V. Jayanegara'
	]
];

// alamat email maintenance
$mailmtc = [
	[
		'email' => 'maintenance@argapura.com',
		'user' => 'Admin MTC'
	]
];

//email dummy 
$maildummy = [
	[
		'email' => 'susanto@argapura.com',
		'user' => 'susanto'
	]
];

// var_dump($maildiv);
// var_dump($data_div);

Mailer::sendEmail($mail, $token, 'Daily Notification', $pesan);

if(!empty($data_dept)){
	Mailer::sendEmail($maildept, $token, 'Reminder Approve  Dept Head', $data_dept);
}

if(!empty($datahandover)){
	Mailer::sendEmail($mailhandover, $token, 'Reminder Handover Work Order', $datahandover);
}

if(!empty($data_div)){
    Mailer::sendEmail($maildiv, $token, 'Reminder Approve Work Order', $data_div);
}

if(!empty($data_mtc)){
    Mailer::sendEmail($mailmtc, $token, 'Reminder Verifikasi Work Order', $data_mtc);
}
