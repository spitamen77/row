/**
 * Created by rashidovn on 20.07.2017.
 */
var EIMZO_MAJOR = 3;
var EIMZO_MINOR = 37;


var errorCAPIWS = 'Ошибка соединения с E-IMZO. Возможно у вас не установлен модуль E-IMZO или Браузер E-IMZO.';
var errorBrowserWS = 'Браузер не поддерживает технологию WebSocket. Установите последнюю версию браузера.';
var errorUpdateApp = 'ВНИМАНИЕ !!! Установите новую версию приложения E-IMZO или Браузера E-IMZO.<br /><a href="https://e-imzo.uz/main/downloads/" role="button">Скачать ПО E-IMZO</a>';
var errorWrongPassword = 'Пароль неверный.';


var AppLoad = function () {
    EIMZOClient.API_KEYS = [
        'localhost', '96D0C1491615C82B9A54D9989779DF825B690748224C2B04F500F370D51827CE2644D8D4A82C18184D73AB8530BB8ED537269603F61DB0D03D2104ABF789970B',
        '127.0.0.1', 'A7BCFA5D490B351BE0754130DF03A068F855DB4333D43921125B9CF2670EF6A40370C646B90401955E1F7BC9CDBF59CE0B2C5467D820BE189C845D0B79CFC96F',
        'null', 'E0A205EC4E7B78BBB56AFF83A733A1BB9FD39D562E67978CC5E7D73B0951DB1954595A20672A63332535E13CC6EC1E1FC8857BB09E0855D7E76E411B6FA16E9D',
        'my.muxr.uz','0B2CE37F3BC189E3CD6C6AC60BBE98D996469D2EF1C071A408B8750433AB5A918313A5918EF1C54B63F33893C3FDFC621AB90B7851F3880E4AC887E7CE23F33A'
    ];
    uiLoading();
    EIMZOClient.checkVersion(function(major, minor){
        var newVersion = EIMZO_MAJOR * 100 + EIMZO_MINOR;
        var installedVersion = parseInt(major) * 100 + parseInt(minor);
        if(installedVersion < newVersion) {
            uiUpdateApp();
        } else {
            EIMZOClient.installApiKeys(function(){
                uiLoadKeys();
            },function(e, r){
                if(r){
                    uiShowMessage(r);
                } else {
                    wsError(e);
                }
            });
        }
    }, function(e, r){
        if(r){
            uiShowMessage(r);
        } else {
            uiNotLoaded(e);
        }
    });
}


var uiShowMessage = function(message){
    var m={message:message,status:'danger'};
    console.log(message);
    Muxr.showNotify(m);
}

var uiLoading = function(){
    var l = document.getElementById('message');
    l.innerHTML = 'Загрузка ...';
    l.style.color = 'red';
}

var uiNotLoaded = function(e){
    var l = document.getElementById('message');
    l.innerHTML = '';
    if (e) {
        wsError(e);
    } else {
        uiShowMessage(errorBrowserWS);
    }
}

var uiUpdateApp = function(){
    var l = document.getElementById('message');
    l.innerHTML = errorUpdateApp;
}

var uiLoadKeys = function(){
    uiClearCombo();
    EIMZOClient.listAllUserKeys(function(o, i){
        var itemId = "itm-" + o.serialNumber + "-" + i;
        return itemId;
    },function(itemId, v){
        return uiCreateItem(itemId, v);
    },function(items, firstId){
        uiFillCombo(items);
        uiLoaded();
        uiComboSelect(firstId);
    },function(e, r){
        uiShowMessage(errorCAPIWS);
    });
}

var uiComboSelect = function(itm){
    if(itm){
        var id = document.getElementById(itm);
        id.setAttribute('selected','true');
    }
}

var uiClearCombo = function(){
    var combo = document.testform.key;
    combo.length = 0;
}

var uiFillCombo = function(items){
    var combo = document.testform.key;
    for (var itm in items) {
        combo.append(items[itm]);
    }
}

var uiLoaded = function(){
    var l = document.getElementById('message');
    l.innerHTML = '';
}

var uiCreateItem = function (itmkey, vo) {
    console.log(itmkey);
    var now = new Date();
    vo.expired = dates.compare(now, vo.validTo) > 0;
    var itm = document.createElement("option");
    itm.value = itmkey;
    itm.text = vo.CN;
    if (!vo.expired) {

    } else {
        itm.style.color = 'gray';
        itm.text = itm.text + ' (срок истек)';
    }
    itm.setAttribute('vo',JSON.stringify(vo));
    itm.setAttribute('id',itmkey);
    return itm;
}

var wsError = function (e) {
    if (e) {
        uiShowMessage(errorCAPIWS);
    } else {
        uiShowMessage(errorBrowserWS);
    }
};

sign = function () {
    var itm = document.testform.key.value;
    if (itm) {
        var id = document.getElementById(itm);
        var vo = JSON.parse(id.getAttribute('vo'));
        var data = document.testform.data.value;
        EIMZOClient.loadKey(vo, function(id){
            EIMZOClient.createPkcs7(id, data, null, function(pkcs7){
                console.log('Test');
                $.post('/edoc/documents/saveSign',{},function(){

                });
                document.testform.pkcs7.value = pkcs7;
            }, function(e, r){
                wsError(e);
            });
        }, function(e, r){
            if(r){
                if (r.indexOf("BadPaddingException") != -1) {
                    uiShowMessage(errorWrongPassword);
                } else {
                    uiShowMessage(r);
                }
            } else {
                uiShowMessage(errorBrowserWS);
            }
        });
    }
};

window.onload = AppLoad;