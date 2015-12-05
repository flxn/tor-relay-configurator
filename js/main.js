$('td:contains("YES")').css('color', 'green');
$('td:contains("NO")').css('color', 'darkred');
$('input[name=node-type]').change(function() {
  /*
  if($('input[name=node-type]:checked').val() == 'bridge') {
    $('.hideBridge').hide();
  } else {
    $('.hideBridge').show();
  }
  */
  if($('input[name=node-type]:checked').val() == 'exit') {
    $('#exit-info').show();
  } else {
    $('#exit-info').hide();
  }
});
$('#exit-info').hide();

$('.only-numbers').keyup(function() {
    $(this).val($(this).val().replace(/\D/g,''));
});
