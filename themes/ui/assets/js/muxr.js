/**
 * Created by rashidovn on 08.06.2017.
 */
Muxr={
    //------------------------- Notification ajax code goes here ----------------//
    openNotificationForm:function(){
        console.log('openNotificationForm');
        $("#modal_add_notification_btn").click(function(){
            var m=UIkit.modal('#modal_add_notification');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_notification").hide();     
        });
    },
    openEditNotificationForm:function(){
        var id;
        $(".modal-edit-notification").click(function(){
            var type = $(this).attr('data-type'),
                message = $(this).attr('data-message'),
                action = $(this).attr('data-action'),
                role = $(this).attr('data-role'),
                user = $(this).attr('data-user');
                id = $(this).attr('data-id');
            $('#nott-type').val(type);
            $('#nott-message').val(message);
            $('#nott-action').val(action);
            $('#nott-role').val(role);
            $('#nott-user').val(user);
            

            var m=UIkit.modal('#modal_edit_notification');
            if ( m.isActive() ) {
                m.hide();

                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveNotificationEdit').click(function(){
            //data['id'] = 500;
          var data=$('#formNotificationEdit').serialize();
          
          console.log('data attr');
          //var id = $(this).attr('data-id');
            
            $.post('/reference/notification/edit/'+id,{data:data},function(response){
                    console.log(response);
                
                if(response.status == 'successEditLoad'){
                    
                     $('#modal_edit_notification').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    
                }
                $('#modal_edit_notification').unbind();
                
                
            });
        });
        });
    },
    openDeleteNotificationForm:function(){
        $('.modal-delete-notification').click(function(){
        var pk=$(this).attr("data-id");
        var url='/reference/notification/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    saveNotification:function(){
        $('#saveNotification').click(function(){
            if($('#notificationEdit')){
                console.log('bor');
            }
            
          var data=$('#formNotification').serialize();

            $.post('/reference/notification/save',{data:data},function(response){
                console.log(data);
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_notification').hide();

                     UIkit.modal('#modal_notificationNotification').show();
                     $('#modal_add_notification').unbind();
                     $('#modal_notificationNotification').unbind();
                     
                }
                else{
                    
                }
            });

        });
        
    },
    openClearedNotification:function(){
        $('#addAnotherNotification').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationNotification').hide(); 
            
            $("#formNotification")[0].reset();
            UIkit.modal('#modal_add_notification').show();
            
            
            $('#modal_add_notification').unbind();  
            $('#modal_notificationNotification').unbind();
            $('.uk-close').unbind();  
        });
    },
    editNotificationStatus:function(){
        $('.modal-edit-notification-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reference/notification/changestatus/'+Mstatus,{data:Mstatus},function(response){
                    
                    if(response.status == 'statusChanged'){
                        console.log(response.status);
                        window.location.reload();
                    }
                    
                     
                
            });
        });
    },
    //---------------------------------------------------------------------------//
    changeDropDownKurs:function(){
        $("#fan").change(function(){
            var $option = $(this).find('option:selected');
            var value = $option.val();//to get content of "value" attrib
            $('#ttt-kurs').children().remove();
            $.post('/users/course/kasblist/'+value,{data:value},function(response){
                
                $('#ttt-kurs').append(response);
            });
        });
        
    },
    changeDropDownKasbSubject:function(){
        $("#dir-direct").change(function(){
            var $option = $(this).find('option:selected');
            var value = $option.val();//to get content of "value" attrib
            $('#dir-fan').children().remove();
            $.post('/reference/subject/subjectlist/'+value,{data:value},function(response){
                //console.log(response);
                $('#dir-fan').append(response);
                //selectize.setValue(response);
            });
        });
        
        
    },
    //----------------------------Attach -----------------------------//
    viewAttach:function(){
        $('.modal-view-attach').click(function(){
        var kasb_id=$(this).attr("data-id"),
            data = "sa";
        $.post('/reference/kasb/view/'+kasb_id,{data:data},function(response){
                    //console.log(response);
                
              
                
            });
    });
    },
    changeAttachOrder:function(){
        $('.modal-edit-order').click(function(){
        var id=$(this).attr("data-id"),
            data = $(this).attr("data-move");
            //var data = dat.serialize();
        $.post('/reference/attach/changeorder/'+id,{data:data},function(response){
                    console.log(response.status);
                
                if(response.status == 'successEditLoad'){
                    
                     $('#modal_edit_order').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    
                }
                $('#modal_edit_order').unbind();
                
                
            });
    });
    },
    openAttachForm:function(){
        
        console.log('sss');
        $("#modal_add_attach_btn").click(function(){
            var m=UIkit.modal('#modal_add_attach');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_attach").hide();     
        });
    },
    openEditAttachForm:function(){
        var id;
        $(".modal-edit-attach").click(function(){
            var kasb = $(this).attr('data-kasb'),
                fan = $(this).attr('data-fan'),
                order = $(this).attr('data-order'),
                id = $(this).attr('data-id');
            $('#kasb-kasb').val(kasb);
            $('#kasb-fan').val(fan);
            $('#kasb-order').val(order);
            //$.post('/reference/')
            

            var m=UIkit.modal('#modal_edit_attach');
            if ( m.isActive() ) {
                m.hide();

                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveAttachEdit').click(function(){
            //data['id'] = 500;
          var data=$('#formAttachEdit').serialize();
          
          console.log('data attr');
          //var id = $(this).attr('data-id');
            
            $.post('/reference/attach/edit/'+id,{data:data},function(response){
                    console.log(response);
                
                if(response.status == 'successEditLoad'){
                    
                     $('#modal_edit_attach').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    
                }
                $('#modal_edit_attach').unbind();
                
                
            });
                
        });
        });
    },
    openDeleteAttachForm:function(){
        $('.modal-delete-attach').click(function(){
        var pk=$(this).attr("data-id");
        var url='/reference/attach/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    saveAttach:function(){
        $('#saveAttach').click(function(){
            // if($('#attachEdit')){
            //     console.log('bor');
            // }
            
          var data=$('#formAttach').serialize();

            $.post('/reference/attach/save',{data:data},function(response){
                console.log(response.status);
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_attach').hide();

                     UIkit.modal('#modal_notificationAttach').show();
                     $('#modal_add_attach').unbind();
                     $('#modal_notificationAttach').unbind();
                     
                }
                else{
                    
                }
            });

        });
        
    },
    openClearedAttach:function(){
        $('#addAnotherAttach').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationAttach').hide(); 
            
            $("#formAttach")[0].reset();
            UIkit.modal('#modal_add_attach').show();
            
            
            $('#modal_add_attach').unbind();  
            $('#modal_notificationAttach').unbind();
            $('.uk-close').unbind();  
        });
    },
    editAttachStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reference/attach/changestatus/'+Mstatus,{data:Mstatus},function(response){
                    
                    if(response.status == 'statusChanged'){
                        console.log(response.status);
                        window.location.reload();
                    }
                    
                     
                
            });
        });
    },


    //----------------------------- Kasb -----------------------------//
    changeDropDownDirection:function(){
       var selectize= $("#dir-fan").selectize();

        $("#dir-direct").change(function(){
                    var $option = $(this).find('option:selected');
                $('#dir-direction').children().remove();
            var value = $option.val();//to get content of "value" attrib
            $.post('/reference/direction/list/'+value,{data:value},function(response){
                    
                   $('#dir-direction').append(response);                    
            });
        });
        $('#dir-direction').change(function(){
              var $option = $(this).find('option:selected');
                $('#dir-fan').children().remove();
            var value = $option.val();//to get content of "value" attrib
            if(value){
                $.post('/reference/subject/list/'+value,{data:value},function(response){
                    console.log('success');
                     ///var selectize= $("#dir-fan").selectize();
                        
                    $('#dir-fan').selectize()[0].selectize.destroy();
                    $("#dir-fan").append(response); 
                    $("#dir-fan").selectize();
                   
            });
            }

        });
    },
    
    // changeDropDownKasb:function(){
    //     $("#dir-direct").change(function(){
    //         var $option = $(this).find('option:selected');
    //         var value = $option.val();//to get content of "value" attrib
    //         $.post('/reference/kasbKasbionlist/'+value,{data:value},function(response){
    //                 //console.log(response);
    //                $('#dir-direction').children().remove();
    //                 for (var i in response) {
    //                     console.log(i);
    //                     var inp = "<option value='"+response[i].id+"'>"+response[i].title+"</option>";
    //                     $('#dir-direction').append(inp);
    //                 }
    //         });
    //     });
    //     $("#dir-directt").change(function(){
    //         var $option = $(this).find('option:selected');
    //         var value = $option.val();//to get content of "value" attrib
    //         $.post('/reference/kasb/directionlist/'+value,{data:value},function(response){
    //             //console.log(response);
    //             $('#dir-directiont').children().remove();
    //             for (var i in response) {
    //                 console.log(i);
    //                 var inp = "<option value='"+response[i].id+"'>"+response[i].title+"</option>";
    //                 $('#dir-directiont').append(inp);
    //             }
    //         });
    //     });
    // },
    openKasbForm:function(){
        console.log('sss');
        $("#modal_add_kasb_btn").click(function(){
            var m=UIkit.modal('#modal_add_kasb');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_kasb").hide();     
        });
    },
    openEditKasbForm:function(){
        var id;
        $(".modal-edit-kasb").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short');
                direct = $(this).attr('data-direct');
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            $('#dir-direct').val(direct);
            
            

            var m=UIkit.modal('#modal_edit_kasb');
            if ( m.isActive() ) {
                m.hide();

                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveKasbEdit').click(function(){
            //data['id'] = 500;
          var data=$('#formKasbEdit').serialize();
          
          console.log('data attr');
          //var id = $(this).attr('data-id');
            
            $.post('/reference/kasb/edit/'+id,{data:data},function(response){
                    console.log(response);
                
                if(response.status == 'successEditLoad'){
                    
                     $('#modal_edit_kasb').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    
                }
                $('#modal_edit_kasb').unbind();
                
                
            });
                
        });
        });
    },
    openDeleteKasbForm:function(){
        $('.modal-delete-kasb').click(function(){
        var pk=$(this).attr("data-id");
        var url='/reference/kasb/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    saveKasb:function(){
        $('#saveKasb').click(function(){
            
            
          var data=$('#formKasb').serialize();

            $.post('/reference/kasb/save',{data:data},function(response){
                //console.log(response.status);
                if(response.status=='success'){
                    // console.log("kasb save");
                    response.status == 'un';
                    UIkit.modal('#modal_add_kasb').hide();

                     UIkit.modal('#modal_notificationKasb').show();
                     $('#modal_add_kasb').unbind();
                     $('#modal_notificationKasb').unbind();
                     
                }
                else{
                    
                }
            });

        });
        
    },
    openClearedKasb:function(){
        $('#addAnotherKasb').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationKasb').hide(); 
            
            $("#formKasb")[0].reset();
            UIkit.modal('#modal_add_kasb').show();
            
            
            $('#modal_add_kasb').unbind();  
            $('#modal_notificationKasb').unbind();
            $('.uk-close').unbind();  
        });
    },
    editKasbStatus:function(){
        $('.modal-edit-status-kasb').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reference/kasb/changestatus/'+Mstatus,{data:Mstatus},function(response){
                    
                    if(response.status == 'statusChanged'){
                        console.log(response.status);
                        window.location.reload();
                    }
                    
                     
                
            });
        });
    },

    //-----------------------------COURSE-----------------------------//
    createCourse:function() 
    {
        $('#saveCourse').click(function () {
            var data = $('#addCourse').serialize();
            console.log(data);
            $.post('/page/course/create', {data: data}, function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
                console.log(response);
            });
        });
    },
    openDeleteCourse:function(){
        $('#modalDeletecourse').click(function(){
            var pk=$(this).attr("data-deleteid");
            var url='/page/course/delete/'+pk;

            $('#modalDeleteCourse').click(function(){
                $.post(url,{id:pk},function(response){
                    if(response.status=="success"){
                        window.location.reload();
                        // $("#row_"+pk).remove();
                        console.log("Удален!", "Информация удален.", "success");
                    }else{
                        console.log("Не удален!", "Информация не удален.", "error");
                    }
                });
               
            });

        });
    },
    editCourse:function()
    {
        var id;
        $('.fa-pencil-square-o').click(function(){
            var id = $(this).attr('data-id'),
            oldtitle = $(this).attr('data-title'),
            oldsubject = $(this).attr('data-subject'),
            oldshort = $(this).attr('data-short'),
            olddescription = $(this).attr('data-description');
            $('#edittitle').val(oldtitle);
            $('#editdir-direct').val(oldsubject);
            $('#editshort').val(oldshort);
            $('#editdesc').val(olddescription);

            // edit inputs
            $('#editedSaveCourse').click(function(){
               var data=$('#editCourse').serialize();
               $.post('/page/course/edit/'+id,{data:data},function(response){
                if(response.status == 'successEditLoad'){
                   window.location.reload();
                   $('#editmodal').unbind();
               }
           });
           });
        });
    },
    openFeedview:function()
    {
        $('#openFeedbackView').click(function () {
            var text = $(this).attr('data-text');
            var name = $(this).attr('data-name');
            $('#feed-text').html(text);
            $('#feed-user').html(name);

            console.log($('#feed-text').html());
            var feedtext = UIkit.modal('#modal_open_feedback_form');
            feedtext.show();
        });
        $(".uk-modal-close .uk-close").click(function(){
            $("#modal_open_feedback_form").hide();
            feedtext.unbind();
        });
    },
    sendMessage:function()
    {
        $('#opensendmessageform').click(function () {
            var sendmodal = UIkit.modal('#modal_send_message_form');
            if ( sendmodal.isActive() ) {
                sendmodal.hide();
                sendmodal.unbind();
            } else {
                sendmodal.show();
            }
        });
    },
    addFeedback:function() {
        $("#submit").click(function () {
            var data = $("#commentform").serialize();
            $.post('/page/video/save', {data: data}, function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
                console.log(response);
            });
        });
    },
    //-----------------------------COURSE-----------------------------//
    //----------------------------- Test -----------------------------------------------------//
    changeDropDownTest:function(){
        $("#dir-test").change(function(){
            var $option = $(this).find('option:selected');
            var value = $option.val();//to get content of "value" attrib

        });
    },
    openTestForm:function(){
        console.log('sss');
        $("#modal_add_test_btn").click(function(){
            var m=UIkit.modal('#modal_add_test');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
            $("#modal_add_test").hide();
        });
    },

    openDeleteTestForm:function(){
        $('.modal-delete-test').click(function(){
            var pk=$(this).attr("data-id");
            var url='/reference/test/delete/'+pk;
            swal({
                    title: "Вы уверены?",
                    text: "Вы не сможете восстановить эту информацию!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "md-btn md-btn-danger",
                    confirmButtonText: "Да, удалить!",
                    cancelButtonText: "Отмена",
                    closeOnConfirm: false
                },
                function(){
                    $.post(url,{id:pk},function(data){
                        if(data.status=="success"){
                            $("#row_"+pk).remove();
                            swal("Удален!", "Информация удален.", "success");
                        }else{
                            swal("Не удален!", "Информация не удален.", "error");
                        }
                    });

                });

        });
    },
    saveTest:function(){
        $('#saveTest').click(function(){
            if($('#TestEdit')){
                console.log('bor');
            }

            var data=$('#formTest').serialize();

            $.post('/reference/test/save',{data:data},function(response){
                console.log(data);
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_test').hide();

                    UIkit.modal('#modal_notificationTest').show();
                    $('#modal_add_test').unbind();
                    $('#modal_notificationTest').unbind();

                }
                else{

                }
            });

        });

    },
    openClearedTest:function(){
        $('#addAnotherTest').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationTest').hide();

            $("#formTest")[0].reset();
            UIkit.modal('#modal_add_test').show();


            $('#modal_add_test').unbind();
            $('#modal_notificationTest').unbind();
            $('.uk-close').unbind();
        });
    },
    editTestStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reference/test/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }



            });
        });
    },
    openEditTestForm:function(){
        var id;
        $(".modal-edit-test").click(function(){

            var question = $(this).attr('data-question'),
                course = $(this).attr('data-course'),
                order = $(this).attr('data-order'),
                id = $(this).attr('data-id'),
                language = $(this).attr('data-language'),
                type = $(this).attr('data-type');
            //$('#dir-title').val(title);
            $('#testt-question').val(question);
            $('#testt-course').val(course);
            $('#testt-order').val(order);
            $('#testt-language').val(language);
            $('#testt-type').val(type);
            console.log(question);

            var m=UIkit.modal('#modal_edit_test');
            if ( m.isActive() ) {
                m.hide();
            } else {
                m.show();
            }
            $('#saveTestEdit').click(function(){
                //data['id'] = 500;
                var data=$('#formTestEdit').serialize();

                console.log('data attr');
                //var id = $(this).attr('data-id');

                $.post('/reference/test/edit/'+id,{data:data},function(response){
                    console.log(response);

                    if(response.status == 'successEditLoad'){

                        $('#modal_edit_test').hide();
                        window.location.reload();
                        //here show notification success
                        var m={message:"Information successfully updated",status:"data.status"};
                        Muxr.showNotify(m);

                    }
                    $('#modal_edit_test').unbind();


                });

            });
        });
    },
    //-----------------------------Answer ---------------------------------------------------//
    saveAnswer:function(){
        $('#saveAnswer').click(function(){
            if($('#AnswerEdit')){
                console.log('bor');
            }

            var data=$('#formAnswer').serialize();

            $.post('/reference/answer/save',{data:data},function(response){
                console.log(data);
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_answer').hide();

                    UIkit.modal('#modal_notificationAnswer').show();
                    $('#modal_add_answer').unbind();
                    $('#modal_notificationAnswer').unbind();

                }
                else{

                }
            });

        });

    },
    openClearedAnswer:function(){
        $('#addAnotherAnswer').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationAnswer').hide();

            $("#formAnswer")[0].reset();
            UIkit.modal('#modal_add_answer').show();


            $('#modal_add_answer').unbind();
            $('#modal_notificationAnswer').unbind();
            $('.uk-close').unbind();
        });
    },
    openAnswerForm:function(){
        console.log('sss');
        $("#modal_add_answer_btn").click(function(){
            var m=UIkit.modal('#modal_add_answer');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
            $("#modal_add_answer").hide();
        });
    },
    openEditAnswerForm:function(){
        var id;
        $(".modal-edit-answer").click(function(){

            var test = $(this).attr('data-test'),
                answer = $(this).attr('data-answer'),
                right = $(this).attr('data-right'),
                id = $(this).attr('data-id');
            //$('#dir-title').val(title);
            $('#an-test').val(test);
            $('#an-answer').val(answer);
            $('#an-right').val(right);

            console.log(test);

            var m=UIkit.modal('#modal_edit_answer');
            if ( m.isActive() ) {
                m.hide();
            } else {
                m.show();
            }
            $('#saveAnswerEdit').click(function(){
                //data['id'] = 500;
                var data=$('#formAnswerEdit').serialize();

                console.log('data attr');
                //var id = $(this).attr('data-id');

                $.post('/reference/answer/edit/'+id,{data:data},function(response){
                    console.log(response);

                    if(response.status == 'successEditLoad'){

                        $('#modal_edit_answer').hide();
                        window.location.reload();
                        //here show notification success
                        var m={message:"Information successfully updated",status:"data.status"};
                        Muxr.showNotify(m);

                    }
                    $('#modal_edit_answer').unbind();


                });

            });
        });
    },
    openDeleteAnswerForm:function(){
        $('.modal-delete-answer').click(function(){
            var pk=$(this).attr("data-id");
            var url='/reference/answer/delete/'+pk;
            swal({
                    title: "Вы уверены?",
                    text: "Вы не сможете восстановить эту информацию!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "md-btn md-btn-danger",
                    confirmButtonText: "Да, удалить!",
                    cancelButtonText: "Отмена",
                    closeOnConfirm: false
                },
                function(){
                    $.post(url,{id:pk},function(data){
                        if(data.status=="success"){
                            $("#row_"+pk).remove();
                            swal("Удален!", "Информация удален.", "success");
                        }else{
                            swal("Не удален!", "Информация не удален.", "error");
                        }
                    });

                });

        });
    },
    //----------------------------------------------------------------------------------------//
    editSpecialityStatus:function(){
        $('.modal-edit-statusspe').click(function(){
            var Sstatus = $(this).attr('data-id');

            //console.log(Sstatus);
            $.post('/reference/speciality/changestatus/'+Sstatus,{data:Sstatus},function(response){
                    console.log(response.status);
                    if(response.status == 'statusChanged'){
                        console.log(response.status);
                        window.location.reload();
                    }
                    
                     
                
            });
        });
    },
  saveDocument:function(){
      $('#savedoc').click(function(){
          var data=$('#addDoc').serialize();
          $.post('/edoc/documents/save',{data:data},function(data){
                if(!data.error){
                    var m={message:data.message,status:data.status}

                    Muxr.showNotify(m);
                }else{
                    var m={message:data.error,status:'error'}
                    Muxr.showNotify(m);
                }


          });
          return false;
      });
  },
    saveUserInfo:function(){
      $('#saveUserInfo').click(function(){
          var data=$('#formUserInfo').serialize();
          $.post('/users/info/save',{data:data},function(data){
                if(!data.error){
                    var m={message:data.message,status:data.status}
                    Muxr.showNotify(m);
                }else{
                    var m={message:data.error,status:'error'}
                    Muxr.showNotify(m);
                }


          });
          return false;
      });
  },
    addSignToProfile:function(){
        $('#saveSignToProfile').click(function(){
            var select=$('#signDES').val();
            var data=$('#signDES').find('option:selected').attr('vo');
            var company=$('#companyId').val();
            $.post('/business/sign/add',{data:data,company:company},function(){

            });
        });

    },
    init:function(){

    },
    showNotify:function(t) {
        if (thisNotify = UIkit.notify({
                message: t.message ? t.message : "",
                status: t.status ? t.status: "",
                timeout: 5e3,
                group: t.group ? t.group : null,
                pos: "top-center",
                onClose: function () {

                }
            }), $window.width() < 768 && ("bottom-right" == thisNotify.options.pos || "bottom-left" == thisNotify.options.pos || "bottom-center" == thisNotify.options.pos) || "bottom-right" == thisNotify.options.pos) {
            var o = $(thisNotify.element).outerHeight(), i = $window.width() < 768 ? -6 : 8;
            $body.find(".md-fab-wrapper").css("margin-bottom", o + i)
        }
    },
    saveCompany:function(){
            $('#addCompany').click(function(){
                var data=$('#formCompany').serialize();
                $.post('/business/organizations/save',{data:data},function(data){
                    if(!data.error){
                        var m={message:data.message,status:data.status}
                        Muxr.showNotify(m);
                    }else{
                        var m={message:data.error,status:'error'}
                        Muxr.showNotify(m);
                    }


                });
                return false;
            });
        },
    saveTariff:function(){
        $('#saveTariff').click(function(){
            var data=$('#formTariff').serialize();
            $.post('/billing/tariffs/save',{data:data},function(data){
                if(!data.error){
                    var m={message:data.message,status:data.status}
                    Muxr.showNotify(m);
                }else{
                    var m={message:data.error,status:'error'}
                    Muxr.showNotify(m);
                }
            });
            return false;
        });
    },
    saveUser:function(){
     $('#saveUser').click(function(){
                var data=$('#formUser').serialize();
                $.post('/users/profile/save',{data:data},function(data){
                    if(!data.error){
                        var m={message:data.message,status:data.status}
                        Muxr.showNotify(m);
                    }else{
                        var m={message:data.error,status:'error'}
                        Muxr.showNotify(m);
                    }


                });
                return false;
            });   
    },
    addMessageSrc:function(){
        console.log('sss');
        $("#modal_add_btn").click(function(){
            var m=UIkit.modal('#modal_add');
            if ( m.isActive() ) {
                m.hide();
            } else {
                m.show();
            }
        });
    },
    
    

    openDirectionForm:function(){
        //console.log('sss');
        $("#modal_add_direction_btn").click(function(){
            var m=UIkit.modal('#modal_add_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_direction").hide();     
        });
    },
    openEditDirectionForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                //speciality = $(this).attr('data-speciality');
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            //$('#dir-speciality').val(speciality);
            $('#dir-short').val(short);
            
            //console.log("salom");
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
            //data['id'] = 500;
              var data=$('#formDirectionEdit').serialize();
              
              console.log('data attr Direction');
              //var id = $(this).attr('data-id');
                
                $.post('/reference/hudud/edit/'+id,{data:data},function(response){
                    //console.log(response);
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        
                        //$("#row_"+id).load();
                        //$('#row_'+id).load('#row_'+id);
                        //document.getElementByid
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                        //$("#row_"+id).remove();
                    }
                    $('#modal_edit_direction').unbind();
                
                
            });
               
        });
        });
    },

    openEditDrugForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log('data attr Direction');
                $.post('/settings/turi/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditHyturiForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/hyturi/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditColorForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/color/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditArrivalForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id'),
                count = $(this).attr('data-count'),
                vaksina = $(this).attr('data-value'),
                number = $(this).attr('data-number');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            $('#dir-count').val(count);
            $('#dir-value').val(vaksina);
            $('#dir-number').val(number);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/arrival/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditUnitForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/unit/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditVkturiForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                $.post('/settings/vkturi/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditKasturiForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                $.post('/settings/kasturi/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    $('#modal_edit_direction').unbind();
                });

            });
        });
    },

    openEditVaksinaForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                speciality = $(this).attr('data-speciality');
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-speciality').val(speciality);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/vaksina/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    else {
                        console.log(response);
                        $('#modal_edit_direction').unbind();
                    }
                });
            });
        });
    },

    openEditVaksinaForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                speciality = $(this).attr('data-speciality');
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-speciality').val(speciality);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/kasallik/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    else {
                        console.log(response);
                        $('#modal_edit_direction').unbind();
                    }
                });
            });
        });
    },

    openEditHayvonForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                speciality = $(this).attr('data-speciality');
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-speciality').val(speciality);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/hayvon/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    else {
                        console.log(response);
                        $('#modal_edit_direction').unbind();
                    }
                });
            });
        });
    },

    openEditUnitmeaForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                speciality = $(this).attr('data-speciality');
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-speciality').val(speciality);
            $('#dir-short').val(short);
            var m=UIkit.modal('#modal_edit_direction');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveDirectionEdit').click(function(){
                var data=$('#formDirectionEdit').serialize();
                console.log(data);
                $.post('/settings/unitmea/edit/'+id,{data:data},function(response){
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        $('#modal_edit_direction').hide();
                        window.location.reload();
                    }
                    else {
                        console.log(response);
                        $('#modal_edit_direction').unbind();
                    }
                });
            });
        });
    },

    editDirectionStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/tuman/changestatus/'+Mstatus,{data:Mstatus},function(response){
                    
                    if(response.status == 'statusChanged'){
                        console.log(response.status);
                        window.location.reload();
                    }
            });
        });
    },

    editHududStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reference/hudud/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editVaksinaStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/vaksina/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editKasallikStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/kasallik/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editHayvonStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/hayvon/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editUnitmeaStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/unitmea/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editDrugStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/turi/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editHyturiStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/hyturi/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editColorStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/color/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editPrixodStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/arrival/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editUnitStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/unit/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editVkturiStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/vkturi/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    editKasturiStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/settings/kasturi/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    openDeleteDirectionForm:function(){
    //     $('.modal-delete-direction').click(function(){
    //     var pk=$(this).attr("data-id");
    //     var url='/reference/direction/delete/'+pk;
    //     swal({
    //             title: "Вы уверены?",
    //             text: "Вы не сможете восстановить эту информацию!",
    //             type: "warning",
    //             showCancelButton: true,
    //             confirmButtonClass: "md-btn md-btn-danger",
    //             confirmButtonText: "Да, удалить!",
    //             cancelButtonText: "Отмена",
    //             closeOnConfirm: false
    //         },
    //         function(){
    //             $.post(url,{id:pk},function(data){
    //                 if(data.status=="success"){
    //                     $("#row_"+pk).remove();
    //                     swal("Удален!", "Информация удален.", "success");
    //                 }else{
    //                     swal("Не удален!", "Информация не удален.", "error");
    //                 }
    //             });
    //
    //         });
    //
    // });
    },
    saveDirection:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
          var rus = $("#tuman-name_ru").val();
          var uzb = $("#tuman-name_uz").val();
          var tuman = $("#tuman-viloyat_id").val();
            $.post('/settings/tuman/save',{rus:rus, uzb:uzb, tuman:tuman},function(response){
                //console.log(data);
                if(response=='success'){
                    window.location.reload();
                    UIkit.modal('#modal_add_direction').hide();
                }
                else{
                    UIkit.modal.alert("Error!");
                }
            }
            );
        });
    },

    saveHudud:function(){
        $('#saveDirection').click(function(){
            var data=$('#formDirection').serialize();

            $.post('/reference/hudud/save',{data:data},function(response){
                    //console.log(rus);
                    if(response.status=='success'){
                        window.location.reload();
                        //UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response.status);
                        //console.log(response);
                    }
                }
            );

        });
    },

    saveVaksina:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var data=$('#formDirection').serialize();

            $.post('/settings/vaksina/save',{data:data},function(response){
                    if(response.status=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response.status);
                    }
                }
            );
        });
    },

    savePreparat:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var data=$('#formDirection').serialize();
            window.amountSold = 0;
                $("#formDirection").find("[type=text], textarea").each(function(){
                    if (!$(this).val().length) {
                        window.amountSold += 1;
                        return false;
                    }
                });
            if (window.amountSold==0)  {
            $.post('/preparat/save',{data:data},function(response){
                    if(response.status=='success'){
                        // window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                        console.log(response.id);
                        UIkit.modal('#modal_notificationVkViloyat').show();
                        $('#modal_add_direction').unbind();
                        $('#modal_notificationVkViloyat').unbind();
                    }
                    else{
                        console.log(response.status);
                        UIkit.modal.alert(response.status);
                    }
                }
            );
            }
            else UIkit.modal.alert("Заполните пожалуйста все поля!");
        });
    },

    saveKasallik:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#kasal-name_ru").val();
            var uzb = $("#kasal-name_uz").val();
            var tuman = $("#kasal-kasal_id").val();
            $.post('/settings/kasallik/save',{rus:rus, uzb:uzb, vaksina:tuman},function(response){
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert("Error!");
                    }
                }
            );
        });
    },

    saveHayvon:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#hayvon-name_ru").val();
            var uzb = $("#hayvon-name_uz").val();
            var tuman = $("#hayvon-hayvon_turi_id").val();
            var rang = $("#hayvon-rang_id").val();
            $.post('/settings/hayvon/save',{rus:rus, uzb:uzb, vaksina:tuman, color:rang},function(response){
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert("Error!");
                    }
                }
            );
        });
    },

    saveUnitMea:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#unitmeasure-name_ru").val();
            var uzb = $("#unitmeasure-name_uz").val();
            var tuman = $("#unitmeasure-unit_id").val();
            $.post('/settings/unitmea/save',{rus:rus, uzb:uzb, vaksina:tuman},function(response){
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert("Error!");
                    }
                }
            );
        });
    },

    saveDrugTuri:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#drugturi-name_ru").val();
            var uzb = $("#drugturi-name_uz").val();
            console.log(uzb);
            $.post('/settings/turi/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    saveHyturi:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#hayvonturi-name_ru").val();
            var uzb = $("#hayvonturi-name_uz").val();
            console.log(uzb);
            $.post('/settings/hyturi/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    saveColor:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#hayvonrangi-name_ru").val();
            var uzb = $("#hayvonrangi-name_uz").val();
            console.log(uzb);
            $.post('/settings/color/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    savePrixod:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var data=$('#formDirection').serialize();

            $.post('/settings/arrival/save',{data:data},function(response){
                    //console.log(rus);
                    if(response.status=='success'){
                        window.location.reload();
                        //UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response.status);
                        //console.log(response);
                    }
                }
            );

        });
    },

    dynamicFields: function(e, i, a) {
        function t(e, i, a) {
            var t = $("#" + i).html()
                , n = Handlebars.compile(t)({
                index: a || 0,
                counter: a ? "__" + a : "__0"
            });
            e.append(n)
                // altair_md.inputs(e),
                // altair_md.checkbox_radio(e.find("[data-md-icheck]")),
                // altair_forms.switches(e),
                // altair_forms.select_elements(e)
        }
        (e ? $(e).find("[data-dynamic-fields]") : $("[data-dynamic-fields]")).each(function() {
            var e = $(this).attr("dynamic-fields-counter", 0)
                , n = e.data("dynamicFields");
            a || t(e, n),
                e.on("click", ".btnSectionClone", function(a) {
                    a.preventDefault(),
                        e.find(".btnSectionClone").replaceWith('<a href="#" class="btnSectionRemove"><i class="material-icons md-24">&#xE872;</i></a>');
                    var s = parseInt(e.attr("dynamic-fields-counter")) + 1;
                    e.attr("dynamic-fields-counter", s),
                        t(e, n, s),
                    i && $window.resize()
                }).on("click", ".btnSectionRemove", function(e) {
                    e.preventDefault(),
                        $(this).closest(".form_section").next(".form_hr").remove().end().remove(),
                    i && $window.resize()
                })
        })
    },

    saveArrival:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#prixod-name_ru").val();
            var uzb = $("#prixod-name_uz").val();
            console.log(uzb);
            $.post('/settings/color/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    saveUnit:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#unit-name_ru").val();
            var uzb = $("#unit-name_uz").val();
            console.log(uzb);
            $.post('/settings/unit/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    saveVkTuri:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#vaksinaturi-name_ru").val();
            var uzb = $("#vaksinaturi-name_uz").val();
            console.log(uzb);
            $.post('/settings/vkturi/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    saveKasalTuri:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var rus = $("#kasalturi-name_ru").val();
            var uzb = $("#kasalturi-name_uz").val();
            console.log(uzb);
            $.post('/settings/kasturi/save',{rus:rus, uzb:uzb},function(response){
                    console.log(rus);
                    if(response=='success'){
                        window.location.reload();
                        UIkit.modal('#modal_add_direction').hide();
                    }
                    else{
                        UIkit.modal.alert(response);
                        //console.log(response);
                    }
                }
            );

        });
    },

    openClearedPreparat:function(){
        $('#addAnotherVkViloyat').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationVkViloyat').hide();

            $("#formVkViloyat")[0].reset();
            UIkit.modal('#modal_add_direction').show();


            $('#modal_add_direction').unbind();
            $('#modal_notificationVkViloyat').unbind();
            $('.uk-close').unbind();
        });
    },

    openClearedDirection:function(){
        $('#addAnotherDirection').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationDirection').hide(); 
            
            $("#formDirection")[0].reset();
            UIkit.modal('#modal_add_direction').show();
            
            
            $('#modal_add_direction').unbind();  
            $('#modal_notificationDirection').unbind();
            $('.uk-close').unbind();  
        });
    },
    // --------------  Subject ajax code goes here --------------------------------------//
    changeDropDownSubject:function(){
        $("#dir-direct").change(function(){
            var $option = $(this).find('option:selected');
            var value = $option.val();//to get content of "value" attrib
            $.post('/reference/subject/directionlist/'+value,{data:value},function(response){
                    //console.log(response);
                   $('#dir-direction').children().remove();
                    for (var i in response) {
                        console.log(i);
                        var inp = "<option value='"+response[i].id+"'>"+response[i].title+"</option>";
                        $('#dir-direction').append(inp);
                    }
            });
        });
        $("#dir-directt").change(function(){
            var $option = $(this).find('option:selected');
            var value = $option.val();//to get content of "value" attrib
            $.post('/reference/subject/directionlist/'+value,{data:value},function(response){
                //console.log(response);
                $('#dir-directiont').children().remove();
                for (var i in response) {
                    console.log(i);
                    var inp = "<option value='"+response[i].id+"'>"+response[i].title+"</option>";
                    $('#dir-directiont').append(inp);
                }
            });
        });
    },
    openSubjectForm:function(){
        console.log('sss');
        $("#modal_add_subject_btn").click(function(){
            var m=UIkit.modal('#modal_add_subject');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_subject").hide();     
        });
    },
    openEditSubjectForm:function(){
        var id;
        $(".modal-edit-subject").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                direct = $(this).attr('data-direct');
                id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-short').val(short);
            $('#dir-direct').val(direct);
            

            var m=UIkit.modal('#modal_edit_subject');
            if ( m.isActive() ) {
                m.hide();

                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveSubjectEdit').click(function(){
            //data['id'] = 500;
          var data=$('#formSubjectEdit').serialize();
          
          console.log('data attr');
          //var id = $(this).attr('data-id');
            
            $.post('/reference/subject/edit/'+id,{data:data},function(response){
                    console.log(response);
                
                if(response.status == 'successEditLoad'){
                    
                     $('#modal_edit_subject').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    
                }
                $('#modal_edit_subject').unbind();
                
                
            });
                
        });
        });
    },
    openDeleteSubjectForm:function(){
        $('.modal-delete-subject').click(function(){
        var pk=$(this).attr("data-id");
        var url='/reference/subject/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    saveSubject:function(){
        $('#saveSubject').click(function(){
            if($('#subjectEdit')){
                console.log('bor');
            }
            
          var data=$('#formSubject').serialize();

            $.post('/reference/subject/save',{data:data},function(response){
                console.log(data);
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_subject').hide();

                     UIkit.modal('#modal_notificationSubject').show();
                     $('#modal_add_subject').unbind();
                     $('#modal_notificationSubject').unbind();
                     
                }
                else{
                    
                }
            });

        });
        
    },
    openClearedSubject:function(){
        $('#addAnotherSubject').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationSubject').hide(); 
            
            $("#formSubject")[0].reset();
            UIkit.modal('#modal_add_subject').show();
            
            
            $('#modal_add_subject').unbind();  
            $('#modal_notificationSubject').unbind();
            $('.uk-close').unbind();  
        });
    },
    editSubjectStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reference/subject/changestatus/'+Mstatus,{data:Mstatus},function(response){
                    
                    if(response.status == 'statusChanged'){
                        console.log(response.status);
                        window.location.reload();
                    }
                    
                     
                
            });
        });
    },


    //-----------------Video ----------------------------------------------------------------//
    openVideoForm:function(){
        console.log('sss');
        $("#modal_add_video_btn").click(function(){
            var m=UIkit.modal('#modal_add_video');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_video").hide();     
        });
    },
    openEditVideoForm:function(){
        var id;
        $(".modal-edit-video").click(function(){
            var title = $(this).attr('data-title'),
                slug = $(this).attr('data-slug'),
                fan = $(this).attr('data-fan');
                id = $(this).attr('data-id');
            $('#vid-title').val(title);
            $('#vid-fan').val(fan);
            $('#vid-short').val('status');
            $('#vid-slug').val(slug);
            

            var m=UIkit.modal('#modal_edit_video');
            if ( m.isActive() ) {
                m.hide();

                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveVideoEdit').click(function(){
            //data['id'] = 500;
          var data=$('#formVideoEdit').serialize();
          
          console.log('data attr');
          //var id = $(this).attr('data-id');
            
            $.post('/video/default/edit/'+id,{data:data},function(response){
                    console.log(response.status);
                
                if(response.status == 'successEditLoad'){
                    
                    //$("#row_"+id).load();
                    //$('#row_'+id).load('#row_'+id);
                    //document.getElementByid
                    $('#modal_edit_video').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    //$("#row_"+id).remove();
                }
                $('#modal_edit_video').unbind();
                
                
            });
              
        });
        });
    },
    openDeleteVideoForm:function(){
        $('.modal-delete-video').click(function(){
        var pk=$(this).attr("data-id");
        var url='/video/default/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    saveVideo:function(){
        $('#saveVideo').click(function(){
            if($('#videoEdit')){
                console.log('bor');
            }
            
          var data=$('#formVideo').serialize();

            $.post('/video/default/save',{data:data},function(response){
                
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_video').hide();

                     UIkit.modal('#modal_notificationVideo').show();
                     $('#modal_add_video').unbind();
                     $('#modal_notificationVideo').unbind();
                     
                }
                else{
                    
                }
            });

        });
        
    },
    openClearedVideo:function(){
        $('#addAnotherVideo').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationVideo').hide(); 
            
            $("#formVideo")[0].reset();
            UIkit.modal('#modal_add_video').show();
            
            
            $('#modal_add_video').unbind();  
            $('#modal_notificationVideo').unbind();
            $('.uk-close').unbind();  
        });
    },
    //------------------------- Speciality--------------------------------------------------------//
    openEditSpecialityForm:function(){
        var id;
        $(".modal-edit-speciality").click(function(){
            console.log('modal-edit-speciality clicked');
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                id = $(this).attr('data-id');
            $('#spe-title').val(title);
            $('#spe-short').val(short);
            

            var m=UIkit.modal('#modal_edit_speciality');
            if ( m.isActive() ) {
                m.hide();

                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveSpecialityEdit').click(function(){
            //data['id'] = 500;
          var data=$('#formSpecialityEdit').serialize();
          
          console.log('data attr speciality');
          //var id = $(this).attr('data-id');
            
            $.post('/reference/speciality/edit/'+id,{data:data},function(response){
                    console.log(response.status);
                
                if(response.status == 'successEditLoad'){
                    
                    //$("#row_"+id).load();
                    //$('#row_'+id).load('#row_'+id);
                    //document.getElementByid
                    $('#modal_edit_speciality').hide();
                    window.location.reload();
                    //here show notification success
                    var m={message:"Information successfully updated",status:"data.status"};
                      Muxr.showNotify(m);  
                    //$("#row_"+id).remove();
                }
                $('#modal_edit_speciality').unbind();
                
                
            });
                // $.post('/reference/subject/',{id:id},function(data){
                //     if(data.status=="successEditLoad"){
                //         $("#row_"+id).reload();
                //         //swal("Удален!", "Информация удален.", "success");
                //     }else{
                //         //swal("Не удален!", "Информация не удален.", "error");
                //     }
                // });

            // $('.uk-close').unbind();
            // $('#modal_edit_subject').unbind();
        });
        });
    },
    saveSpeciality:function(){
        $('#saveSpeciality').click(function(){
            console.log('tac');
          var data=$('#formSpeciality').serialize();

            $.post('/reference/speciality/save',{data:data},function(response){
                
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_speciality').hide();

                     UIkit.modal('#modal_notificationSpeciality').show();
                     $('#modal_add_speciality').unbind();
                     $('#modal_notificationSpeciality').unbind();
                }
                else{
                    
                }
            });
        });
    },
    openClearedSpeciality:function(){
        $('#addAnotherSpeciality').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationSpeciality').hide(); 
            
            $("#formSpeciality")[0].reset();
            UIkit.modal('#modal_add_speciality').show();
            $('#modal_add_speciality').unbind();  
            $('#modal_notificationSpeciality').unbind();  
        });
    },
    openSpecialityForm:function(){
        console.log('sss');
        $("#modal_add_speciality_btn").click(function(){
            var m=UIkit.modal('#modal_add_speciality');
            if ( m.isActive() ) {
                m.hide();
            } else {
                m.show();
            }
        });
    },
    
    openDeleteSpecialityForm:function(){
        $('.modal-delete-speciality').click(function(){
        var pk=$(this).attr("data-id");
        var url='/reference/speciality/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    

    saveMessageSrc:function(){
        $('#saveMessageSrc').click(function(){
            var cat=$('#catListn').val();
            var message=$('#srcMessagen').val();
            $.post('/reference/translation/save',{category:cat,message:message},function(response){
                if(response.status=='success'){
                    UIkit.modal('#modal_add').hide();
                }
            });
        });
    },
    
    
    
    savePayment:function(){
     $('#savePayment').click(function(){
                var data=$('#formPayment').serialize();
                $.post('/billing/payment/save',{data:data},function(data){
                    if(!data.error){
                        var m={message:data.message,status:data.status}
                        Muxr.showNotify(m);
                    }else{
                        var m={message:data.error,status:'error'}
                        Muxr.showNotify(m);
                    }


                });
                return false;
            });
    },
    addTranslation:function(){
        $('.addTranslation').click(function(){
            $('#langList').val(false);
            $('#srcTranslation').val("");
            $('#pk').val(false);
            var modal=UIkit.modal('#modal_add_translation');
            var pk=$(this).attr('data-pk');
            $('#pk').val(pk);
            modal.show();
        });
    },
    saveTranslation:function(){
        $('#saveMessage').click(function(){
            var id=$('#pk').val();
            var language=$('#langList').val();
            var message=$('#srcTranslation').val();
            $.post('/reference/translation/addtranslation',{language:language,translation:message,id:id},function(response){
                    console.log(response);
                    if (response=='ok'){
                        window.location.reload();
                    }
            });
        });
    },
    editTranslation:function(){
        $('.editTranslation').click(function(){
            var id=$(this).attr('data-pk');
            var lang=$(this).attr('data-lang');
            var translation=$(this).attr('data-translation');
            $('#pk').val(id);
            $('#langList').val(lang);
            $('#srcTranslation').val(translation);
            var modal = UIkit.modal("#modal_add_translation");
            if ( modal.isActive() ) {
                modal.hide();
            } else {
                modal.show();
            }
        });
    },
    editMessage:function(){
        $('.editMessage').click(function(){
            var modal = UIkit.modal("#modal_update");
            if ( modal.isActive() ) {
                modal.hide();
            } else {
                modal.show();
            }
            var id=$(this).attr('data-pk');
            var cat=$(this).attr('data-cat');
            var message=$(this).attr('data-message');
            $('#ucatList').val(cat);
            $('#usrcMessage').val(message);
            $('#messagePk').val(id);

        });
    },
    deleteMessage:function(){
       $('.deleteMessage').click(function(){
        var pk=$(this).attr("data-pk");
        var url='/reference/translation/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    deletePayment:function(){
        $('.deletePayment').click(function(){
            var pk=$(this).attr("data-pk");
            var url='/billing/payment/delete/'+pk;
            swal({
                    title: "Вы уверены?",
                    text: "Вы не сможете восстановить эту информацию!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "md-btn md-btn-danger",
                    confirmButtonText: "Да, удалить!",
                    cancelButtonText: "Отмена",
                    closeOnConfirm: false
                },
                function(){
                    $.post(url,{id:pk},function(data){
                        if(data=="success"){
                            $("#row_"+pk).remove();
                            swal("Удален!", "Информация удален.", "success");
                        }else{
                            swal("Не удален!", "Информация не удален.", "error");
                        }
                    });

                });

        });
    },
    buyTariff:function(){
        $('.buyBtn').click(function(){
            var pk=$(this).attr("data-pk");
            var company=$(this).attr("data-company");
            swal({
                    title: "Вы уверены?",
                    text: "Вы не сможете восстановить эту информацию!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "md-btn md-btn-danger",
                    confirmButtonText: "Да, Утвердить платеж!",
                    cancelButtonText: "Отмена",
                    closeOnConfirm: false
                },
                function(){
                    $.post("/business/tariff/buy/",{id:pk,company:company},function(data){
                        if(data=="success"){
                            swal("Удален!", "Утверждена.", "success");
                            window.location.reload();
                        }else{
                            swal("Не удален!", "Информация не удален.", "error");
                        }
                    });

                });

        });
    },
    approvePayment:function(){
        $('.approvePayment').click(function(){
            var pk=$(this).attr("data-pk");
            var url='/billing/payment/approve/'+pk;
            swal({
                    title: "Вы уверены?",
                    text: "Вы не сможете восстановить эту информацию!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "md-btn md-btn-danger",
                    confirmButtonText: "Да, Утвердить платеж!",
                    cancelButtonText: "Отмена",
                    closeOnConfirm: false
                },
                function(){
                    $.post(url,{id:pk},function(data){
                        if(data=="success"){
                            swal("Удален!", "Утверждена.", "success");
                            window.location.reload();
                        }else{
                            swal("Не удален!", "Информация не удален.", "error");
                        }
                    });

                });

        });
    },
    deleteCompanyType:function(){
       $('.deleteType').click(function(){
        var pk=$(this).attr("data-pk");
        var url='/reference/companytype/delete/'+pk;
        swal({
                title: "Вы уверены?",
                text: "Вы не сможете восстановить эту информацию!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk,_csrf:"' . Yii::$app->request->getCsrfToken() . '"},function(data){
                    if(data=="success"){
                        $("#row_"+pk).remove();
                        swal("Удален!", "Информация удален.", "success");
                    }else{
                        swal("Не удален!", "Информация не удален.", "error");
                    }
                });

            });

    });
    },
    userEditInit:function(){
        Muxr.user_edit_form();
        Muxr.user_groups();
    },
    user_edit_form: function() {
        // form variables
        var $user_edit_form = $('#user_edit_form'),
            $user_edit_submit_btn = $('#user_edit_submit'),
            user_name = $('#user_edit_uname'),
            user_name_control= $('#user_edit_uname_control'),
            user_position = $('#user_edit_position'),
            user_position_control = $('#user_edit_position_control');

        user_name_control
        // insert user name into form input
            .val(user_name.text())
            // change user name on keyup
            .on('keyup',function() {
                user_name.text(user_name_control.val())
            });
        // update inputs
        unibox_md.update_input(user_name_control);


        user_position_control
        // insert user position into form input
            .val(user_position.text())
            // change user position on keyup
            .on('keyup',function() {
                user_position.text(user_position_control.val())
            });
        // update inputs
        unibox_md.update_input(user_position_control);

        // submit form
        $user_edit_submit_btn.on('click',function(e) {
            e.preventDefault();
            var form_serialized = JSON.stringify( $user_edit_form.serializeObject(), null, 2 );
            UIkit.modal.alert('<p>User data:</p><pre>' + form_serialized + '</pre>');
        })
    },
    user_groups: function() {

        var $user_groups = $('#user_groups'),
            $all_groups = $('#all_groups'),
            $user_groups_control = $('#user_groups_control'),
            serialize_user_group = function() {
                var serialized_data = $user_groups.data("sortable").serialize();
                $user_groups_control.val( JSON.stringify(serialized_data) );
            };


        var sortable_user_groups = UIkit.sortable($user_groups, {
            group: '.groups_connected',
            handleClass: 'sortable-handler'
        });

        UIkit.sortable($all_groups, {
            group: '.groups_connected',
            handleClass: 'sortable-handler'
        });

        // serialize user group on change
        $user_groups.on('change.uk.sortable',function() {
            serialize_user_group();
        });

        // serialize group on init
        serialize_user_group();

    },
    saveCompanyType:function(){
        $('#saveCompanyType').click(function(){
            var id=$('#pk').val();
            var name=$('#typeName').val();
            var message=$('#typeDesc').val();
            var status=$('#typeStatus').val();
            $.post('/reference/companytype/save',{name:name,description:message,status:status},function(data){
                var modal = UIkit.modal("#modal_add");
                if ( modal.isActive() ) {
                    modal.hide();
                } else {
                    modal.show();
                }
                if(!data.error){
                    var m={message:data.message,status:data.status}
                    Muxr.showNotify(m);
                }else{
                    var m={message:data.error,status:'error'}
                    Muxr.showNotify(m);
                }
            });
        });
    },
    updateCompanyType:function(){
        $('.editType').click(function(){
            var name=$(this).attr('data-name');
            var status=$(this).attr('data-status');
            var description=$(this).attr('data-desc');
            var pk=$(this).attr('data-pk');
            $('#typeStatus').val(status);
            $('#typeName').val(name);
            $('#typeDesc').val(description);
            $('#typePk').val(pk);
            var modal = UIkit.modal("#modal_add");
            if ( modal.isActive() ) {
                modal.hide();
            } else {
                modal.show();
            }
        });
    },
    register:function(){
       var  $active_card = $('#activate'),
         activate_show = function() {
            $active_card
                .show()
                .siblings()
                .hide();
        };
        $('#registerBtn').click(function(){
            var data=$('#register-form').serialize();
            $.post('/users/auth/register',{data:data},function(data){
                if(data.status=='success'){
                    $('#regUserId').val(data.user);
                    unibox_md.card_show_hide($login_card,undefined,activate_show,undefined);
                }
            });
            return false;
        });
        $("#sendActivationCode").click(function(){
            var data=$('#activeNumber').val();
            var user=$('#regUserId').val();
            $.post('/users/auth/activation',{number:data,user:user},function(data){
                if(data.status=='success'){
                    unibox_md.card_show_hide($login_card,undefined,activate_show,undefined);
                }
            });
            return false;
        });
    },
    masked_inputs: function() {
        $maskedInput = $('.masked_input');
        $login_mask=$('#loginform-phone');

        if($maskedInput.length) {
            $maskedInput.inputmask();
        }
        if($login_mask.length) {
            $login_mask.inputmask();
        }
    },
    char_words_counter: function() {
        var $imputCount = $('.input-count');
        if($imputCount.length) {
            (function($){"use strict";$.fn.extend({counter:function(options){var defaults={type:"char",count:"down",goal:140,text:true,target:false,append:true,translation:"",msg:"",container_class:""};var $countObj="",countIndex="",noLimit=false,options=$.extend({},defaults,options);var methods={init:function($obj){var objID=$obj.attr("id"),counterID=objID+"_count";methods.isLimitless();$countObj=$("<span id="+counterID+"/>");var counterDiv=$("<div/>").attr("id",objID+"_counter").append($countObj).append(" "+methods.setMsg());if(options.container_class&&options.container_class.length){counterDiv.addClass(options.container_class)}if(!options.target||!$(options.target).length){options.append?counterDiv.insertAfter($obj):counterDiv.insertBefore($obj)}else{options.append?$(options.target).append(counterDiv):$(options.target).prepend(counterDiv)}methods.bind($obj)},bind:function($obj){$obj.bind("keypress.counter keydown.counter keyup.counter blur.counter focus.counter change.counter paste.counter",methods.updateCounter);$obj.bind("keydown.counter",methods.doStopTyping);$obj.trigger("keydown")},isLimitless:function(){if(options.goal==="sky"){options.count="up";noLimit=true;return noLimit}},setMsg:function(){if(options.msg!==""){return options.msg}if(options.text===false){return""}if(noLimit){if(options.msg!==""){return options.msg}else{return""}}this.text=options.translation||"character word left max";this.text=this.text.split(" ");this.chars="s ( )".split(" ");this.msg=null;switch(options.type){case"char":if(options.count===defaults.count&&options.text){this.msg=this.text[0]+this.chars[1]+this.chars[0]+this.chars[2]+" "+this.text[2]}else if(options.count==="up"&&options.text){this.msg=this.text[0]+this.chars[0]+" "+this.chars[1]+options.goal+" "+this.text[3]+this.chars[2]}break;case"word":if(options.count===defaults.count&&options.text){this.msg=this.text[1]+this.chars[1]+this.chars[0]+this.chars[2]+" "+this.text[2]}else if(options.count==="up"&&options.text){this.msg=this.text[1]+this.chars[1]+this.chars[0]+this.chars[2]+" "+this.chars[1]+options.goal+" "+this.text[3]+this.chars[2]}break;default:}return this.msg},getWords:function(val){if(val!==""){return $.trim(val).replace(/\s+/g," ").split(" ").length}else{return 0}},updateCounter:function(e){var $this=$(this);if(countIndex<0||countIndex>options.goal){methods.passedGoal($this)}if(options.type===defaults.type){if(options.count===defaults.count){countIndex=options.goal-$this.val().length;if(countIndex<=0){$countObj.text("0")}else{$countObj.text(countIndex)}}else if(options.count==="up"){countIndex=$this.val().length;$countObj.text(countIndex)}}else if(options.type==="word"){if(options.count===defaults.count){countIndex=methods.getWords($this.val());if(countIndex<=options.goal){countIndex=options.goal-countIndex;$countObj.text(countIndex)}else{$countObj.text("0")}}else if(options.count==="up"){countIndex=methods.getWords($this.val());$countObj.text(countIndex)}}return},doStopTyping:function(e){var keys=[46,8,9,35,36,37,38,39,40,32];if(methods.isGoalReached(e)){if(e.keyCode!==keys[0]&&e.keyCode!==keys[1]&&e.keyCode!==keys[2]&&e.keyCode!==keys[3]&&e.keyCode!==keys[4]&&e.keyCode!==keys[5]&&e.keyCode!==keys[6]&&e.keyCode!==keys[7]&&e.keyCode!==keys[8]){if(options.type===defaults.type){return false}else if(e.keyCode!==keys[9]&&e.keyCode!==keys[1]&&options.type!=defaults.type){return true}else{return false}}}},isGoalReached:function(e,_goal){if(noLimit){return false}if(options.count===defaults.count){_goal=0;return countIndex<=_goal?true:false}else{_goal=options.goal;return countIndex>=_goal?true:false}},wordStrip:function(numOfWords,text){var wordCount=text.replace(/\s+/g," ").split(" ").length;text=$.trim(text);if(numOfWords<=0||numOfWords===wordCount){return text}else{text=$.trim(text).split(" ");text.splice(numOfWords,wordCount,"");return $.trim(text.join(" "))}},passedGoal:function($obj){var userInput=$obj.val();if(options.type==="word"){$obj.val(methods.wordStrip(options.goal,userInput))}if(options.type==="char"){$obj.val(userInput.substring(0,options.goal))}if(options.type==="down"){$countObj.val("0")}if(options.type==="up"){$countObj.val(options.goal)}}};return this.each(function(){methods.init($(this))})}})})(jQuery);

            $imputCount.each(function() {
                var $this = $(this);

                var $thisGoal = $(this).attr('maxlength') ? $(this).attr('maxlength') : 80 ;

                $this.counter({
                    container_class: 'text-count-wrapper',
                    msg: ' / '+$thisGoal,
                    goal: $thisGoal,
                    count: 'up'
                });

                if($this.closest('.md-input-wrapper').length) {
                    $this.closest('.md-input-wrapper').addClass('md-input-wrapper-count')
                }
            })
        }
    },
    important_control:function() {
        $('.setImportant').click(function () {
            var id = $(this).attr('data-pk');
            $.post('/edoc/documents/imp', {id: id, act: 'set'}, function (data) {
                if(data.status=='success'){
                    window.location.reload();
                }
            });
        });
        $('.removeImportant').click(function () {
            var id = $(this).attr('data-pk');
            $.post('/edoc/documents/imp', {id: id, act: 'del'}, function (data) {
                if(data.status=='success'){
                    window.location.reload();
                }
            });
        });
    },
    fileUpload:function(){
        var progressbar = $("#file_upload-progressbar"),
            bar         = progressbar.find('.uk-progress-bar'),
            settings    = {
                action: '/filemanager/downloads/documents',
                allow : '*.(jpg|jpeg|png|pdf|doc|docx)',
                loadstart: function() {
                    bar.css("width", "0%").text("0%");
                    progressbar.removeClass("uk-hidden");
                },
                progress: function(percent) {
                    percent = Math.ceil(percent);
                    bar.css("width", percent+"%").text(percent+"%");
                },
                complete:function(response,xhr){
                    response= $.parseJSON(response);

                    UIkit.notify({
                        message: "Upload Completed",
                        pos: 'top-right'
                    });
                    $("#fileupload").val(response.file);
                },
                allcomplete: function(response,xhr) {
                    bar.css("width", "100%").text("100%");
                    setTimeout(function(){
                        progressbar.addClass("uk-hidden");
                    }, 250);
                    setTimeout(function() {
                        UIkit.notify({
                            message: "Upload Completed",
                            pos: 'top-right'
                        });
                    },280);
                }
            };

        var select = UIkit.uploadSelect($("#file_upload-select"), settings),
            drop   = UIkit.uploadDrop($("#file_upload-drop"), settings);

    },
    saveSourceMessage:function(){

        $('#saveSourceMessage').click(function(){
            var cat=$('#catList').val();
            var message=$('#srcMessage').val();
            $.post('/reference/translation/save',{category:cat,message:message},function(response){
                if(response.status=='success'){
                    UIkit.modal('#modal_add').hide();
                }
            });
        });
    },
    stay_idle:function(){
        // append modal to <body>
        $body.append('<div class="uk-modal" id="modal_idle">' +
            '<div class="uk-modal-dialog">' +
            '<div class="uk-modal-header">' +
            '<h3 class="uk-modal-title">Ваша сессия истекает!</h3>' +
            '</div>' +
            '<p>Вы были неактивны некоторое время. В целях безопасности мы автоматически выйдем из системы.</p>' +
            '<p>Нажмите кнопку "оставаться в сети", чтобы продолжить сеанс.</p>' +
            '<p>Срок действия сеанса истекает в <span class="uk-text-bold md-color-red-500" id="sessionSecondsRemaining"></span> секунды.</p>' +
            '<div class="uk-modal-footer uk-text-right">' +
            '<button id="staySigned" type="button" class="md-btn md-btn-flat uk-modal-close">Оставаться в сети</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="logoutSession">Выход</button>' +
            '</div>' +
            '</div>' +
            '</div>');

        var modal = UIkit.modal("#modal_idle", {
                bgclose: false
            }),
            session = {
                //Logout Settings
                inactiveTimeout: 3600000,      //(ms) The time until we display a warning message
                warningTimeout: 30000,      //(ms) The time until we log them out
                minWarning: 5000,           //(ms) If they come back to page (on mobile), The minumum amount, before we just log them out
                warningStart: null,         //Date time the warning was started
                warningTimer: null,         //Timer running every second to countdown to logout
                autologout: {
                    logouturl: "/users/auth/logout"
                },
                logout: function () {       //Logout function once warningTimeout has expired
                    window.location = session.autologout.logouturl;
                }
            },
            $sessionCounter = $('#sessionSecondsRemaining').html(session.warningTimeout/1000);

        $(document).on("idle.idleTimer", function (event, elem, obj) {
            //Get time when user was last active
            var diff = (+new Date()) - obj.lastActive - obj.timeout,
                warning = (+new Date()) - diff;

            //On mobile js is paused, so see if this was triggered while we were sleeping
            if (diff >= session.warningTimeout || warning <= session.minWarning) {
                modal.hide();
            } else {
                //Show dialog, and note the time
                $sessionCounter.html(Math.round((session.warningTimeout - diff) / 1000));
                modal.show();
                session.warningStart = (+new Date()) - diff;

                //Update counter downer every second
                session.warningTimer = setInterval(function () {
                    var remaining = Math.round((session.warningTimeout / 1000) - (((+new Date()) - session.warningStart) / 1000));
                    if (remaining >= 0) {
                        $sessionCounter.html(remaining);
                    } else {
                        session.logout();
                    }
                }, 1000)
            }
        });

        $body
        //User clicked ok to stay online
            .on('click','#staySigned', function () {
                clearTimeout(session.warningTimer);
                modal.hide();
            })
            //User clicked logout
            .on('click','#logoutSession', function () {
                session.logout();
            });

        $(document).idleTimer(session.inactiveTimeout);

    },
    selectReceiver:function(){

        $('#receiverSelect').selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            create: true,
            render: {
                option: function(item, escape) {
                    return '<div>' +
                        '<span class="title">' +
                        '<span class="name">' + escape(item.short) + '</span>' +
                        '<span class="by">' + escape(item.name) + '</span>' +
                        '</span>' +
                        '<span class="description">' + escape(item.address) + '</span>' +
                        '<ul class="meta">' +
                            (item.inn ? '<li class="language">INN:' + escape(item.inn) + '</li>' : '') +
                            '<li class="watchers"><span>MFO:' + escape(item.mfo) + '</span></li>' +
                            '<li class="forks"><span>OKED:' + escape(item.oked) + '</span> </li>' +
                        '</ul>' +
                        '</div>';
                }
            },
            score: function(search) {
                var score = this.getScoreFunction(search);
                return function(item) {
                    return score(item) * (1 + Math.min(item.inn / 100, 1));
                };
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                var sender=$('#documents-sender_id').val();

                $.ajax({
                    url: '/edoc/documents/receiver/' + encodeURIComponent(query),
                    type: 'GET',
                    data:{sender:sender},
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res);
                    }
                });
            }
        });
    }
};
Muxr.init();