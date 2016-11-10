var ckeditor = CKEDITOR.replace('editor1', {
  height: '400px'
});

//Date picker
$('#datepicker').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd'
});