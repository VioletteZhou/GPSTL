var checked = new Array();
var checkedHide = new Array();

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


var CheckedBoxHide = function(id, checkbox){
	this.id = id;
	this.checkbox = checkbox;

	
	checkbox.addEventListener('change', (event) => {
				if (event.target.checked) {
					
				checkedHide.push(id);
						
				jQuery.ajax({
					url: 'admin-ajax.php',
					type: 'POST',
					data: { 
					   action: 'ajax_request_hal_add_hide', 
					   id : id
					   },
					success: function(data){
						
						},
					 error:function(jqXMTR, textStatus, errorThrown){
						alert(errorThrown);
					}
				});
				
			  } else {
				checkedHide.pop(id);
				
				jQuery.ajax({
					url: 'admin-ajax.php',
					type: 'POST',
					data: { 
					   action: 'ajax_request_hal_remove_hide', 
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


function getDocuments(idHal){

        
	jQuery.ajax({ 
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q=authIdHal_s:"+idHal+"&rows=10000&sort=producedDate_tdate desc",
        datatype:"json",
        success:function(rep){
            traiterReponseDocuments(rep);
        },
        error:function(jqXMTR, textStatus, errorThrown){
            func_err("Pb lors de la transmission des données", "inscription");
        }
    });

	
}

function getDocumentsSortedByGroup(idHal){
  
        
	jQuery.ajax({ 
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q=authIdHal_s:"+idHal+"&rows=10000&sort=producedDate_tdate desc&group=true&group.field=docType_s&indent=true&group.limit=1000",
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
  

   s+="<tr class=\"header\">   <th>Do not show</th>       <th>Add to favorites</th>       <th>Publication</th> </tr>";
   

  
 
  
  

	 for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
        
			s+="<tr> <td><input type=\"checkbox\" id=\"hide_"+doc.docid+"\"  > </td><td><input type=\"checkbox\" id=\""+doc.docid+"\"  > </td> <td><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></td></tr>";
     
     }
     
      
      s+="</table>";
	

     
     document.getElementById("docs").innerHTML=s;
     
      for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
         
			var checkbox = document.getElementById(doc.docid);
			var checkboxObject = new CheckedBox(doc.docid, doc.label_s, doc.uri_s, checkbox);
			
			var checkboxHide = document.getElementById("hide_"+doc.docid);
			var checkboxHideObject = new CheckedBoxHide(doc.docid, checkboxHide);
			
	
			for(var indice in checked){
				if(doc.docid == checked[indice]){
					checkbox.checked = true;
					
					break;
				
				}
	
			}
			
			for(var indice in checkedHide){
				if(doc.docid == checkedHide[indice]){
					checkboxHide.checked = true;
					
					break;
				
				}
	
			}
			
     }
	
}


function traiterReponseDocumentsSortedByGroup(rep){
	
	document.getElementById("wait").innerHTML="";
	
	
	var response = rep.grouped.docType_s;
      
	var s="";	
        
 s+="<br>";
  
  
   s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>Do not show</th>       <th>Add to favorites</th>  <th>Type</th>     <th>Publication</th> </tr>";
   
  
  for(var j=0; j<response["groups"].length; j++){
 
      var group = response["groups"][j];
     
    
      
      doclist = group.doclist;
      
     

  
      
       for(var i=0; i<doclist["docs"].length; i++){
          var doc=doclist["docs"][i];
			s+="<tr> <td><input type=\"checkbox\" id=\"hide_"+doc.docid+"\"  > </td><td><input type=\"checkbox\" id=\""+doc.docid+"\"  > </td> "+
			"<td>"+group.groupValue+"</td><td><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></td></tr>";       

     }
       
      
  }

 s+="</table>";
	
         
    

     
     document.getElementById("docs").innerHTML=s;
     
     for(var j=0; j<response["groups"].length; j++){
 
      var group = response["groups"][j];
     
      doclist = group.doclist;
	
       for(var i=0; i<doclist["docs"].length; i++){
		   
          var doc=doclist["docs"][i];
          
           var checkbox = document.getElementById(doc.docid);
			var checkboxObject = new CheckedBox(doc.docid, doc.label_s, doc.uri_s, checkbox);
			
			var checkboxHide = document.getElementById("hide_"+doc.docid);
			var checkboxHideObject = new CheckedBoxHide(doc.docid, checkboxHide);
			
			for(var indice in checked){
				if(doc.docid == checked[indice]){
					checkbox.checked = true;
					break;
				
				}
	
			}
			
			for(var indice in checkedHide){
				if(doc.docid == checkedHide[indice]){
					checkboxHide.checked = true;
					
					break;
				
				}
	
			}

		}
     }
}


function getSelected(id){

	checked.push(id);

	
}

function getSelectedHide(id){
	
	checkedHide.push(id);
	
}

