// Document.prototype.getHTML=function(){
// 	var s =
// 	"<div id=\"document"+this.id+"\"class=\"comment\"\n\
// 	<\div>";
// 	return(s);
// };


// function revival(key, value){
//
// 	if(value.docid!==undefined){
//             return (new Document(value.docid));
//         }
//
// 	return (key, value);
// }

function getDocuments(nom, prenom){

	$.ajax({
        type:"get",
        url:"https://api.archives-ouvertes.fr/search/",
        data:"q=Stephane Doncieux&rows=10000",
        datatype:"json",
        success:function(rep){
            traiterReponseDocuments(rep);
        },
        error:function(jqXMTR, textStatus, errorThrown){
            func_err("Pb lors de la transmission des données", "inscription");
        }
    });


}

function submit() {
      $.ajax({
           type: "POST",
           url: '/admin.php',
           data:{action:'call_this'},
           success:function(html) {
             alert(html);
           }

      });
 }

function traiterReponseDocuments(rep){

	document.getElementById("wait").innerHTML="";


	var response = rep.response;
	var s="";

	 for(var i=0; i<response["docs"].length; i++){
          var doc=response["docs"][i];
          //var doc=response["org"][i];
			var chkid = "chk"+ doc.docid;
			s+="<li id=\""+doc.docid+"\"> <a href=\""+doc.uri_s+"\">"+doc.label_s+"</a><input id=\""+chkid+"\" type=\"checkbox\"></input></li>";
     }
     document.getElementById("docs").innerHTML=s;


}
