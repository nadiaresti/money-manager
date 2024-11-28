// General Helper
$(document).ready(function() {
  $('.format-number').each(function() {
    formatNumber($(this));
  });

  $(document).on('keyup', '.format-number', function(){
    formatNumber($(this));
  })
})

function formatNumber(element) {
  let num = element.val();
  // remove comma
  num = num.replace(/,/g, '');
  // format number
  let temp = num.toString().split('.');
  temp[0] = temp[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

  element.val(temp.join('.'));
}