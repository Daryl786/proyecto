
        // Obtener referencias a los elementos del DOM
        const fetchPostDataBtn = document.getElementById('fetchPostData');
        const postInput = document.getElementById('postInput');
        const postResultDiv = document.getElementById('postResult');
	        
		// --- Asignar Event Listeners a los botones ---
        fetchPostDataBtn.addEventListener('click', () => {
            const dataToPost = postInput.value;
            postToApi(dataToPost);
        });


        // --- Funciones para interactuar con la API PHP ---
        /**
         * Realiza una petición GET a la API PHP.
         */
        /**
         * Realiza una petición POST a la API PHP.
         * @param {string} dataToSend - El dato a enviar al servidor.
         */
        async function postToApi(dataToSend) {
            postResultDiv.textContent = 'Enviando datos POST...';
            try {
                // Creamos un objeto FormData para enviar datos como un formulario HTML
                // Esto es adecuado para datos simples clave-valor y $_POST en PHP
                const formData = new FormData();
                formData.append('miDato', dataToSend); // 'miDato' será la clave en $_POST en PHP

                // Petición con FormData
                const response = await fetch('/apicategorias', {
                    method: 'POST',
                    body: formData // Fetch automáticamente configura Content-Type para FormData
                });

                if (!response.ok) {
                    throw new Error(`Error en la petición POST: ${response.status} ${response.statusText}`);
                }

                const VerDatos = await response.json();

				crearListaDeArticulos(VerDatos.data);

            } catch (error) {
                console.error('Error al enviar datos:', error);
                postResultDiv.innerHTML = `<span class="error-message">Error: ${error.message}</span>`;
            }
        }

// Funcion que muestra una lista de los datos enviados desde el servidor
// el Controlador ApiController, es en el metodo index que genera el resultado.
   
function crearListaDeArticulos(data) {

  // Verificamos si los datos son válidos
  if (!Array.isArray(data) || data.length === 0) {
    console.error("Los datos no son un array válido o están vacíos.");
    return;
  }
  
postResultDiv.innerHTML = ''; // Limpiamos el contenedor

  // Creamos el elemento <ul>
  const lista = document.createElement('ul');

  // Iteramos sobre los datos para crear cada <li>
  data.forEach(subarray => {
    subarray.forEach(objeto => {
      // Creamos un <li> por cada post
      const listItem = document.createElement('li');
      
      // Asignamos el título del post como texto del <li>
      listItem.textContent = objeto.title;
      
      // Agregamos el <li> a la <ul>
      lista.appendChild(listItem);
    });
  });

  // Agregamos la <ul> al contenedor final
  postResultDiv.appendChild(lista);
}


