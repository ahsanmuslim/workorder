<?php

// Import PHPMailer classes into the global namespace, These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mailer {




    public static function sendEmail ($email, $token, $type, $pesan)
    {

        // require_once 'vendor/autoload.php';
        require_once 'D:\xampp\htdocs\myportpolio\workorder\public\vendor\autoload.php';
    
        $mail = new PHPMailer(true);    

        try {
            //Server email settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            // $mail->isSMTP();
            // $mail->Host       = 'smtp.gmail.com';
            // $mail->SMTPAuth   = true;
            // $mail->Username   = 'workorder.argapura@gmail.com';
            // $mail->Password   = 'quhkwprognlfhksi';
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->Port       = 587;


            // //Server email settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp-relay.gmail.com';
            $mail->SMTPAuth   = false;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Penrima email
            $mail->setFrom('workorder.argapura@gmail.com', 'WO Localhost');
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
                // $mail->addCC("tetapfokus39@gmail.com");
                // $mail->addCC("kikielbe@gmail.com");
                $mail->addAttachment('../public/file/email/Outstanding WO.xlsx');  

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
                $body = '<html>
                Dear All Dept Head,<br><br>
                Mohon segera approve Work Order yang telah diajukan agar bisa di tindak lanjuti ke proses berikutnya.<br>
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
                Silahkan klik link di bawah untuk <b>APPROVE</b> Work Order yang sudah diajukan ! <br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a>';

                $mail->Body = $body.'</html>';

            } elseif ( $type == 'Reminder Approve  Div Head' ) {
                $body = '<html>
                Dear pak Adith,<br><br>
                Ada Work Order yang yang harus diperiksa & di approve.<br>
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
                Silahkan klik link di bawah untuk <b>APPROVE</b> Work Order yang sudah diajukan<br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a>';

                $mail->Body = $body.'</html>';

            } elseif ( $type == 'Reminder Verifikasi Work Order' ) {
                $body = '<html>
                Dear Admin MTC,<br><br>
                Mohon segera verifikasi Work Order yang telah diajukan agar bisa di tindak lanjuti ke proses berikutnya.<br>
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
                Silahkan klik link di bawah untuk <b>VERIFIKASI</b> Work Order yang sudah diajukan ! <br><a href="'. BASEURL .'/workorder"><b>Aplikasi Work Order</b></a>';

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