$(document).ready(function(){

  $('#search_btn').on('click', function(){
      if($('#search_key').val() === '')
      {
        alert("Please Enter Search Key");
        return false;
      }
      else
      {
        var search_action = '/board/main/search/'+$('#search_key').val();
        $('#post_search').attr('action', search_action).submit();
      }
  });

});
