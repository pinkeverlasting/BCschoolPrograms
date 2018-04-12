var selected = [];
var proURL;




function checked(){

  var boxes = $("#checkbox");

  for(var i = 0; i < boxes.length; ++i){
  if(boxes[i].checked){

    selected.push(boxes[i].parentElement.attributes["id"].value);
    console.log(selected);
  }
}
}

$(function() {
    checked();

});


$("[type=checkbox]").on('click',
  function(event){
  event.preventDefault();

  var program_type = "programType[]="+$(event.target).val();
  var myurl = "js/filter.php";

  proURL = program_type;



  if(jQuery.inArray(program_type,selected) !== -1)
{
  selected.splice($.inArray(program_type,selected),1);

}else{
  selected.push(program_type);

}

console.log(selected);

if(selected.length > 0){
  $.ajax({

    type : 'GET',
    url : myurl,
    data : { 'programType' : selected },
    success : function(data){
      for(var i = 0; i < selected.length; i++){
       //console.log(selected);
       if($(event.target).prop('checked')){
         $(event.target).prop('checked',false);
       }else{
         $(event.target).prop('checked',true);
       }
     }

    }
  });
}
});

$("#button").click(
 function(event){

   event.preventDefault();
   $('#show').empty();
 var query = selected.join('&');
 var myUrl = "js/filter.php?"+query;
 console.log(myUrl);

 $.getJSON(myUrl,function(data){
   console.log(data);
   console.log("run through");
     var parsed = data;
     var result = [];
   $.each(parsed,function(key,val){



     result.push('<a href="school_details.php?id='+val.code+'">' + val.name + '</a><br>');

     //result = $('<a href="school_details.php?id='+ data.code + '">' + data.name + '</a>');





 //  console.log("show data");



 });

 $('#show').append(result);

});

});
