var checkedHide = new Array();

function getSelectedHide(id){

	checkedHide.push(id);
	
}




function getDocuments(nom, prenom){
	
        nom = "Doncieux";
        prenom = "Stephane";
        
	jQuery.ajax({ 
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q="+nom+" "+prenom+"&rows=10000&sort=producedDate_tdate desc",
        datatype:"json",
        success:function(rep){
            traiterReponseDocuments(rep);
        },
        error:function(jqXMTR, textStatus, errorThrown){
            func_err("Pb lors de la transmission des données", "inscription");
        }
    });

	
}

function getDocumentsSortedByGroup(nom, prenom){
  
  
    nom = "Doncieux";
        prenom = "Stephane";
        
	jQuery.ajax({ 
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q="+nom+" "+prenom+"&rows=10000&sort=producedDate_tdate desc&group=true&group.field=docType_s&indent=true&group.limit=1000",
        datatype:"json",
        success:function(rep){
            traiterReponseDocumentsSortedByGroup(rep);
        },
        error:function(jqXMTR, textStatus, errorThrown){
            func_err("Pb lors de la transmission des données", "inscription");
        }
    });
    
    
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
          
          var show = true;
          
          for(var indice in checkedHide){
		
			  if(doc.docid == checkedHide[indice]){
			
				show = false;
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
          
			 var show = true;
          
          for(var indice in checkedHide){
		
			  if(doc.docid == checkedHide[indice]){
			
				show = false;
				break;
			}
		  }
		  
		  if(show){
       s+="<tr> <td>"+group.groupValue+"</td><td><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></td></tr>";   
		}
     
     }
      
      
  }



	
      s+=" </ul>"; 

     
     document.getElementById("docs").innerHTML=s;
	
}


