<?php


echo '
       <div class="container">
        <label for="portinput">Dato a enviar por POST:</label>
        <input type="text" id="postInput" value="Hola desde el cliente!">
        <button id="fetchPostData" class="post">Enviar Datos</button>
        <div id="postResult" class="result-box">Esperando datos POST... ' ;

echo "<h2>$titulo</h2>";    

require BASE_PATH ."/app/Views/components/tabla.php"; 

echo '</div>
	</div>

    <script src="js/api.js"></script>';

