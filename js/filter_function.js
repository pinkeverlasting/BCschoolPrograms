var selected = [];
var boxchecked = [];
var district;

var proURL;





$("[type=checkbox]").click(
  function(event){
  //event.preventDefault();

  if($(event.target).attr('id') == "checkbox"){
  var program_type = "programType[]="+$(event.target).val();
}else{
  var program_type = "year="+$(event.target).val();
}
  var myurl = "js/filter.php";

  proURL = program_type;



  if(jQuery.inArray(program_type,selected) !== -1)
{
  selected.splice($.inArray(program_type,selected),1);

}else{
  selected.push(program_type);

}

console.log(selected);

});


$("#drop-list").change(function(){

var string = 'district=';
  if(this.value !== ''){
  district = "district="+this.value;


  $.each(selected,function(key,val){
    if(val.includes(string)){
      selected.splice(val,1);
      console.log("yes");
    }
  });
  selected.push(district);
  console.log(selected);
  //console.log(district);
}else{
  $.each(selected,function(key,val){
    if(val.includes(string)){
      selected.splice(val,1);
      console.log(selected);
    }
  });
}

});

$("#school").change(function(){
  var string = 'type=';
  if(this.value !== ''){
  var type = "type="+this.value;


  $.each(selected,function(key,val){
    if(val.includes(string)){
      selected.splice(val,1);
      console.log("yes");
    }
  });
  selected.push(type);
  console.log(selected);
}else{

  $.each(selected,function(key,val){
    if(val.includes(string)){
      selected.splice(val,1);
      console.log(selected);
    }
  });

}

});


$("#button").click(
 function(event){

   event.preventDefault();
   var string = "year=";
   
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


     if(val.type == ''){
    result.push('<a href="school_details.php?id='+val.code+'">' + val.name + '</a><br>');
     }else{
     result.push('<a href="school_details.php?id='+val.code+'">' + val.name + '</a>(' + val.type + ',' + val.year + ')<br>');
   }
     //result = $('<a href="school_details.php?id='+ data.code + '">' + data.name + '</a>');





 //  console.log("show data");



 });

 $('#show').append(result);

});

});
