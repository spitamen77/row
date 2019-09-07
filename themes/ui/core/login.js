var Login = function () {
    var runLoginButtons = function () {
        $('.forgot').click(function () {
            $('.box-login').hide();
            $('.box-forgot').show();
            $('.box-with-des').hide();
        });
        $('.go-back').click(function () {
            $('.box-login').show();
            $('.box-forgot').hide();
            $('.box-with-des').hide();
        });
        $('.with-des').click(function(){
            $('.box-login').hide();
            $('.box-forgot').hide();
            $('.box-with-des').show();
        });
       
       var el = $('.box-login');
		if (getParameterByName('box').length) {
			switch(getParameterByName('box')) {

				case "forgot" :
					el = $('.box-forgot');
                    $('.box-login').hide();
					break;
				default :
					el = $('.box-login');
                    $('.box-forgot').hide();
					break;
			}
		}
		el.show();
    };
    //function to return the querystring parameter with a given name.
	var getParameterByName = function(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	};
    
    
    return {
        //main function to initiate template pages
        init: function () {
            runLoginButtons();
        }
    };
}();