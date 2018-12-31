var checked = new Array();
var checkedHide = new Array();
var checkedShow = new Array();

var curr_idHal;

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


var CheckedBoxShow = function(id,  label, uri, checkbox){
	this.id = id;
	this.checkbox = checkbox;
	this.label = label;
	this.uri = uri;
	
	checkbox.addEventListener('change', (event) => {
				if (event.target.checked) {
					
					checkedShow.push(id);
					
					
					jQuery.ajax({ 
						type:"get",
						url:"https://api.archives-ouvertes.fr/search/",
						data:"q=docid:"+id+"&facet=true&facet.pivot=docType_s",
						datatype:"json",
						success:function(rep){
							var type = rep.facet_counts.facet_pivot.docType_s[0].value;
						
							jQuery.ajax({
									url: 'admin-ajax.php',
									type: 'POST',
									data: { 
									   action: 'ajax_request_hal_add_show', 
									   id : id,
									   label : label,
									   uri : uri,
										type : type
									   },
									success: function(data){
										
										},
									 error:function(jqXMTR, textStatus, errorThrown){
										alert(errorThrown);
									}
					});
						},
						error:function(jqXMTR, textStatus, errorThrown){
							func_err("Pb lors de la transmission des données", "inscription");
						}
					});
						
				
				
			  } else {
				checkedShow.pop(id);
				
				jQuery.ajax({
					url: 'admin-ajax.php',
					type: 'POST',
					data: { 
					   action: 'ajax_request_hal_remove_show', 
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


function getDocuments(idHal, username, isProject){
	
	var project = false;
	
	curr_idHal = idHal;
	
	if(username!=undefined)
		document.getElementById("publicationHead").innerHTML = "Publications of "+username;
	
	if(isProject!=undefined || project==true){
		project  = true;
	}

        
	jQuery.ajax({ 
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q=authIdHal_s:"+idHal+"&rows=10000&sort=producedDate_tdate desc",
        datatype:"json",
        success:function(rep){
            traiterReponseDocuments(rep, project);
        },
        error:function(jqXMTR, textStatus, errorThrown){
            func_err("Pb lors de la transmission des données", "inscription");
        }
    });

	
}

function getDocumentsSortedByGroup(idHal, username, isProject){
	
	var project = false;
	
	if(username!=undefined)
		document.getElementById("publicationHead").innerHTML = "Publications of "+username;
	
	if(isProject!=undefined || project==true){
		project  = true;
	}
        
	jQuery.ajax({ 
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q=authIdHal_s:"+idHal+"&rows=10000&sort=producedDate_tdate desc&group=true&group.field=docType_s&indent=true&group.limit=1000",
        datatype:"json",
        success:function(rep){
            traiterReponseDocumentsSortedByGroup(rep, project);
        },
        error:function(jqXMTR, textStatus, errorThrown){
            func_err("Pb lors de la transmission des données", "inscription");
        }
    });
    
    
}


function traiterReponseDocuments(rep, isProject){
	
	document.getElementById("wait").innerHTML="";
	if(isProject){
		showString = "Show";
	}
	else
		showString = "Do not show";
	
	var response = rep.response;
	var s="";	
        
       
  s+="<br>";
  
  
  s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>"+showString+"</th>       <th>Add to favorites</th>       <th>Publication</th> </tr>";
   

  
	
  
  

	 for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
			
			var checkbox_name;
			
			if(isProject){
				checkbox_name = "show_";
			}
			else{
				checkbox_name = "hide_";
			}
			s+="<tr> <td><input type=\"checkbox\" id=\""+checkbox_name+doc.docid+"\"  > </td><td><input type=\"checkbox\" id=\""+doc.docid+"\"  > </td> <td><a href=\""+doc.uri_s+"\">"+doc.label_s+"</a></td></tr>";
     
     }
     
      
      s+="</table>";
	

     
     document.getElementById("docs").innerHTML=s;
     
      for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
         
			var checkbox = document.getElementById(doc.docid);
			var checkboxObject = new CheckedBox(doc.docid, doc.label_s, doc.uri_s, checkbox);
			
			var checkboxType = document.getElementById(checkbox_name+doc.docid);
						
			if(isProject){
				var checkboxTypeObject = new CheckedBoxShow(doc.docid, doc.label_s, doc.uri_s, checkboxType);
				var checkedType = checkedShow;
			}
			else{
				
				
				var checkboxTypeObject = new CheckedBoxHide(doc.docid, checkboxType);
				var checkedType = checkedHide;
			}
			
			
			
	
			for(var indice in checked){
				if(doc.docid == checked[indice]){
					checkbox.checked = true;
					
					break;
				
				}
	
			}
			
			for(var indice in checkedType){
				if(doc.docid == checkedType[indice]){
					checkboxType.checked = true;
					
					break;
				
				}
	
			}
			
     }
	
}


function traiterReponseDocumentsSortedByGroup(rep, isProject){
	
	document.getElementById("wait").innerHTML="";
	if(isProject){
		showString = "Show";
	}
	else
		showString = "Do not show";
	
	var response = rep.grouped.docType_s;
      
	var s="";	
        
 s+="<br>";
  
  
   s+="<table id=\"myTable\">";
  

   s+="<tr class=\"header\">   <th>"+showString+"</th>       <th>Add to favorites</th>  <th>Type</th>     <th>Publication</th> </tr>";
   
  
  for(var j=0; j<response["groups"].length; j++){
 
      var group = response["groups"][j];
     
    
      
      doclist = group.doclist;
      
     

  
      
       for(var i=0; i<doclist["docs"].length; i++){
          var doc=doclist["docs"][i];
          
          var checkbox_name;
			
			if(isProject){
				checkbox_name = "show_";
			}
			else{
				checkbox_name = "hide_";
			}
          
			s+="<tr> <td><input type=\"checkbox\" id=\""+checkbox_name+doc.docid+"\"  > </td><td><input type=\"checkbox\" id=\""+doc.docid+"\"  > </td> "+
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
			
			var checkboxType = document.getElementById(checkbox_name+doc.docid);
			
			if(isProject){
				var checkboxTypeObject = new CheckedBoxShow(doc.docid, doc.label_s, doc.uri_s, checkboxType);
				var checkedType = checkedShow;
			}
			else{
				
				
				var checkboxTypeObject = new CheckedBoxHide(doc.docid, checkboxType);
				var checkedType = checkedHide;
			}
			
			
			
	
			for(var indice in checked){
				if(doc.docid == checked[indice]){
					checkbox.checked = true;
					
					break;
				
				}
	
			}
			
			for(var indice in checkedType){
				if(doc.docid == checkedType[indice]){
					checkboxType.checked = true;
					
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


function getSelectedShow(id){
	
	checkedShow.push(id);
	
}
