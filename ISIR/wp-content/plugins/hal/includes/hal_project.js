var checkedShow = new Array();
var map = {};

var CheckedBoxShow = function(id,  label, uri, type){
	this.id = id;
	
	this.label = label;
	this.uri = uri;
	if(map[type]==undefined){
		var new_array = new Array();
		new_array.push(this);
		map[type]=new_array;
	}
	else{
		map[type].push(this);
	}
	
	
}

function getSelectedShow(id, label, uri, type){

	checkedShow.push( new CheckedBoxShow(id, label, uri, type));
	
}




function getDocuments(){
	
	
	document.getElementById("wait").innerHTML="";
	
	
	
	
	var s="";	
        
       
 s+="<br>";
  
  
  s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>Publication</th> </tr>";
   

	 for(var indice in checkedShow){
		var box = checkedShow[indice];
			s+="<td><a href=\""+box.uri+"\">"+box.label+"</a></td></tr>";
     }
      s+=" </table>";  

      

     
     document.getElementById("docs").innerHTML=s;
		
}

function getDocumentsSortedByGroup(){
	
	
	document.getElementById("wait").innerHTML="";
	
	
      
	var s="";	
        

  s+="<br>";
  
  
   s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>Type</th>     <th>Publication</th> </tr>";
   
  
  
	for(var type in map){
		var box_array = map[type];
		
		for(var indice in box_array){
			var box = box_array[indice];
			
			s+="<tr> <td>"+type+"</td><td><a href=\""+box.uri+"\">"+box.label+"</a></td></tr>";   
			
		} 
		
	
	}
     
       
	
      s+=" </table>"; 

     
     document.getElementById("docs").innerHTML=s;
    
    
}


function traiterReponseDocuments(rep){
	
	document.getElementById("wait").innerHTML="";
	
	
	var response = rep.response;
	var s="";	
        
       
 s+="<br>";
  
  
  s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>Publication</th> </tr>";
   

	 for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
          
          var show = false;
          
          for(var indice in checkedHide){
		
			  if(doc.docid == checkedHide[indice]){
			
				show = true;
				break;
			}
		  }
		  
		  if(show)

			s+="<td><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></td></tr>";
     }
      s+=" </table>";  

      

     
     document.getElementById("docs").innerHTML=s;
	
}


function traiterReponseDocumentsSortedByGroup(rep){
	
	document.getElementById("wait").innerHTML="";
	
	
	var response = rep.grouped.docType_s;
      
	var s="";	
        

  s+="<br>";
  
  
   s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>Type</th>     <th>Publication</th> </tr>";
   
  
  
  for(var j=0; j<response["groups"].length; j++){
 
      var group = response["groups"][j];
     
       
      doclist = group.doclist;
      
       for(var i=0; i<doclist["docs"].length; i++){
          var doc=doclist["docs"][i];
          
			 var show = false;
          
          for(var indice in checkedHide){
		
			  if(doc.docid == checkedHide[indice]){
			
				show = true;
				break;
			}
		  }
		  
		  if(show){
       s+="<tr> <td>"+group.groupValue+"</td><td><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></td></tr>";   
		}
     
     }
      
      
  }



	
      s+=" </table>"; 

     
     document.getElementById("docs").innerHTML=s;
	
}


