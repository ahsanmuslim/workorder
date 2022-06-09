<?php

// Import PHPMailer classes into the global namespace, These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mailer {

    public static function sendEmail ($email, $token, $type, $pesan)
    {

        //require_once 'vendor/autoload.php';
        //require_once '\home\workorder\public_html\public\vendor\autoload.php';
	    require_once '/home/workorder/public_html/public/vendor/autoload.php';
    
        $mail = new PHPMailer(true);    

        try {
            //Server email settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp-relay.gmail.com';
            $mail->SMTPAuth   = false;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Penrima email
            $mail->setFrom('noreply@argapura.com', 'WO System (noreply)');
            // $mail->addAddress($email, $namauser);


            //mengirim ke beberapa alamat email
            foreach ($email as $m) {
                $mail->addAddress($m['email'], $m['user']);
            }

            //Address to which recipient will reply
            // $mail->addReplyTo("reply@yourdomain.com", "Reply");

            //CC and BCC
            // $mail->addCC("cc@example.com");
            // $mail->addBCC("bcc@example.com");

            // Provide file path and name of the attachments      
            // $mail->addAttachment("images/profile.png"); //Filename is optional

            // Isi email
            $mail->isHTML(true);
            $mail->Subject = $type;
            if ( $type == 'Aktivasi User' ){
                $mail->Body    = 'Silahkan klik link token di bawah untuk <b>AKTIVASI</b> user Anda !! <br><a href="'. BASEURL .'/auth/aktivasi/'. $email[0]['email'] .'/'. $token .'"><b>'.$token.'</b></a>';
            } elseif ( $type == 'Reset password' ) {
                $mail->Body    = 'Silahkan klik link token di bawah ini untuk <b>RESET</b> password Anda !! <br><a href="'. BASEURL .'/auth/resetPassword/'. $email[0]['email'] .'/'. $token .'"><b>'.$token.'</b></a>';
            } elseif ( $type == 'Daily Notification' ) {
                // $mail->Body    = 'Ini contoh notifikasi Email';
		
                $mail->addCC("adith.jayanegara@argapura.com");
                $mail->addCC("maria.goreti@argapura.com");                
                $mail->addCC("maintenance@argapura.com");
                $mail->addBCC("susanto@argapura.com");

                // $mail->addAttachment('../public/file/email/Outstanding WO.xlsx');  
                $mail->addAttachment('/home/workorder/public_html/public/file/email/Outstanding WO.xlsx');

                $mail->Body = '<html>
                Dear All,<br><br>
                Terlampir data outstanding work order yang masih dalam status Open.<br>
                Mohon untuk:<br><br>
                1. Tidak me-reply email ini, tetapi:<br>
                2. Follow up pada PIC terkait agar work order segera bisa diselesaikan.<br><br>
                Email ini akan otomatis dikirimkan tiap hari setiap jam 09:00.<br><br>
                Terima kasih atas kerjasama yang baik
                </html>';
            

            } elseif ( $type == 'Reminder Approve  Dept Head' ) {

                $mail->addCC("maria.goreti@argapura.com");                
                $mail->addCC("maintenance@argapura.com");
                $mail->addBCC("susanto@argapura.com");

                $body = '<html>
                Dear All Dept Head,<br><br>
                Mohon untuk approve Work Order yang telah diajukan agar bisa di tindak lanjuti ke proses berikutnya.<br>
                Berikut adalah daftar Work order yang belum di approve :<br>
                <table class="table" bordered="1">
                    <tr>
                        <th>No.</th>
                        <th>No WO</th>
                        <th>Work Order</th>
                        <th>Dept</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>';
                $no = 1;
                foreach ($pesan as $psn) {
                    $body .= '<tr>
                                <td>'. $no++ .'</td>
                                <td>'. $psn['id_wo'] .'</td>
                                <td>'. $psn['nama_wo'] .'</td>
                                <td>'. $psn['nama_dept'] .'</td>
                                <td>'. date('d M y', strtotime($psn['tanggal'])) .'</td>
                                <td>'. $psn['status'] .'</td>
                            </tr>';
                }

                $body .= '</table><br>
                Silahkan klik link di bawah untuk <b>APPROVE</b> Work Order yang sudah diajukan. <br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a><br><br>
                Silahkan kunjungi <a href="http://kb.argapura.local:3000/en/department/hrga/work-order#approve-work-order"><b>Portal Argapura</b></a> untuk melihat tutorial APPROVE work order.';

                $mail->Body = $body.'</html>';

            } elseif ( $type == 'Reminder Approve Work Order' ) {

                $mail->addCC("maria.goreti@argapura.com");
                $mail->addCC("maintenance@argapura.com");               
		        $mail->addBCC("susanto@argapura.com");

                $body = '<html>
                Dear pak Adithia,<br><br>
                Terdapat beberapa Work Order yang harus diperiksa & di setujui.<br>
                Berikut adalah daftar Work order yang belum di setujui :<br>
                <table class="table" bordered="1">
                            <tr>
                                <th>No.</th>
                                <th>No WO</th>
                                <th>Work Order</th>
                                <th>Dept</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>';
                $no = 1;
                foreach ($pesan as $psn) {
                    $body .= '<tr>
                                <td>'. $no++ .'</td>
                                <td>'. $psn['id_wo'] .'</td>
                                <td>'. $psn['nama_wo'] .'</td>
                                <td>'. $psn['nama_dept'] .'</td>
                                <td>'. date('d M y', strtotime($psn['tanggal'])) .'</td>
                                <td>'. $psn['status'] .'</td>
                            </tr>';
                }

                $body .= '</table><br>
                Silahkan klik link di bawah untuk <b>APPROVE</b> Work Order yang sudah diajukan. <br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a><br><br>
                Silahkan kunjungi <a href="http://kb.argapura.local:3000/en/department/hrga/work-order#approve-work-order"><b>Portal Argapura</b></a> untuk melihat tutorial APPROVE work order.';

                $mail->Body = $body.'</html>';

            } elseif ( $type == 'Reminder Verifikasi Work Order' ) {

                $mail->addCC("maria.goreti@argapura.com");
                $mail->addCC("maintenance@argapura.com");
		        $mail->addBCC("susanto@argapura.com");

                $body = '<html>
                Dear Admin MTC,<br><br>
                Mohon untuk verifikasi Work Order yang telah diajukan agar bisa di tindak lanjuti ke proses berikutnya.<br>
                Berikut adalah daftar Work order yang belum di verifikasi :<br>
                <table class="table" bordered="1">
                            <tr>
                                <th>No.</th>
                                <th>No WO</th>
                                <th>Work Order</th>
                                <th>Dept</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>';
                $no = 1;
                foreach ($pesan as $psn) {
                    $body .= '<tr>
                                <td>'. $no++ .'</td>
                                <td>'. $psn['id_wo'] .'</td>
                                <td>'. $psn['nama_wo'] .'</td>
                                <td>'. $psn['nama_dept'] .'</td>
                                <td>'. date('d M y', strtotime($psn['tanggal'])) .'</td>
                                <td>'. $psn['status'] .'</td>
                            </tr>';
                }

                $body .= '</table><br>
                Silahkan klik link di bawah untuk <b>VERIFIKASI</b> Work Order yang sudah diajukan ! <br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a><br><br>
                Silahkan kunjungi <a href="http://kb.argapura.local:3000/en/department/hrga/work-order#verifikasi-work-order"><b>Portal Argapura</b></a> untuk melihat tutorial VERIFIKASI work order.';

                $mail->Body = $body.'</html>';

            } elseif ( $type == 'Reminder Handover Work Order' ) {

                $mail->addCC("maria.goreti@argapura.com");                
                $mail->addCC("maintenance@argapura.com");
		        $mail->addBCC("susanto@argapura.com");

                $body = '<html>
                Dear All,<br><br>
                Work order yang diajukan telah selesai dikerjakan<br>
                Mohon untuk konfirmasi bahwa project telah diterima oleh user melalui aplikasi Work Order.<br>
                Berikut adalah daftar Work order yang masih dalam status Handover :<br>
                <table class="table" bordered="1">
                            <tr>
                                <th>No.</th>
                                <th>No WO</th>
                                <th>Work Order</th>
                                <th>Department</th>
                                <th>Nama PIC</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Tgl Penyerahan</th>
                            </tr>';
                $no = 1;
                foreach ($pesan as $psn) {
                    $body .= '<tr>
                                <td>'. $no++ .'</td>
                                <td>'. $psn['id_wo'] .'</td>
                                <td>'. $psn['nama_wo'] .'</td>
                                <td>'. $psn['nama_dept'] .'</td>
                                <td>'. $psn['nama_user'] .'</td>
                                <td>'. $psn['status'] .'</td>
                                <td>'. $psn['progress'] .'</td>
                                <td>'. date('d M y', strtotime($psn['tgl_penyerahan'])) .'</td>
                            </tr>';
                }

                $body .= '</table><br>
                Silahkan klik link di bawah untuk <b>HANDOVER</b> Work Order yang telah selesai dikerjakan. <br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a><br><br>
                Silahkan kunjungi <a href="http://kb.argapura.local:3000/en/department/hrga/work-order#user-melakukan-proses-edit-handover-setelah-admin-mtc-menyerahkan-work-order-dengan-cara"><b>Portal Argapura</b></a> untuk melihat tutorial HANDOVER work order.';

                $mail->Body = $body.'</html>';

            }



            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Email berhasil dikirim !!';
        } catch (Exception $e) {
            echo "Email tidak terkirim !! Email error : {$mail->ErrorInfo}";
        }

    }


}




?>