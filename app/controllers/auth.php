<?php


class auth extends Controller
{


    public function index()
    {
        if (isset($_SESSION['useractive'])) {
            header('Location: ' . BASEURL . '/dashboard');
        } else {
            $data['title'] = "Login";
            $this->views('templates/header-auth', $data);
            $this->views('auth/index', $data);
            $this->views('templates/footer-auth');
        }
    }

    public function registrasi()
    {
        if (isset($_SESSION['useractive'])) {
            header('Location: ' . BASEURL . '/dashboard');
        } else {
            $data['title'] = "Registrasi";
            $data['dept'] = $this->models('corporate_model')->dataDept();
            $this->views('templates/header-auth', $data);
            $this->views('auth/registrasi', $data);
            $this->views('templates/footer-auth');
        }
    }

    public function forgotPassword()
    {
        if (isset($_SESSION['useractive'])) {
            header('Location: ' . BASEURL . '/dashboard');
        } else {
            $data['title'] = "Reset password";
            $this->views('templates/header-auth', $data);
            $this->views('auth/forgot');
            $this->views('templates/footer-auth');
        }
    }

    public function changePassword($email)
    {
        if (isset($_SESSION['useractive'])) {
            header('Location: ' . BASEURL . '/dashboard');
        } else {
            $data['title'] = "Change password";
            $data['user'] = $this->models('user_model')->getUserbyEmail($email);
            $this->views('templates/header-auth', $data);
            $this->views('auth/change-password', $data);
            $this->views('templates/footer-auth');
        }
    }

    public function gantiPassword()
    {
        if ($this->models('user_model')->updatePassword($_POST) > 0) {
            Flasher::setFlash('Proses reset password berhasil !', '', 'success', '', 'Silahkan login !');
            header('Location: ' . BASEURL . '/auth');
            exit;
        } else {
            Flasher::setFlash('Proses reset password gagal !', '', 'danger', '', 'Coba lagi !');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function cekLogin()
    {
        if ($this->models('auth_model')->cekLogin($_POST) > 0) {
            if ($this->models('auth_model')->cekAktivasi($_POST) > 0) {

                $_SESSION['useractive'] = $_POST['user'];
                $data['user'] = $this->models('user_model')->getUser();
                $id_user = $data['user']['id_user'];
                $dept = $data['user']['id_dept'];
                // var_dump($data['user']);

                //update last login activity
                $this->models('chat_model')->lastLogin($id_user);

                //finance role
                if ($data['user']['role'] == 4) {
                    header('Location: ' . BASEURL . '/kaskeluar');

                //trigger create notifikasi untuk user role Div Head
                } elseif ($data['user']['role'] == 5) {
                    $data['approve'] = $this->models('notifikasi_model')->getnotyetApproveDiv();
                    //create notifikasi jika ada wo yang belum approve 
                    // var_dump($data['approve']);
                    if (!empty($data['approve'])) {
                        $this->models('notifikasi_model')->tambahNotif($data);
                        header('Location: ' . BASEURL . '/dashboard');
                    } else {
                        header('Location: ' . BASEURL . '/dashboard');
                    }

                //trigger create notifikasi untuk user role HR Dept Head
                } elseif ($data['user']['role'] == 7) {
                    $data['approve'] = $this->models('notifikasi_model')->getnotyetApproveHR();
                    $data['approveDept'] = $this->models('notifikasi_model')->getnotyetApproveDept($dept);
                    //create notifikasi jika ada wo yang belum check HR 
                    // var_dump($data);
                    if (!empty($data['approve'])) {
                        $this->models('notifikasi_model')->tambahNotif($data);
                    }

                    if (!empty($data['approveDept'])) {
                        $this->models('notifikasi_model')->tambahNotifDept($data);
                    } 

                    header('Location: ' . BASEURL . '/dashboard');

                    //trigger create notifikasi untuk user role MTC Admin
                } elseif ($data['user']['role'] == 6) {
                $data['approve'] = $this->models('notifikasi_model')->getnotyetVerify();
                //create notifikasi jika ada wo yang belum di verifikasi
                if (!empty($data['approve'])) {
                    $this->models('notifikasi_model')->tambahNotif($data);
                    header('Location: ' . BASEURL . '/dashboard');
                } else {
                    header('Location: ' . BASEURL . '/dashboard');
                }

                //trigger create notifikasi untuk user role Dept Head
                } elseif ($data['user']['role'] == 3) {
                    $data['approveDept'] = $this->models('notifikasi_model')->getnotyetApproveDept($dept);
                    $data['receipt'] = $this->models('notifikasi_model')->getnotyetReceipt($id_user);
                    //create notifikasi jika ada wo yang belum di verifikasi
                    // var_dump($data);
                    if (!empty($data['approveDept'])) {
                        $this->models('notifikasi_model')->tambahNotifDept($data);
                        header('Location: ' . BASEURL . '/dashboard');
                    }
                    
                    if (!empty($data['receipt'])) {
                        $this->models('notifikasi_model')->tambahNotifReceipt($data);
                        header('Location: ' . BASEURL . '/dashboard');
                    }

                    header('Location: ' . BASEURL . '/dashboard');

                //trigger create notifikasi untuk user Staff
                } elseif ($data['user']['role'] == 2) {
                    $data['receipt'] = $this->models('notifikasi_model')->getnotyetReceipt($id_user);
                    //create notifikasi jika ada wo yang belum di handover
                    // var_dump($data);
                    if (!empty($data['receipt'])) {
                        $this->models('notifikasi_model')->tambahNotifReceipt($data);
                        header('Location: ' . BASEURL . '/dashboard');
                    } else {
                        header('Location: ' . BASEURL . '/dashboard');
                    }

                //jika user selain diatas
                } else {
                    header('Location: ' . BASEURL . '/dashboard');
                }


            } else {
                Flasher::setFlash('Login Gagal !!', 'User belum di aktivasi', 'danger', '', '');
                header('Location: ' . BASEURL . '/auth');
            }
        } else {
            Flasher::setFlash('Login Gagal !!', 'Username / password Anda salah', 'danger', '', '');
            header('Location: ' . BASEURL . '/auth');
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
    }

    public function blocked()
    {
        $data['title'] = "Access Blocked";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] = $this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('auth/blocked');
        $this->views('templates/footer');
    }

    public function userRegistration()
    {
        // var_dump($_POST);
        $mail = $_POST['email'];
        $username = $_POST['username'];
        $namauser = $_POST['namauser'];
        $token = bin2hex(random_bytes(20));
        $chat_id =  '-485461445'; //mtc
        $message = '*Registrasi user berhasil !*
`Nama user : ' . $namauser . '
Email : ' . $mail . '
Username : ' . $username . '
`';

        $email = [
            [
                'email' => $mail,
                'user' => $namauser
            ]
        ];


        if ($this->models('user_model')->cekUsername($_POST) > 0) {
            Flasher::setFlash('Gagal !!', '', 'danger', 'Anda', 'Username ' . $username . ' tidak tersedia !');
            header('Location: ' . BASEURL . '/auth/registrasi');
            exit;
        } elseif ($this->models('user_model')->cekEmail($_POST) > 0) {
            Flasher::setFlash('Gagal !!', '', 'danger', 'Anda', 'Email tidak tersedia !');
            header('Location: ' . BASEURL . '/auth/registrasi');
            exit;
        } elseif ($this->models('user_model')->tambahUser($_POST) > 0 && $this->models('user_model')->tambahToken($mail, $token) > 0) {
            Flasher::setFlash('Berhasil', '', 'success', '', 'Silahkan cek Email Anda untuk aktivasi !');
            header('Location: ' . BASEURL . '/auth');
            Mailer::sendEmail($email, $token, 'Aktivasi User', null);
            BotTelegram::sendMessage($message, $chat_id);
            exit;
        } else {
            Flasher::setFlash('Gagal !!', '', 'danger', '', '');
            header('Location: ' . BASEURL . '/auth/registrasi');
            exit;
        }
    }

    public function aktivasi()
    {
        //emngambil data dari url link aktivation
        $url = $this->parseURL();
        $email = $url[2];
        $token = $url[3];
        //cek expiry token aktivation
        $data = $this->models('user_model')->dataToken($token);
        $tgl_token = strtotime($data['date_created']);
        $today = strtotime(date("Y-m-d"));
        $expiry = $today - $tgl_token;
        //user id telegram recipient ( group MTC )
        $chat_id =  '-485461445';

        if ($this->models('user_model')->cekEmailAktivasi($email) > 0) {
            if ($this->models('user_model')->cekTokenAktivasi($token) > 0) {
                //                
                if ($expiry < (24 * 60 * 60)) {
                    Flasher::setFlash('Proses aktivasi user berhasil !', '', 'success', '', 'Silahkan login !');
                    $this->models('user_model')->aktivasiUser($email);
                    BotTelegram::sendMessage('Aktivasi user Anda berhasil, silahkan login !', $chat_id);
                    header('Location: ' . BASEURL . '/auth');
                } else {
                    Flasher::setFlash('Proses aktivasi user gagal !', '', 'danger', '', 'Token expired, silahkan registrasi ulang !');
                    //hapus data token expired
                    $this->models('user_model')->hapusToken($token);
                    $this->models('user_model')->hapusUser($email);
                    header('Location: ' . BASEURL . '/auth');
                }
            } else {
                Flasher::setFlash('Proses aktivasi user gagal !', '', 'danger', '', 'Token Anda tidak valid !');
                header('Location: ' . BASEURL . '/auth');
            }
        } else {
            Flasher::setFlash('Proses aktivasi user gagal !', '', 'danger', '', 'Email Anda tidak valid !');
            header('Location: ' . BASEURL . '/auth');
        }
    }


    public function reset()
    {
        $token = bin2hex(random_bytes(20));
        $data = $this->models('user_model')->getUserbyEmail($_POST['email']);
        $namauser = $data['nama_user'];
        $chat_id = $data['id_telegram'];

        $email = [
            [
                'email' => $_POST['email'],
                'user' => $namauser
            ]
        ];
        // var_dump($email);

        if ($this->models('user_model')->cekEmail($_POST) == 0 or $this->models('auth_model')->cekAktivasi2($_POST['email']) == 0) {
            Flasher::setFlash('Email belum teregistrasi / aktivasi !', '', 'danger', '', '');
            header('Location: ' . BASEURL . '/auth/forgotPassword');
            exit;
        } elseif ($this->models('user_model')->tambahToken($_POST['email'], $token) > 0) {
            Flasher::setFlash('Link reset password berhasil dikirim', '', 'success', '', '');
            header('Location: ' . BASEURL . '/auth/forgotPassword');
            Mailer::sendEmail($email, $token, 'Reset password', null);
            BotTelegram::sendMessage('Link reset password telah berhasil dikirim. *Silahkan cek Email Anda !!*', $chat_id);
            exit;
        } else {
            Flasher::setFlash('Reset password gagal !', '', 'danger', '', '');
            header('Location: ' . BASEURL . '/auth/forgotPassword');
            exit;
        }
    }

    public function resetPassword()
    {
        //mengambil data dari url link aktivation
        $url = $this->parseURL();
        $email = $url[2];
        $token = $url[3];
        //cek expiry token aktivation
        $data = $this->models('user_model')->dataToken($token);
        $tgl_token = strtotime($data['date_created']);
        $today = strtotime(date("Y-m-d"));
        $expiry = $today - $tgl_token;

        // var_dump($data);

        if ($this->models('user_model')->cekEmailAktivasi($email) > 0) {
            if ($this->models('user_model')->cekTokenAktivasi($token) > 0) {
                //                
                if ($expiry < (24 * 60 * 60)) {
                    header('Location: ' . BASEURL . '/auth/changePassword/' . $email);
                } else {
                    Flasher::setFlash('Token Anda Expired !', '', 'danger', '', '');
                    //hapus data token expired
                    $this->models('user_model')->hapusToken($token);
                    header('Location: ' . BASEURL . '/auth/forgotPassword');
                }
            } else {
                Flasher::setFlash('Token Anda tidak valid !', '', 'danger', '', '');
                header('Location: ' . BASEURL . '/auth/forgotPassword');
            }
        } else {
            Flasher::setFlash('Email Anda tidak valid !', '', 'danger', '', '');
            header('Location: ' . BASEURL . '/auth/forgotPassword');
        }
    }
}
