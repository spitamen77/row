/**
 * Created by rashidovn on 08.06.2017.
 */
Vaksina={
    openVkTumanForm:function(){
        $("#modal_add_VkTuman_btn").click(function(){
            var m=UIkit.modal('#modal_add_VkTuman');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_VkTuman").hide();     
        });
    },
    saveVkTuman:function(){
        $('#saveVkTuman').click(function(){
            if($('#VkTumanEdit')){
                console.log('bor');
            }
            
          var data=$('#formVkTuman').serialize();
          //console.log(data);
            $.post('/settings/viloyat/savetuman',{data:data},function(response){
                //console.log(data);
                if(response.status=='success'){
                    console.log(response.status);
                    UIkit.modal('#modal_add_VkTuman').hide();
                    UIkit.modal('#modal_notificationVkTuman').show();
                    $('#modal_add_VkTuman').unbind();
                    $('#modal_notificationVkTuman').unbind();
                }
                else{
                    UIkit.modal.alert(response.status);
                }
            });

        });
        
    },

    saveVkUchastka:function(){
        $('#saveVkTuman').click(function(){
            if($('#VkTumanEdit')){
                console.log('bor');
            }

            var data=$('#formVkTuman').serialize();
            //console.log(data);
            $.post('/settings/viloyat/saveuser',{data:data},function(response){
                //console.log(data);
                if(response.status=='success'){
                    console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_VkTuman').hide();

                    UIkit.modal('#modal_notificationVkTuman').show();
                    $('#modal_add_VkTuman').unbind();
                    $('#modal_notificationVkTuman').unbind();

                }
                else{
                    UIkit.modal.alert(response.status);
                }
                // if(response.status){
                //     UIkit.modal('#modal_add_VkTuman').hide();
                //     UIkit.modal('#modal_validVkTuman').show();
                // }
                // else{
                //
                // }
            });

        });

    },

    openClearedVkTuman:function(){
        $('#addAnotherVkTuman').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationVkTuman').hide(); 
            
            $("#formVkTuman")[0].reset();
            UIkit.modal('#modal_add_VkTuman').show();
            
            
            $('#modal_add_VkTuman').unbind();  
            $('#modal_notificationVkTuman').unbind();
            $('.uk-close').unbind();  
        });
    },
    //------VkViloyat form ---------------------------------------------------------//
    openVkViloyatForm:function(){
        console.log('sss');
        $("#modal_add_VkViloyat_btn").click(function(){
            var m=UIkit.modal('#modal_add_VkViloyat');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_VkViloyat").hide();     
        });
    },
    openDistribution:function(){
        console.log('sss');
        $(".modal_distribution_VkViloyat_btn").click(function(){
            var m=UIkit.modal('#modal_distribution_VkViloyat');
            
            var vaksina = $(this).attr('data-vaksina'),
                prixod = $(this).attr('data-prixod');
            
            $('#dir-vaksina').val(vaksina).change();
            $('#vaksina_id211').val(vaksina);
            $('#dir-prixod').val(prixod).change();
            $('#proxod_id211').val(prixod);
            console.log('vaksina: '+vaksina+" prixod: "+prixod);
            $.get("/settings/viloyat/kg",{id: vaksina},function(response){
                 if (response.status=="error")  {
                    $("#prixod-ves").html(response.status);
                    UIkit.modal.alert("Iltimos vaksinani tanlang!");
                 }
                 else  {
                    $("#prixod-ves11").html(response.status);
                    $("#prixod-doza11").html(response.doza);
                    $("#prixod-count211").val(response.val);
                    // UIkit.modal.alert($("#prixod-count2").val());
                    console.log(response.val);
                 }        
            });


            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_distribution_VkViloyat").hide();     
        });
    },
    openEditVkViloyatForm:function(){
        var id;
        $(".modal-edit-VkViloyat").click(function(){
            var title = $(this).attr('data-title'),
                short = $(this).attr('data-short'),
                speciality = $(this).attr('data-speciality');
            id = $(this).attr('data-id');
            $('#dir-title').val(title);
            $('#dir-speciality').val(speciality);
            $('#dir-short').val(short);
            

            var m=UIkit.modal('#modal_edit_VkViloyat');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
            $('#saveVkViloyatEdit').click(function(){
            //data['id'] = 500;
              var data=$('#formVkViloyatEdit').serialize();
              
              console.log('data attr VkViloyat');
              //var id = $(this).attr('data-id');
                
                $.post('/reference/VkViloyat/edit/'+id,{data:data},function(response){
                    //console.log(response);
                    if(response.status == 'successEditLoad'){
                        console.log(response.status);
                        
                        //$("#row_"+id).load();
                        //$('#row_'+id).load('#row_'+id);
                        //document.getElementByid
                        $('#modal_edit_VkViloyat').hide();
                        window.location.reload();
                        //$("#row_"+id).remove();
                    }
                    $('#modal_edit_VkViloyat').unbind();
                
                
            });
               
        });
        });
    },
    
    saveVkViloyat:function(){
        $('#saveVkViloyat').click(function(){

          var data=$('#formVkViloyat').serialize();
          //console.log(data);
            $.post('/settings/viloyat/saveviloyat',{data:data},function(response){
                if(response.status=='success'){
                    // console.log(response.status);
                    response.status == 'un';
                    UIkit.modal('#modal_add_VkViloyat').hide();

                     UIkit.modal('#modal_notificationVkViloyat').show();
                     $('#modal_add_VkViloyat').unbind();
                     $('#modal_notificationVkViloyat').unbind();

                }
                else{
                    UIkit.modal.alert(response.status);
                }
            });

        });

    },
    saveDistribution:function(){
        $('#saveVkViloyat').click(function(){

          var data=$('#formVkViloyat').serialize();
          //console.log(data);
            $.post('/settings/viloyat/saveviloyat',{data:data},function(response){
                if(response.status=='success'){
                    // console.log(response.status);
                    window.location.reload();
                    response.status == 'un';
                    UIkit.modal('#modal_add_VkViloyat').hide();

                     UIkit.modal('#modal_notificationVkViloyat').show();
                     $('#modal_add_VkViloyat').unbind();
                     $('#modal_notificationVkViloyat').unbind();

                }
                else{
                    UIkit.modal.alert(response.status);
                }
            });

        });

    },
    openClearedVkViloyat:function(){
        $('#addAnotherVkViloyat').click(function(){
            console.log('tic');
            UIkit.modal('#modal_notificationVkViloyat').hide(); 
            
            $("#formVkViloyat")[0].reset();
            UIkit.modal('#modal_add_VkViloyat').show();
            
            
            $('#modal_add_VkViloyat').unbind();  
            $('#modal_notificationVkViloyat').unbind();
            $('.uk-close').unbind();  
        });
    },
    init:function(){

    }
    
};
Vaksina.init();