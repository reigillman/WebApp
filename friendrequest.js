$(document).ready(function () {
	$.ajax({
		type:"GET",
		url:"friendactivity.php",
		data:"",
		success: function(data){
			$('#friendActivity').html(data);
		}
	});
	$("#accept").click(function (){
		var userId= $(this).attr('data-user');
		var acceptStatus= $(this).attr('name');
		$.ajax({
			type:"POST",
			url: "acceptorreject.php",
			data:{fromUser: userId,
			accept: acceptStatus},
			complete:function(data){
				if(data.responseText == '{"result":1}'){
					$("#friendRequest").hide();
					$("#friendActivity").load('friendactivity.php');
				}
			}
		});
	});
	
	$("#reject").click(function (){
		var userId= $(this).attr('data-user');
		var rejectStatus= $(this).attr('name');
		$.ajax({
			type:"POST",
			url: "acceptorreject.php",
			data:{fromUser: userId,
			reject: rejectStatus},
			complete:function(data){
				if(data.responseText == '{"result":2}'){
					$("#friendRequest").hide();
					$("#friendActivity").load('friendactivity.php');
				}
			}
		});
	});
});