$(document).ready(function () {

    const localhost = 'http://localhost/myportpolio/workorder/public/';
    // const localhost = 'http://workorder.argapura.local/public/';
    // const localhost = 'http://localhost/workorder/public/';

    reload_chat();

    //fungsi untuk refresh otomatis pesan 
	setInterval(function(){
		reload_chat();
        update_last_chat();
    }, 5000);

    setInterval(function(){
        update_last_activity();
    }, 60000);

    


    //chat readed
    $('.msg_history').scroll(function (event) {
        var scrollpos = $('.msg_history').scrollTop();
        // console.log(scrollpos);

        var realHeight = $('.msg_history')[0].scrollHeight; 
        var divHeight = $('.msg_history').height();
        var maxScroll = realHeight - divHeight; 
        // console.log(maxScroll);

        if(scrollpos >= maxScroll){

            const id_sender = $('.id_sender').val();
            const id_receiver = $('.id_receiver').val();

            // console.log(id_receiver);
            //kirim pesan readed
            $.ajax({

                url: localhost + 'chat/readChat',
                data: {
                    id_receiver: id_receiver,
                    id_sender: id_sender
                },
                method: 'post',
                dataType: 'json',
                success: function (data){
                    // console.log('chat readed');
                    $('.unreaded'+id_receiver).remove();
                    $('div.chat_list#'+id_receiver+' h5').removeClass('text-primary font-weight-bold');
                    $('.unread_msg').remove();
                }                 
                
            });
        }
    
    });

    
    //pesan terbaru
    function update_last_chat(){
    
        const id_sender = $('.id_sender').val();
        const id_receiver = $('.id_receiver').val();   
        // console.log(id_receiver);     

        $.ajax({

            url: localhost + 'chat/getUpdatelastchat',
            data: {
                id_sender: id_sender
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log(JSON.stringify(data));
                for (let i=0 ; i < data.length ; i++){
                        // console.log(data[i].from_user);
                        $('.chat_list#'+data[i].from_user+' h5').removeClass('text-primary font-weight-bold');
                        $('.chat_list#'+data[i].from_user+' h5').addClass('text-primary font-weight-bold');

                        $('.chat_list#'+data[i].from_user+' p span').remove();
                        $('.chat_list#'+data[i].from_user+' p').append('<span data-toggle="tooltip" title="'+data[i].jml+' New Messages" class="badge badge-primary float-right unreaded'+id_receiver+'">'+data[i].jml+'</span>');
                }    

            }

        });

        $.ajax({

            url: localhost + 'chat/getOnline',
            data: {
                id_sender: id_sender
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log(JSON.stringify(data));
                for (let i=0 ; i < data.length ; i++){
                    let lastact = Date.parse(data[i].last_activity);
                    let now = Date.parse(moment());
                    let is_online = now - lastact;
                    
                    //cek status on line 30 menit yang lalu
                    if(is_online <= 1800000){
                        // console.log(data[i].id_user+'|'+is_online);
                        $('.chat_list#'+data[i].id_user+' img').removeClass('online');
                        $('.chat_list#'+data[i].id_user+' img').removeClass('offline');
                        $('.chat_list#'+data[i].id_user+' img').addClass('online');
                    } else {
                        $('.chat_list#'+data[i].id_user+' img').removeClass('online');
                        $('.chat_list#'+data[i].id_user+' img').removeClass('offline');
                        $('.chat_list#'+data[i].id_user+' img').addClass('offline');
                    }
                }    

            }

        });

    }

    

    //fungsi reload chat
    function reload_chat(){
        
        const id_sender = $('.id_sender').val();
        const id_receiver = $('.id_receiver').val();
        const photo1 = $('.img-profile').data('profil');
        const photo2 = $('div.chat_list#'+id_receiver).data('profil');
        $('.id_receiver').val(id_receiver);
        // console.log(id_sender);

        $.ajax({

            url: localhost + 'chat/getChatdetail',
            data: {
                id_receiver: id_receiver,
                id_sender: id_sender
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log(JSON.stringify(data));
                // console.log(data.length);
                
                //menghapsu content message
                $('.incoming_msg').remove();
                $('.outgoing_msg').remove();
                $('.unread_msg').remove();
                
                // array empty or does not exist
                if (data.length > 0) {
                    //looping chat
                    let unread = '';
                    let numUnread = 0;
                    //hitung unread message
                    for (let i=0 ; i < data.length ; i++){
                        if(data[i].to_user == id_sender){
                            //cek apakah pesan belum dibaca
                            if(data[i].readed == 0){
                                numUnread++;        
                            }
                        }
                    }

                    for (let i=0 ; i < data.length ; i++){
                        // console.log(id_user);
                        //cek apakah pesan masuk
                        if(data[i].to_user == id_sender){
                            //cek apakah pesan belum dibaca
                            if(data[i].readed == 0 && data[i].readed != unread){
                                //cetak unread mesasge
                                $('.msg_history').append('<div class="unread_msg"><div class="unread_withd_msg"><p>'+numUnread+' unread message</p></div></div>');         
                            }
                            //cetak pesan masuk
                            $('.msg_history').append('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="' + localhost + '/img/profile/'+ photo2 +'" alt="'+photo2+'"></div><div class="received_msg"><div class="received_withd_msg"><p>' + data[i].chat_message + '</p><span class="time_date">' + moment(data[i].chat_time).format('D MMM YY') + ' | ' + moment(data[i].chat_time).format('LT') + '</span></div></div></div>');
                        } else {
                            //pesan outgoing
                            $('.msg_history').append('<div class="outgoing_msg"><div class="outgoing_msg_img"> <img src="' + localhost + '/img/profile/'+ photo1 +'" alt="'+photo1+'"> </div><div class="sent_msg"><p>' + data[i].chat_message + '</p><span class="time_date_out">' + moment(data[i].chat_time).format('D MMM YY') + ' | ' + moment(data[i].chat_time).format('LT') + '</span></div></div>');
                        }
                        unread = data[i].readed;
                    }


                }



            }

        });

    }


    function update_last_activity() {

        const id_sender = $('.id_sender').val();
        // console.log(id_sender);

        $.ajax({

            url: localhost + 'chat/updateLastactivity',
            data: {
                id_sender: id_sender
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log('sukses');
                

            }

        });
    }


    //fungsi untuk menampilkan detail chat
    $('.chat_list').on('click', function () {

        const id_sender = $('.id_sender').val();
        const id_receiver = $(this).data('iduser');
        const photo1 = $('.img-profile').data('profil');
        const photo2 = $(this).data('profil');
        const nama = $(this).data('nama');
        const status = $(this).data('status');
        const login = $(this).data('login');
        const lastLogin = moment(login).format('D MMM YY')+' | '+moment(login).format('LT');
        $('.id_receiver').val(id_receiver);
        // console.log(login);
        // console.log(lastLogin);

        //hapus & menambahkan kelas active
        $('div.chat_list').removeClass('active_chat');
        $('div.chat_list#'+id_receiver).addClass('active_chat');

        $.ajax({

            url: localhost + 'chat/getChatdetail',
            data: {
                id_receiver: id_receiver,
                id_sender: id_sender
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log(JSON.stringify(data));
                // console.log(data.length);
                $('.user-info > p').remove()
                let icon ='text-danger';

                if(status == 'online'){
                    icon = 'text-success';
                }
                
                $('.user-info').append('<p class="font-weight-bold ml-3"><i class="fas fa-circle '+icon+' shadow-lg mr-2"></i>'+nama+'<span class="small text-gray-500 ml-2">('+status+')</span><span class="small text-gray-500 ml-3">last seen at '+lastLogin+'</span></p>');
                
                //menghapsu content message
                $('.incoming_msg').remove();
                $('.outgoing_msg').remove();
                $('.unread_msg').remove();
                
                // array empty or does not exist
                if (data.length > 0) {
                    //looping chat
                    let unread = '';
                    let numUnread = 0;
                    //hitung unread message
                    for (let i=0 ; i < data.length ; i++){
                        if(data[i].to_user == id_sender){
                            //cek apakah pesan belum dibaca
                            if(data[i].readed == 0){
                                numUnread++;        
                            }
                        }
                    }

                    for (let i=0 ; i < data.length ; i++){
                        // console.log(id_user);
                        if(data[i].to_user == id_sender){
                            if(data[i].readed == 0 && data[i].readed != unread){
                                //cetak unread mesasge
                                $('.msg_history').append('<div class="unread_msg"><div class="unread_withd_msg"><p>'+numUnread+' unread message</p></div></div>');         
                            }

                            $('.msg_history').append('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="' + localhost + '/img/profile/'+ photo2 +'" alt="'+photo2+'"></div><div class="received_msg"><div class="received_withd_msg"><p>' + data[i].chat_message + '</p><span class="time_date">' + moment(data[i].chat_time).format('D MMM YY') + ' | ' + moment(data[i].chat_time).format('LT') + '</span></div></div></div>');
                        } else {
                            //pesan outgoing
                            $('.msg_history').append('<div class="outgoing_msg"><div class="outgoing_msg_img"> <img src="' + localhost + '/img/profile/'+ photo1 +'" alt="'+photo1+'"> </div><div class="sent_msg"><p>' + data[i].chat_message + '</p><span class="time_date_out">' + moment(data[i].chat_time).format('D MMM YY') + ' | ' + moment(data[i].chat_time).format('LT') + '</span></div></div>');
                        }
                        unread = data[i].readed;
                    }
                }
                //scroll down
                var realHeight = $('.msg_history')[0].scrollHeight; 
                var divHeight = $('.msg_history').height();
                var maxScroll = realHeight - divHeight; 
                $('.msg_history').animate({
                    scrollTop: maxScroll
                }, 1000);


            }

        });



    });


    //mengirimkan chat
    $('.msg_send_btn').on('click', function(){
        
        //mengambil value pesan 
        const chat = $('.write_msg').val();
        const id_sender = $('.id_sender').val();
        const id_receiver = $('.id_receiver').val();
        const photo1 = $('.img-profile').data('profil');
        $('.write_msg').val('');
        $('input[name="chat_message"]').focus();
        // console.log(id_sender);

        $.ajax({

            url: localhost + 'chat/saveChat',
            data: {
                id_receiver: id_receiver,
                id_sender: id_sender,
                chat: chat
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log(data);

                // jika data tersimpan / terkirim
                if (data > 0) {
                    //pesan outgoing
                    $('.msg_history').append('<div class="outgoing_msg"><div class="outgoing_msg_img"> <img src="' + localhost + '/img/profile/'+ photo1 +'" alt="'+photo1+'"> </div><div class="sent_msg"><p>' + chat + '</p><span class="time_date_out">' + moment().format('D MMM YY') + ' | ' + moment().format('LT') + '</span></div></div>');

                    //update pesan di user list
                    $('.chat_list#'+id_receiver+' p').html(chat);
                    $('.chat_list#'+id_receiver+'h5 span').html(moment().format('D MMM YY')+ ' | ' + moment().format('LT'));

                    //manampilkan pesan terakhir di user list
                    // $('.chat_list#'+id_receiver+' p').append('')
                }

                //scroll down
                var realHeight = $('.msg_history')[0].scrollHeight; 
                var divHeight = $('.msg_history').height();
                var maxScroll = realHeight - divHeight; 
                $('.msg_history').animate({
                    scrollTop: maxScroll
                }, 1000);



            }

        });


    });




});