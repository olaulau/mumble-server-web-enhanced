displayType = getURLParameter('displayType');
var url;
if(displayType !=  null) {
	url = 'index.json.php?displayType=' + displayType;
}
else {
	url = 'index.json.php';
}


$(function () {
	
	buildJsTree();
	
	setInterval(refresh, 120000);
	
	$("#refresh").click(function(){
		refresh();
	});

});


function buildJsTree() {
	// 6 create an instance when the DOM is ready
	$('#jstree').jstree({
		'core' : {
			'data' : {
				'url' : url
			}
		}
	});
}


function refresh() {
	$("#jstree").jstree("destroy");
	buildJsTree();
}


function getURLParameter(name) {
	return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}