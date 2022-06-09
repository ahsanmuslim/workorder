<?php

require_once 'D:\xampp\htdocs\myportpolio\workorder\app\core\Mailer.php';
require_once 'D:\xampp\htdocs\myportpolio\workorder\app\core\Database.php';
require_once 'D:\xampp\htdocs\myportpolio\workorder\app\core\Controller.php';
require_once 'D:\xampp\htdocs\myportpolio\workorder\app\core\BotTelegram.php';
require_once 'D:\xampp\htdocs\myportpolio\workorder\app\core\WorkingDay.php';
require_once 'D:\xampp\htdocs\myportpolio\workorder\public\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new Database();
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

//generate token
$token = bin2hex(random_bytes(20));

//mengambil data outstanding WO dari database
$query = "SELECT work_order.tanggal, work_order.target_selesai, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, user.nama_user, user.email, user.id_telegram FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON work_order.create_by=user.id_user WHERE work_order.status = 'Open' ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($query);
$pesan = $db->resultSet();


//data WO yang belum approve div head
$div = "SELECT work_order.tanggal, work_order.id_wo, work_order.approve_div, work_order.department, department.nama_dept, work_order.nama_wo, work_order.status FROM work_order JOIN department ON work_order.department=department.id_dept WHERE work_order.status = 'Open' AND approve_div IS NULL ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($div);
$data_div = $db->resultSet();

//data WO yang belum approve dept head
$querydept = "SELECT work_order.tanggal, work_order.id_wo, work_order.approve_dept, work_order.department, department.nama_dept, work_order.nama_wo, work_order.status, user.nama_user, user.email, user.id_telegram FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON department.id_dept=user.id_dept WHERE work_order.status = 'Open' AND approve_dept IS NULL AND role = 3 ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($querydept);
$data_dept = $db->resultSet();

//data WO yang belum diverfikasi
$mtc = "SELECT work_order.tanggal, work_order.id_wo, work_order.verified, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.prioritas, work_order.status, user.nama_user, user.email, user.id_telegram FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON work_order.create_by=user.id_user WHERE work_order.status = 'Open' AND verified IS NULL ORDER BY  work_order.status ASC, prioritas DESC, tanggal DESC";
$db->query($mtc);
$data_mtc = $db->resultSet();


// var_dump($pesan);


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
$sheet->getStyle('A3:I'.$row)->applyFromArray($styleTable);
$sheet->getStyle('A3:I3')->applyFromArray($styleHeader);
$sheet->getStyle('A1')->applyFromArray($styleFont);

$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);

$sheet->getColumnDimension('A')->setWidth(6);

$sheet->setShowGridlines(false);


$writer = new Xlsx($spreadsheet);
$writer->save('../public/file/email/Outstanding WO.xlsx');

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
// $mail = unique_data($email,'email');


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

//alamat email division Head
$maildiv = [
    'email' => 'ahsancoding@gmail.com',
	'user' => 'Ahsan'
];

// alamat email maintenance
$mailmtc = [
    'email' => 'kikielbe@gmail.com',
	'user' => 'Admin MTC'
];


//email dummy 
$mail = [
	[
		'email' => 'kikielbe@argapura.com',
		'user' => 'susanto'
	],
	[
		'email' => 'ahmadsusanto912@gmail.com',
		'user' => 'ahsan'
	]
];

// var_dump($data_mtc);


// Mailer::sendEmail($mail, $token, 'Daily Notification', $pesan);

// if(!empty($data_dept){
// Mailer::sendEmail($maildept, $token, 'Reminder Approve  Dept Head', $data_dept);
// }

// if(!empty($data_div)){
//     Mailer::sendEmail($maildiv, $token, 'Reminder Approve  Div Head', $data_div);
// }

// if(!empty($data_mtc)){
//     Mailer::sendEmail($mailmtc, $token, 'Reminder Verifikasi Work Order', $data_mtc);
// }




