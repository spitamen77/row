/**
 * Created by rashidovn on 08.06.2017.
 */
Reestr={
   openCreateForm:function(){
     console.log('openNotificationForm');
        $("#modal_add_reestr_btn").click(function(){
            var m=UIkit.modal('#modal_add_reestr');
            if ( m.isActive() ) {
                m.hide();
                $('.uk-close').unbind();
            } else {
                m.show();
                $('.uk-close').unbind();
            }
        });
        $(".uk-modal-close .uk-close").click(function(){
           $("#modal_add_reestr").hide();     
        });
   },

    saveReestr:function(){
        $('#saveDirection').click(function(){
            var data=$('#formDirection').serialize();

            $.post('/reestr/default/save',{data:data},function(response){
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

    saveReestrCon:function(){
        $('#saveContr').click(function(){
            var data=$('#formDirection').serialize();

            $.post('/reestr/default/savecon',{data:data},function(response){
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

    saveType:function(){
        $('#saveDirection').click(function(){
            if($('#directionEdit')){
                console.log('bor');
            }
            var data=$('#formDirection').serialize();

            $.post('/reestr/default/tsave',{data:data},function(response){
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

    editTypeStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reestr/default/changestatus/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },
    editReestrStatus:function(){
        $('.modal-edit-status').click(function(){
            var Mstatus = $(this).attr('data-id');

            console.log(Mstatus);
            $.post('/reestr/default/status/'+Mstatus,{data:Mstatus},function(response){

                if(response.status == 'statusChanged'){
                    console.log(response.status);
                    window.location.reload();
                }
            });
        });
    },

    openEditTypeForm:function(){
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
                $.post('/reestr/default/edittype/'+id,{data:data},function(response){
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

    openEditReestrForm:function(){
        var id;
        $(".modal-edit-direction").click(function(){
            var name_businesses = $(this).attr('data-name-businesses'),
                stir = $(this).attr('data-stir'),
                type_id = $(this).attr('data-type-id'),
                viloyat_id = $(this).attr('data-viloyat-id'),
                tuman_id = $(this).attr('data-tuman-id'),
                adress = $(this).attr('data-adress'),
                id = $(this).attr('data-id'),
                special_code = $(this).attr('data-special-code');
            $('#name_businesses').val(name_businesses);
            $('#type_id').val(type_id);
            $('#stir').val(stir);
            $('#viloyat_id').val(viloyat_id);
            $('#tuman_id').val(tuman_id);
            $('#adress').val(adress);
            $('#special_code').val(special_code);
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
                $.post('/reestr/default/edit/'+id,{data:data},function(response){
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
    
};