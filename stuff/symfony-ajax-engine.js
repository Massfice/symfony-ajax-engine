function go(action) {
  var url = server_url + '/ajax/' + action;
  var success = function() {};
  $.post(url, {}, success, 'json')
  .done(resp => {

    for(var index in resp['view_resolver_containers']) {
      if($("#"+index).length) $("#"+index).html(resp['view_resolver_containers'][index]);
    }

    for(var index in resp['view_resolver_content']) {
      if($("#"+index).length) $("#"+index).html(resp['view_resolver_content'][index]);
    }
  });
}

$(window).on('load',function(){
  go(action);
});
