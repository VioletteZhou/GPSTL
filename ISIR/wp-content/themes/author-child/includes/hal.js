
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
            func_err("Pb lors de la transmission des donn√©es", "inscription");
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
            func_err("Pb lors de la transmission des donn√©es", "inscription");
        }
    });
    
    
}


function traiterReponseDocuments(rep){
	
	document.getElementById("wait").innerHTML="";
	
	
	var response = rep.response;
	var s="";	
        
       
  s+="<br>";
  s+="<ul class=\"list-group\" id=\"myList\">";



	 for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
          //var doc=response["org"][i];
			s+="<li id=\""+doc.docid+"\" class=\"list-group-item\"><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></li>";
     }
      s+=" </ul>";  

        /*<div>
          <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter">
          <label for="subscribeNews">Souhaitez-vous vous abonner ‡ la newsletter ?</label>
        </div>
        <div>
          <button type="submit">S'abonner</button>
        </div>*/

     
     document.getElementById("docs").innerHTML=s;
	
}


function traiterReponseDocumentsSortedByGroup(rep){
	
	document.getElementById("wait").innerHTML="";
	
	
	var response = rep.grouped.docType_s;
      
	var s="";	
        

  s+="<ul class=\"list-group\" id=\"myList\">";
  
  
  for(var j=0; j<response["groups"].length; j++){
 
      var group = response["groups"][j];
     
      s+="<h1>"+group.groupValue+"</h1>";
      
      doclist = group.doclist;
      
       for(var i=0; i<doclist["docs"].length; i++){
          var doc=doclist["docs"][i];
          //var doc=response["org"][i];
			s+="<li id=\""+doc.docid+"\" class=\"list-group-item\"><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></li>";
     }
      
      
  }



	
      s+=" </ul>"; 

        /*<div>
          <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter">
          <label for="subscribeNews">Souhaitez-vous vous abonner ‡ la newsletter ?</label>
        </div>
        <div>
          <button type="submit">S'abonner</button>
        </div>*/

     
     document.getElementById("docs").innerHTML=s;
	
}



	document.getElementById("all").addEventListener("click",function(){
        getDocuments("amel", "arkoub"); return false;
    },false);




	document.getElementById("sortbygroup").addEventListener("click",function(){
        getDocumentsSortedByGroup("amel", "arkoub"); return false;
    },false);


getDocuments("amel", "arkoub");

