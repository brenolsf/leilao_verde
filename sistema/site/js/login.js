$('#username').focus(function(){ $('span#login').hide();});
$('span#login').click(function(){ $(this).hide(); $('#username').focus();});

$('#password').focus(function(){ $('span#senha').hide();});
$('span#senha').click(function(){ $(this).hide(); $('#password').focus();});

$('#email').focus(function(){ $('span#mail').hide();});
$('span#mail').click(function(){ $(this).hide(); $('#email').focus();});

$('#senha-nova').focus(function(){ $('span#senha').hide();});
$('span#senha').click(function(){ $(this).hide(); $('#senha-nova').focus();});

$('#senha-nova-confirmacao').focus(function(){ $('span#confirmacao').hide();});
$('span#confirmacao').click(function(){ $(this).hide(); $('#senha-nova-confirmacao').focus();});

$('#username').blur(function(){ if($(this).val() == "") $('span#login').show(); });
$('#password').blur(function(){ if($(this).val() == "") $('span#senha').show(); });
$('#email').blur(function(){ if($(this).val() == "") $('span#mail').show(); });
$('#senha-nova').blur(function(){ if($(this).val() == "") $('span#senha').show(); });
$('#senha-nova-confirmacao').blur(function(){ if($(this).val() == "") $('span#confirmacao').show(); });

$(function(){
	$("#username").tipTip({defaultPosition: "right"});
});