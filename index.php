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
                <button id="rotate90" class="edit hidden">Повернуть на 90 град</button>
                <button id="edit" class="edit hidden" >Вернуться к редактированию</button>
                <input type="file" id="files" multiple/>
                <label>Сложная форма <input type="checkbox" id="complex" /></label>
            </p>
            <p id="list"></p>
            <div id="scene"></div>
            <p id="list_int"></p>
            <script>
    new function () {
	LibCanvas.extract();
	atom.patching(window);

        atom.dom('#files').addEvent('change', handleFileSelect);
        atom.dom('#edit').addEvent('click', continueEdit);
	atom.dom('#rotate90').addEvent('click', rotate90);

        atom.dom(function () {
		c_ctrl=new Canvas.Controller();           
	});
    }
            </script>
            <script src="files/js/controller.js?1"></script>
            <script src="files/js/carcass.js?1"></script>
            <script src="files/js/interrior.js?1"></script>
            <script src="files/js/ceiling.js?1"></script>
	</body>
</html>