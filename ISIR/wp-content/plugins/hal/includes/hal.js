var checked = new Array();

var CheckedBox = function(id,  label, uri, checkbox){
	this.id = id;
	this.checkbox = checkbox;
	this.label = label;
	this.uri = uri;
	
	checkbox.addEventListener('change', (event) => {
				if (event.target.checked) {
					
				checked.push(id);
						
				jQuery.ajax({
					url: 'admin-ajax.php',
					type: 'POST',
					data: { 
					   action: 'ajax_request_hal_add', 
					   id : id,
					   label : label,
					   uri : uri 
					   },
					success: function(data){
						
						},
					 error:function(jqXMTR, textStatus, errorThrown){
						alert(errorThrown);
					}
				});
				
			  } else {
				checked.pop(id);
				
				jQuery.ajax({
					url: 'admin-ajax.php',
					type: 'POST',
					data: { 
					   action: 'ajax_request_hal_remove', 
					   id : id 
					   },
					success: function(data){
						
						},
					 error:function(jqXMTR, textStatus, errorThrown){
						alert(errorThrown);
					}
				});
				
				
			  }
			})
	
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
  s+="<ul class=\"list-group\" id=\"myList\">";

	 for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
        
			s+="<li id=\"element_"+doc.docid+"\" class=\"list-group-item\"><input type=\"checkbox\" id=\""+doc.docid+"\"  > <a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></li>";
     
     }
      s+=" </ul>";  
      
      
	

     
     document.getElementById("docs").innerHTML=s;
     
      for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
         
			var checkbox = document.getElementById(doc.docid);
			var checkboxObject = new CheckedBox(doc.docid, doc.label_s, doc.uri_s, checkbox);

			
	
			for(var id in checked){
				if(doc.docid == checked[id]){
					checkbox.checked = true;
					
					break;
				
				}
	
			}
			
     }
	
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
			s+="<li id=\"element_"+doc.docid+"\" class=\"list-group-item\"><input type=\"checkbox\" id=\""+doc.docid+"\" > <a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></li>";
     }
      
      
  }


	
      s+=" </ul>"; 


     
     document.getElementById("docs").innerHTML=s;
     
     for(var j=0; j<response["groups"].length; j++){
 
      var group = response["groups"][j];
     
      doclist = group.doclist;
	
       for(var i=0; i<doclist["docs"].length; i++){
          var doc=doclist["docs"][i];
           var checkbox = document.getElementById(doc.docid);

			var checkboxObject = new CheckedBox(doc.docid, doc.label_s, doc.uri_s, checkbox);
			
			for(var id in checked){
				if(doc.docid == checked[id]){
					checkbox.checked = true;
					break;
				
				}
	
			}

		}
     }
}


function getSelected(id){
	
	checked.push(id);

	
}

