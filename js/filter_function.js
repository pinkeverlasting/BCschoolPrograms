//selected array
var selected = [];


//if checkbox is clicked
$("[type=checkbox]").click(
  function(event){
    //if checkbox id = checkbox which is the program type
  if($(event.target).attr('id') == "checkbox"){
    //get the value and put in a programType array
  var program_type = "programType[]="+$(event.target).val();
}else{
    //if checkbox id is not program type which is year
    //get the value and put in a year varaible
  var program_type = "year="+$(event.target).val();
}

  //if the value is already selected
  if(jQuery.inArray(program_type,selected) !== -1)
{
  //remove the value to avoid duplicate
  selected.splice($.inArray(program_type,selected),1);

}else{
  //add the value to the array
  selected.push(program_type);

}
//print selected array
console.log(selected);

});

//if user change the district
$("#drop-list").change(function(){

var string = 'district=';
//if the value is not empty
  if(this.value !== ''){
    //district variable = to the selected value
  var district = "district="+this.value;

//if the user change the district before
  $.each(selected,function(key,val){
    //remove the previous selected district
    if(val.includes(string)){
      selected.splice(val,1);
      console.log("yes");
    }
  });
  //push the district into selected array
  selected.push(district);
  console.log(selected);

}else{
  //if user doesn't want to filter the district
  $.each(selected,function(key,val){
    //remove the district value if user selected before
    if(val.includes(string)){
      selected.splice(val,1);
      console.log(selected);
    }
  });
}

});

//similar with district but type of school
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

//if the user click the filter button
$("#button").click(
 function(event){

   event.preventDefault();
   //empty the previous result
   $('#show').empty();
   //join array with &
 var query = selected.join('&');
 //get filter php with filter values
 var myUrl = "js/filter.php?"+query;
 console.log(myUrl);
//get result from filter php
 $.getJSON(myUrl,function(data){
   console.log(data);
   console.log("run through");
     var parsed = data;
     var result = [];
     //for each array value
   $.each(parsed,function(key,val){

     //if the user didn't filter program type
     if(val.type == ''){
       //display result with name only
    result.push('<a href="school_details.php?id='+val.code+'">' + val.name + '</a><br>');
     }else{
       //display url with program type and year stated
     result.push('<a href="school_details.php?id='+val.code+'">' + val.name + '</a>(' + val.type + ',' + val.year + ')<br>');
   }
     //result = $('<a href="school_details.php?id='+ data.code + '">' + data.name + '</a>');


 });
//add result to list of school page
 $('#show').append(result);

});

});
