  (function($) {
  	$(function () {
  		$("#signup").click(function(){
  			if($("#login-modal").hasClass("in")){
  			$("#login-modal").modal("hide");
  		}
  			if($("#signup-modal").hasClass("in")==false){
  			$("#signup-modal").modal('show');}
  			else {$("#signup-modal").modal('hide');}
  		});
  		$("#login-icon").click(function(){
  			if($("#signup-modal").hasClass("in")){
  			$("#signup-modal").modal("hide");
  		}
  			if($("#login-modal").hasClass("in")==false){
  			$("#login-modal").modal('show');}
  			else {$("#login-modal").modal('hide');}

  			$("#login-modal-body").removeClass("hidden");
  			$("#getpass-modal-body").addClass("hidden");
  		});
  		$("#create-acc-login").click(function(){
  			if($("#login-modal").hasClass("in")){
  			$("#login-modal").modal("hide");
  		}
  			if($("#signup-modal").hasClass("in")==false){
  			$("#signup-modal").modal('show');}
  			else {$("#signup-modal").modal('hide');}
  		});
  		$("#go-lostpass").click(function(){
  			$("#login-modal-body").addClass("hidden");
  			$("#getpass-modal-body").removeClass("hidden");
  		});
  		
    });//end jquery
  })(jQuery);