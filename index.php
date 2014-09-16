<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>LibCanvas</title>
		<link href="files/styles.css" rel="stylesheet" />
		<script src="files/js/atom.js"></script>
		<script src="files/js/libcanvas.js"></script>
                <script src="files/js/scripts.js"></script>
	</head>
	<body>
            <p>
            </p>
            <p id="list"></p>
            <div id="scene"></div>
            <p id="list_int"></p>
            <script>
    new function () {
	LibCanvas.extract();
	atom.patching(window);

        atom.dom(function () {
		c_ctrl=new Canvas.Controller({image: '04.jpg'});           
	});
    }
            </script>
            <script src="files/js/controller.js?1"></script>
            <script src="files/js/carcass.js?1"></script>
	</body>
</html>