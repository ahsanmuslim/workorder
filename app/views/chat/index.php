<style>
    img {
        border-radius: 50%/50%;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Direct Chat Message</h1> -->

    <!-- <div class="card mb-2 shadow mt-4">

        <div class="card-body"> -->
    <!-- <content> -->

    <div class="row">

        <div class="inbox_msg mb-3 mt-3 ml-3 mr-3">

            <!-- kontak  -->
            <div class="inbox_people">

                <div class="headind_srch">
                    <div class="text-primary">
                        <h4>User Contacts</h4>
                        <input type="hidden" value="<?= $data['user']['id_user'] ?>" class="id_sender">
                        <input type="hidden" value="<?= $data['userlist'][0]['id_user'] ?>" class="id_receiver">
                    </div>
                </div>

                <div class="inbox_chat">
                    <!-- chat kontak -->

                    <?php
                    $no = 0;
                    foreach ($data['userlist'] as $usr) : ?>
                        <?php
                        $id_receiver = $usr['id_user'];
                        $id_sender = $data['user']['id_user'];
                        $message = $this->models('chat_model')->lastChat($id_receiver, $id_sender);
                        $unread = $this->models('chat_model')->unreadChat($id_sender, $id_receiver);
                        $unreadmessage = '';
                        $textprimary = '';
                        $chat = count($unread);
                        // echo $chat;
                        if ($chat > 0) {
                            $unreadmessage = '<span data-toggle="tooltip" title="' . $chat . ' New Messages" class="badge badge-primary float-right unreaded' . $id_receiver . '">' . $chat . '</span>';
                            
                            $textprimary = "text-primary font-weight-bold";
                        }

                        //cek availability user
                        $lastseen = 'offline';
                        $lastlogin = strtotime($usr['last_activity']);
                        $now = strtotime(date("Y-m-d H:i:s"));
                        $status = $now - $lastlogin;
                        if ($status <= 1800) {
                            $lastseen = 'online';
                        }

                        $no++;
                        $aktif = '';
                        if ($no == 1) {
                            $aktif = 'active_chat';
                        }

                        ?>
                        <div class="chat_list <?= $aktif ?>" data-iduser="<?= $usr['id_user']; ?>" data-nama="<?= $usr['nama_user']; ?>" data-status="<?= $lastseen ?>" data-login="<?= $usr['last_activity'] ?>" data-profil="<?= $usr['profile']; ?>" id="<?= $usr['id_user']; ?>">
                            <div class="chat_people">
                                <div class="chat_img"> <img class="<?= $lastseen ?>" src="<?= BASEURL; ?>/img/profile/<?= $usr['profile'] ?>" alt="<?= $usr['profile'] ?>">
                                </div>
                                <div class="chat_ib" id="<?= $usr['id_user']; ?>">
                                    <?php
                                    $waktu = '';
                                    if (!empty($message)) {
                                        $waktu = date('d M g:i A', strtotime($message['chat_time']));
                                    }
                                    ?>
                                    <h5 class="<?= $textprimary ?>"><?= $usr['nama_user'] ?><span class="small text-gray-600"><?= $waktu ?></span></h5>
                                    <?php
                                    if($message){ ?>
                                        <p><?= $message['chat_message'] ?><?= $unreadmessage ?></p>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>



                </div>
            </div>



            <!-- history pesan  -->
            <div class="mesgs">

                <div class="user-info">

                    <!-- user info  -->
                    <?php
                    $availability = 'offline';
                    $activity = $data['userlist'][0]['last_activity'];
                    $lastact = strtotime($activity);
                    $now = strtotime(date("Y-m-d H:i:s"));
                    $stat = $now - $lastact;
                    $icon = 'text-danger';
                    if ($stat <= 1800) {
                        $availability = 'online';
                        $icon = 'text-success';
                    }
                    $last = date('d M y', strtotime($activity)) . ' | ' . date('g:i A', strtotime($activity));
                    ?>

                    <p class="font-weight-bold ml-3"><i class="fas fa-circle <?= $icon ?> shadow-lg mr-2"></i><?= $data['userlist'][0]['nama_user'] ?><span class="small text-gray-500 ml-2">(<?= $availability ?>)</span><span class="small text-gray-500 ml-3">last seen at <?= $last ?></span></p>

                </div>

                <div class="msg_history">

                    <!-- chat -->

                </div>

                <!-- button lirim -->
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" name="chat_message" class="write_msg" placeholder="Type a message" />
                        <button class="msg_send_btn" type="button"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>


            </div>


        </div>


        <!-- <content> -->
        <!-- </div>
    </div>
-->





        <!-- //footer -->
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->