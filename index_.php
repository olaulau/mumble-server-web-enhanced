<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>jsTree test</title>
	<!-- 2 load the theme CSS file -->
	<link rel="stylesheet" href="jstree_test/dist/themes/default/style.min.css" />
</head>
<body>
	<!-- 3 setup a container element -->
	<div id="jstree"></div>

	<!-- 4 include the jQuery library -->
	<script src="jstree_test/dist/libs/jquery.js"></script>
	<!-- 5 include the minified jstree source -->
	<script src="jstree_test/dist/jstree.min.js"></script>
	<script>
	$(function () {
  
   		// 6 create an instance when the DOM is ready
		$('#jstree').jstree({
			'core' : {
				'data' : {
					'url' : 'index.json.php'
				}
			}
		});
		
		$("#refresh").click(function(){
			$("#jstree").jstree("destroy");
			$('#jstree').jstree({
				'core' : {
					'data' : {
						'url' : 'index.json.php'
					}
				}
			});
		});

	});
	</script>
	
	<button id="refresh">REFRESH</button>
</body>
</html>

