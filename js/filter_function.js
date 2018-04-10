var selected = [];


$(document).on('ready',function(){
  var boxes = $("[type=checkbox]");
  for(var i = 0; i < boxes.length; ++i){
  if(boxes[i].checked){

    selected.push(boxes[i].parentElement.attributes["id"].value);
    console.log(selected);
  }




}





$("[type=checkbox]").on('click',
  function(event){
  event.preventDefault();

  var program_type = $(event.target).val();
  var myurl = "js/filter.php";

  if(jQuery.inArray(program_type,selected) !== -1)
{
  selected.splice($.inArray(program_type,selected),1);

}else{
  selected.push(program_type);

}


  $.ajax({

    type : 'GET',
    url : myurl,
    data : { 'programType' : selected },
    success : function(data){
       console.log(selected);
       if($(event.target).prop('checked')){
         $(event.target).prop('checked',false);
       }else{
         $(event.target).prop('checked',true);
       }

    }
  });


  });
  }
);

$("#button").click(
  function(event){

    event.preventDefault();
  var myUrl = "js/filter.php?programType=ELL";
  $.getJSON(myUrl,function(data){
    console.log(data);
    console.log("run throuhg");

      var result = [];
    $.each(data,function(key,val){

      result.push('<a href="school_details.php?id='+val.code+'">' + val.name + '</a>');


      //result = $('<a href="school_details.php?id='+ data.code + '">' + data.name + '</a>');

      $('#show').append(result);



    });

  });

}
);
