// General Helper

$(document).on('keyup', '.format-number', function(){
  let num = $(this).val();
  // remove comma
  num = num.replace(/,/g, '');
  // format number
  let temp = num.toString().split('.');
  temp[0] = temp[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

  $(this).val(temp.join('.'));
})




