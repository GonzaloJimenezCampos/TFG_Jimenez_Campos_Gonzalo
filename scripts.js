window.addEventListener('load', includeHTML);

function includeHTML() {
  var z, i, elmnt, file, xhttp;
  /* Loop through a collection of all HTML elements: */
  z = document.getElementsByTagName("*");
  for (i = 0; i < z.length; i++) {
    elmnt = z[i];
    /*Search for elements with a certain atrribute:*/
    file = elmnt.getAttribute("w3-include-html");
    if (file) {
      /* Make an HTTP request using the attribute value as the file name: */
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) { elmnt.innerHTML = this.responseText; }
          if (this.status == 404) { elmnt.innerHTML = "Page not found."; }
          /* Remove the attribute, and call this function once more: */
          elmnt.removeAttribute("w3-include-html");
          includeHTML();
        }
      }
      xhttp.open("GET", file, true);
      xhttp.send();
      /* Exit the function: */
      return;
    }
  }
}

function showPageProfile(pageIndex) {
  const pages = document.querySelectorAll('.page');
  const pageSelectorButtons = document.querySelectorAll('.pageOption');

  // Remover la clase 'active' de todos los botones
  pageSelectorButtons.forEach(button => {
    button.classList.remove('active');
  });

  // Añadir la clase 'active' al botón seleccionado
  pageSelectorButtons[pageIndex].classList.add('active');

  // Mostrar la página seleccionada y ocultar las demás
  pages.forEach((page, index) => {
    if (index === pageIndex) {
      page.style.display = '';
    } else {
      page.style.display = 'none';
    }
  });
}

function showPage(pageIndex) {
  const pages = document.querySelectorAll('.page');
  const pageSelectorButtons = document.querySelectorAll('.pageOption');

  // Remover la clase 'active' de todos los botones
  pageSelectorButtons.forEach(button => {
    button.classList.remove('active');
  });

  // Añadir la clase 'active' al botón seleccionado
  pageSelectorButtons[pageIndex].classList.add('active');

  // Mover las páginas hacia la izquierda o derecha según el índice de página seleccionado
  const translateValue = pageIndex * -100;
  const pagesContainer = document.querySelector('.pages');
  pagesContainer.style.transform = `translateX(${translateValue}%)`;

  // Ajustar la altura del carrusel según la página activa específica
  adjustCarouselHeight(pageIndex);
}

function adjustCarouselHeight(pageIndex) {
  const activePage = document.querySelector('.page.active');
  const carrousel = document.querySelector('.carrousel');
  carrousel.style.height = getPageHeight(pageIndex);
}

function getPageHeight(pageIndex) {
  if (pageIndex === 0) {
    return '1200px';
  } else {
    return '100%';
  }
}

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// Llamar a la función para ajustar la altura del carrusel al cargar la página
window.addEventListener('load', function () {
  // Obtener la cadena de consulta de la URL
  var queryString = window.location.search;

  // Función para obtener el valor de un parámetro específico de la cadena de consulta
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }

  // Obtener el valor del parámetro "page" de la URL
  var pageParam = getParameterByName('page', queryString);

  // Convertir el valor a un número entero
  var pageNumber = parseInt(pageParam);

  // Verificar si el parámetro "page" tiene un valor válido
  if (!isNaN(pageNumber)) {
    // Llamar a la función showPage con el valor del parámetro "page"
    showPage(pageNumber);
  } else {
    // Si el parámetro "page" no tiene un valor válido, mostrar la página predeterminada (1)
    showPage(0);
  }
});

// Llamar a la función para ajustar la altura del carrusel al cambiar de página
document.querySelectorAll('.pageOption').forEach((button, index) => {
  button.addEventListener('click', () => {
    showPage(index);
  });
});

function logOut() {
  var xhr = new XMLHttpRequest(); // Cambio de nombre de la variable
  xhr.open('POST', 'session_close.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      window.location.href = "index.php"
    }
  };
  xhr.send();
}

function changeLikeStatePost(event, element) {
  event.preventDefault();
  var idPost = element.getAttribute('post-id');
  var liked = element.getAttribute('post-liked');

  // Cambiar el estado de avisar
  var newState = liked == '1' ? '0' : '1';

  // Llamada AJAX para actualizar el estado en la base de datos
  var mensajero = new XMLHttpRequest();
  mensajero.open('POST', 'like.php', true);
  mensajero.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  mensajero.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Actualizar la imagen después de que la base de datos ha sido actualizada
      element.src = 'img/like_' + newState + '.png';
      element.setAttribute('post-liked', newState);

      var likesMensajero = new XMLHttpRequest();
      likesMensajero.open('GET', 'get_likes.php?post_id=' + idPost, true);
      likesMensajero.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          // Actualizar el número de likes en la interfaz de usuario
          var likesElement = element.parentNode.nextElementSibling;
          likesElement.innerHTML = this.responseText;
        }
      };
      likesMensajero.send();
    }
  };

  mensajero.send('post=' + idPost + '&liked=' + newState);
}

function changeLikeStateComment(event, element) {
  event.preventDefault();
  var idComment = element.getAttribute('comment-id');
  var liked = element.getAttribute('comment-liked');

  // Cambiar el estado de avisar
  var newState = liked == '1' ? '0' : '1';

  // Llamada AJAX para actualizar el estado en la base de datos
  var mensajero = new XMLHttpRequest();
  mensajero.open('POST', 'like.php', true);
  mensajero.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  mensajero.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Actualizar la imagen después de que la base de datos ha sido actualizada
      element.src = 'img/like_' + newState + '.png';
      element.setAttribute('comment-liked', newState);

      var likesMensajero = new XMLHttpRequest();
      likesMensajero.open('GET', 'get_likes.php?comment_id=' + idComment, true);
      likesMensajero.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          // Actualizar el número de likes en la interfaz de usuario
          var likesElement = element.parentNode.nextElementSibling;
          likesElement.innerHTML = this.responseText;
        }
      };
      likesMensajero.send();
    }
  };

  mensajero.send('comment=' + idComment + '&liked=' + newState);
}

function changeSaveStatePost(event, element) {
  event.preventDefault();
  var idPost = element.getAttribute('post-id');
  var saved = element.getAttribute('post-saved');

  // Cambiar el estado de avisar
  var newState = saved == '1' ? '0' : '1';

  // Llamada AJAX para actualizar el estado en la base de datos
  var mensajero = new XMLHttpRequest();
  mensajero.open('POST', 'save.php', true);
  mensajero.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  mensajero.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Actualizar la imagen después de que la base de datos ha sido actualizada
      element.src = 'img/save_' + newState + '.png';
      element.setAttribute('post-saved', newState);
    }
  };

  mensajero.send('post=' + idPost + '&saved=' + newState);
}

function deletePost(event, element) {
  event.preventDefault();
  var idPost = element.getAttribute('post-id');

  var mensajero = new XMLHttpRequest();
  mensajero.open('POST', 'delete_content.php', true);
  mensajero.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  mensajero.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      location.reload();
    }
  };

  mensajero.send('post=' + idPost);
}

function deleteComment(event, element) {
  event.preventDefault();
  var idComment = element.getAttribute('comment-id');

  var mensajero = new XMLHttpRequest();
  mensajero.open('POST', 'delete_content.php', true);
  mensajero.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  mensajero.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      location.reload();
    }
  };

  mensajero.send('comment=' + idComment);
}

function selectImage() {
  // Abrir el navegador para seleccionar una imagen
  var input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/*';
  input.onchange = function (event) {
    var selectedFile = event.target.files[0];
    if (selectedFile) {
      // Crear un objeto FormData y agregar la imagen seleccionada
      var formData = new FormData();
      formData.append('image', selectedFile);

      // Enviar la imagen al servidor utilizando AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'save_image.php', true);
      // Manejar la respuesta del servidor
      xhr.onload = function () {
        if (xhr.status === 200) {
          location.reload();
        }
      };
      xhr.send(formData);
    }
  };
  input.click(); // Simular clic en el input para abrir el navegador de archivos
}

function deleteImage() {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'delete_image.php', true);
  xhr.send();
  location.reload();
}

function showPasswordInputs() {
  var passwordInputs = document.getElementById("passwordInputs");
  if (passwordInputs.style.display === "none") {
    passwordInputs.style.display = "block";
  } else {
    passwordInputs.style.display = "none";
  }
}


function changeUsername(event) {
  if (event.key === 'Enter') {
    var newUsername = event.target.value;
    var originalUsername = event.target.defaultValue;

    if (newUsername !== originalUsername) {
      // Enviar solicitud AJAX
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "change_username.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Respuesta del servidor
          var response = xhr.responseText;
          if (response === "success") {
            event.target.defaultValue = newUsername;
            location.reload();
          } else {
            customAlert("Something went wrong, please try again", 0);
          }
        }
      };
      xhr.send("new_username=" + encodeURIComponent(newUsername));
    }
  }
}

function showPasswordInputs() {
  var passwordInputs = document.getElementById("passwordInputs");
  if (passwordInputs.style.display === "none") {
    passwordInputs.style.display = "block";
    document.getElementById("page2").style
  } else {
    passwordInputs.style.display = "none";
  }
}

function changePassword() {
  var newPassword = document.getElementById("newPassword").value;
  var confirmPassword = document.getElementById("confirmPassword").value;
  if (newPassword == confirmPassword && newPassword.trim() != "") {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "change_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var response = JSON.parse(xhr.responseText);
        if (response === true) {
          customAlert("Password changed successfully", 1);
          showPasswordInputs();
        } else {
          customAlert('The password must contain upper and lowercase, numbers and special characters', 2);
        }
      }
    };
    xhr.send("password=" + confirmPassword);
  } else {
    customAlert("Passwords do not match, please try again", 2);
  }
}

function deleteAccount(hard) {
  var confirmation = confirm("This action can not be undone. Do you want to procede?");

  if (confirmation) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_account.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var xhrImage = new XMLHttpRequest();
        xhrImage.open('POST', 'delete_image.php', true);
        xhrImage.send();
        logOut();
      }
    };
    xhr.send("hard=" + hard);
  }
}

function enterPostComment(postId) {
  if (event.key === 'Enter') {
    postComment(postId);
  }
}

function postComment(postId) {
  event.preventDefault();
  var comment = document.getElementById("comment-posting").value.trim();
  if (comment !== '') {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'post_comment.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        location.reload();
      }
    };
    xhr.send('comment=' + encodeURIComponent(comment) + '&post=' + postId);
  } else {
    customAlert("You are trying to send an empty message, write something in the comment box first", 2)
  }
}

function applyBlur() {
  document.getElementById("page2").classList.add('blur');
}

function removeBlur() {
  document.getElementById("page2").classList.remove('blur');
}

function openPopUp() {
  document.getElementById('popupContainer').style.display = 'block';
  applyBlur();
}

document.getElementById('closePopup').addEventListener('click', function () {
  document.getElementById('popupContainer').style.display = 'none';
  removeBlur();
});

function createPost(event) {
  event.preventDefault();
  var title = document.getElementById('title').value.trim();
  var body = document.getElementById('body').value.trim();
  var tags = obtainTags();
  var tagsString = tags.join(',');

  if (title === '' || body === '') {
    customAlert('You need to fill all the fields', 2);
    return;
  } else {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'create_post.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          document.getElementById('popupContainer').style.display = 'none';
          window.location.href = "index.php?page=1";
        }
      }
    };

    var formData = 'title=' + encodeURIComponent(title) + '&body=' + encodeURIComponent(body) + '&tags=' + encodeURIComponent(tagsString);
    xhr.send(formData);
  }
}

function getComments(postId) {
  var order = document.getElementById("order").value;
  // Realizar una solicitud AJAX para obtener los nuevos datos según el orden seleccionado
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_comments.php?order=' + order + '&post=' + postId, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Actualizar el contenido de tu página con los nuevos datos obtenidos
        var response = xhr.responseText;
        document.getElementById("comments").innerHTML = response;
      }
    }
  };
  xhr.send();
}

function toggleDateLimit() {
  var order = document.getElementById("order").value;
  var dateLimit = document.getElementById("dateLimit");

  if (order === "likes") {
    dateLimit.style.display = "block";
  } else {
    dateLimit.style.display = "none";
  }
  getPosts(25, 1, null, null);
}

function getPosts(initialPostSearch, actualPage, order, title) {
  if (!order) {
    var order = document.getElementById("order").value;
  }
  var maxDate = document.getElementById("maxDate").value;
  // Realizar una solicitud AJAX para obtener los nuevos datos según el orden seleccionado
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_posts.php?order=' + order + '&dateLimit=' + maxDate + '&initialPostSearch=' + initialPostSearch + '&actualPage=' + actualPage + '&title=' + title, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        if (order == "saved" || order == "myPosts") {
          goMyPosts();
        } if (title) {
          document.getElementById("postName").value = "";
        }
        var response = xhr.responseText;
        document.getElementById("posts").innerHTML = response;
      }
    }
  };
  xhr.send();
}

function goMyPosts() {
  document.getElementById("postName").style.display = "none";
  document.getElementById("orderSelect").style.display = "none";
  document.getElementById("dateLimit").style.display = "none";
  document.getElementById("seeSaved").style.display = "none";
  document.getElementById("seeMyPosts").style.display = "none";
  document.getElementById("openPopup").style.display = "none";
  document.getElementById("hamburgerButton").style.display = "none";
  document.getElementById("arrow").style.display = "block";
}

function goBackPost() {
  var screenWidth = window.innerWidth;
  if (screenWidth > 1065) {
    document.getElementById("seeSaved").style.display = "block";
    document.getElementById("seeMyPosts").style.display = "block";
    document.getElementById("openPopup").style.display = "block";
  } else {
    document.getElementById("hamburgerButton").style.display = "block";
    burgerMenu();
  }
  document.getElementById("postName").style.display = "block";
  document.getElementById("orderSelect").style.display = "block";
  document.getElementById("arrow").style.display = "none";
  toggleDateLimit();
}


function searchTags(element) {
  var input = element.value.trim();
  if (input.length > 0) {
    bringTags(input);
  } else {
    hideAutocompleteList();
  }
}

function bringTags(input) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'get_tags.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Manejar la respuesta de la solicitud
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Convertir la respuesta JSON en un array de tags
      var tags = JSON.parse(xhr.responseText);
      // Mostrar la lista de autocompletado con los tags obtenidos
      showAutocompleteList(tags);
    }
  };

  // Enviar la solicitud con el input como parámetro
  xhr.send('input=' + input);
}

function showAutocompleteList(tags) {
  var listaAutocompletado = document.getElementById("autocomplete-items");
  listaAutocompletado.innerHTML = "";
  tags.forEach(function (tag) {
    var item = document.createElement("div");
    item.classList.add("autocomplete-item");
    item.textContent = tag;
    item.addEventListener("click", function () {
      addTag(tag);
      document.getElementById("tags").value = "";
      hideAutocompleteList();
    });
    listaAutocompletado.appendChild(item);
  });
  listaAutocompletado.style.display = "block";
}

function hideAutocompleteList() {
  document.getElementById("autocomplete-items").style.display = "none";
}

function addTag(tag) {
  var tagContainer = document.getElementById('selectedTags');
  var selectedTags = tagContainer.getElementsByClassName('selectedTag');

  var tagAlreadyExists = Array.from(selectedTags).some(function (selectedTag) {
    return selectedTag.textContent === tag;
  });

  if (tagAlreadyExists) {
    customAlert('This tag has alredy been selected for this post', 2);
  } else {
    // Verificar si ya hay tres tags seleccionados
    if (selectedTags.length >= 3) {
      customAlert('The maximum number of tags has been reached', 2);
    } else {
      var newTag = document.createElement('div');
      newTag.className = 'selectedTag';
      newTag.textContent = tag;

      // Agrega un event listener para eliminar el tag al hacer clic en él
      newTag.addEventListener('click', function () {
        this.parentNode.removeChild(this); // Elimina este elemento cuando se hace clic en él
      });

      var tagContainer = document.getElementById('selectedTags');

      tagContainer.appendChild(newTag);
    }
  }
}

function obtainTags() {
  var tagContainer = document.getElementById('selectedTags');
  var selectedTags = tagContainer.getElementsByClassName('selectedTag');
  var tags = [];

  // Recorrer cada tag y obtener su contenido de texto
  for (var i = 0; i < selectedTags.length; i++) {
    var tagTexto = selectedTags[i].textContent;
    tags.push(tagTexto);
  }

  // Usar los tags en otra función
  return tags;
}

function hideAutocompleteListPosts() {
  document.getElementById("autocomplete-posts").style.display = "none";
}

function searchPosts(element) {
  var input = element.value.trim();
  if (input.length > 0) {
    bringPosts(input);
  } else {
    hideAutocompleteListPosts();
  }
}

function bringPosts(input) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'get_posts_autocomplete.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Manejar la respuesta de la solicitud
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Convertir la respuesta JSON en un array de tags
      var posts = JSON.parse(xhr.responseText);
      showAutocompleteListPosts(posts);
    }
  };

  // Enviar la solicitud con el input como parámetro
  xhr.send('input=' + input);
}

function showAutocompleteListPosts(posts) {
  var listaAutocompletado = document.getElementById("autocomplete-posts");
  listaAutocompletado.innerHTML = "";
  posts.forEach(function (post) {
    var item = document.createElement("div");
    item.classList.add("autocomplete-post");
    item.textContent = post;
    item.addEventListener("click", function () {
      getPosts(25, 1, "autoComplete", post);
      hideAutocompleteListPosts();
    });
    listaAutocompletado.appendChild(item);
  });
  listaAutocompletado.style.display = "block";
}

function searchPersonalTitlePost(event) {
  if (event.key === 'Enter') {
    var postTitle = event.target.value;
    hideAutocompleteListPosts();
    getPosts(25, 1, "autoComplete", postTitle);
  }
}

function markRead(element) {
  messageId = element.getAttribute("message-id");
  messageStatus = element.getAttribute("message-status");
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'change_read_status.php?message=' + messageId + '&status=' + messageStatus, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      if (messageStatus == 0) {
        element.setAttribute("message-status", 1)
      } else {
        element.setAttribute("message-status", 0)
      }
    }
  };
  xhr.send();
}

function checkUserExistance(event) {
  if (event.key === 'Enter') {
    var usernameSearch = encodeURIComponent(event.target.value);
    var regionCode = document.getElementById("region").value;
    window.location.href = "analysis_settings.php?username=" + usernameSearch + "&regionCode=" + regionCode;
  }
}

function autoCompleteChampion(element) {
  // Obtener el valor del input y limpiar los espacios en blanco alrededor
  var input = element.value.trim();

  // Obtener el div de autocompletado
  var autocompleteDiv = document.getElementById("autocomplete-champions");

  if (input.length > 0) {
    getJsonChampions(input, autocompleteDiv, element);
  } else {
    document.getElementById("autocomplete-champions").style.display = "none";
  }
}

function getJsonChampions(input, autocompleteDiv, element) {
  fetch('champion.json')
    .then(response => {
      // Verificar si la respuesta es correcta
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      // Parsear la respuesta como JSON y retornarla
      return response.json();
    })
    .then(data => {
      // El contenido del archivo JSON está disponible aquí como el objeto "data"
      addChampions(data, input, autocompleteDiv, element);
    })
    .catch(error => {
      // Manejar errores de red o de parseo del JSON
      console.error('There was a problem with the fetch operation:', error);
    });
}

function addChampions(data, input, autocompleteDiv, element) {
  var champions = data["data"];
  var selectedValue = document.getElementById("champion").value;
  var selectedDivId = selectedValue + "Champions";

  // Filtrar los campeones que empiezan con el texto del input
  var suggestions = champions.filter(function (champion) {
    return champion.toLowerCase().startsWith(input.toLowerCase());
  });

  // Limpiar el div de autocompletado
  autocompleteDiv.innerHTML = "";

  if (suggestions.length === 0) {
    autocompleteDiv.style.display = "none"; // Ocultar el div si no hay sugerencias
  } else {
    // Mostrar las sugerencias, pero solo las primeras 5
    suggestions.slice(0, 5).forEach(function (champion) {
      // Verificar si el campeón ya está seleccionado en alguno de los divs
      var alreadySelected = document.querySelectorAll('#' + selectedDivId + ' img[src="img/champion/' + champion.replace("'", "").replace(" ", "") + '.png"]').length > 0;

      if (!alreadySelected) {
        var suggestion = document.createElement("div");
        suggestion.textContent = champion;
        suggestion.addEventListener("click", function () {
          // Crear una imagen con el src del campeón seleccionado
          if (document.getElementById(selectedDivId).children.length >= 6) {
            customAlert("Max number of champions selected", 2);
          } else {
            var championImage = document.createElement("img");
            championImage.src = "img/champion/" + champion.replace("'", "").replace(" ", "") + ".png"; // Ajusta la ruta de la imagen según sea necesario

            // Crear un div para la imagen y agregar la imagen
            var championDiv = document.createElement("div");
            championDiv.classList.add("selectedChampion");
            championDiv.appendChild(championImage);

            // Agregar el div al div existente con id correspondiente al valor del select
            var selectedChampionDiv = document.getElementById(selectedDivId);
            selectedChampionDiv.appendChild(championDiv);

            // Agregar evento de clic al div de la imagen para borrarlo
            championDiv.addEventListener("click", function () {
              selectedChampionDiv.removeChild(championDiv);
            });

            // Ocultar el div de autocompletado después de seleccionar una sugerencia
            autocompleteDiv.style.display = "none";
          }
        });
        autocompleteDiv.appendChild(suggestion);
        autocompleteDiv.style.display = "block"; // Mostrar el div si hay sugerencias
      }
    });
  }
}


function toggleChampionDiv() {
  var selectedValue = document.getElementById("champion").value;
  var selectedDivId = selectedValue + "Champions";
  document.getElementById("championInput").value = "";

  // Ocultar todos los divs de campeones
  var allChampionDivs = document.querySelectorAll(".selectedChampions");
  allChampionDivs.forEach(function (div) {
    div.style.display = "none";
  });

  // Mostrar el div correspondiente al valor seleccionado en el select
  var selectedChampionDiv = document.getElementById(selectedDivId);
  if (selectedChampionDiv) {
    selectedChampionDiv.style.display = "flex";
  }
  isAnalysisReady()
}

function toggleActive(button) {
  var soloButton = document.getElementById('soloButton');
  var flexButton = document.getElementById('flexButton');

  // Verificar si el botón presionado es el "Solo"
  if (button.id === 'soloButton') {
    soloButton.style.backgroundColor = 'green';
    soloButton.setAttribute('active', '1'); // Cambiar el valor de active a 1
    // Si el botón "Flex" está en verde, se cambia a rojo
    if (flexButton.style.backgroundColor === 'green') {
      flexButton.style.backgroundColor = 'red';
      flexButton.setAttribute('active', '0'); // Cambiar el valor de active a 0
    }
  }
  // Verificar si el botón presionado es el "Flex"
  else if (button.id === 'flexButton') {
    flexButton.style.backgroundColor = 'green';
    flexButton.setAttribute('active', '1'); // Cambiar el valor de active a 1
    // Si el botón "Solo" está en verde, se cambia a rojo
    if (soloButton.style.backgroundColor === 'green') {
      soloButton.style.backgroundColor = 'red';
      soloButton.setAttribute('active', '0'); // Cambiar el valor de active a 0
    }
  }
  isAnalysisReady();
}


function hoverRole(element) {
  element.src = "img/roles/" + element.role + "-hover.png";
}

function showRoles() {
  if (document.getElementById("roles").style.display == "none") {
    document.getElementById("roles").style.display = "flex";
  } else {
    document.getElementById("roles").style.display = "none";
  }
}

function unhoverRole(element) {
  element.src = "img/roles/" + element.role + ".png";
}


function selectRole(element) {
  newRole = element.src;
  document.getElementById("roleImg").src = newRole.replace("-hover", "");
  document.getElementById("roleImg").setAttribute("role", element.role)
  showRoles();
  isAnalysisReady();
}

function isAnalysisReady() {
  numberMatches = document.getElementById("numberMatches").value;
  var focusChampionsDiv = document.getElementById("focusChampions");
  var numberOfChildren = focusChampionsDiv.querySelectorAll(".selectedChampion").length;
  soloQueue = document.getElementById("soloButton").getAttribute("active");
  flexQueue = document.getElementById("flexButton").getAttribute("active");
  button = document.getElementById("analysisButton");
  if (numberMatches < 1 || numberMatches > 20) {
    button.setAttribute("onclick", "customAlert('The number of matches must be between 1 and 20', 2)");
  } else if (numberOfChildren == 0 && focusChampionsDiv.style.display === "flex") {
    button.setAttribute("onclick", "customAlert('You need to select a champion for the focus champion analysis', 2)");
  } else if ((soloQueue == "1" || flexQueue == "1") && document.getElementById("roleImg").getAttribute("role") != "unselected") {
    button.setAttribute("onclick", "getSettingsInfo()");
  } else {
    button.setAttribute("onclick", "customAlert('You need to select a number of matches, queue and role before analyzing', 2)");
  }
}

function getSettingsInfo() {
  numberMatches = document.getElementById("numberMatches").value;
  soloQueue = document.getElementById("soloButton").getAttribute("active");
  flexQueue = document.getElementById("flexButton").getAttribute("active");
  championSelection = document.getElementById("champion").value;
  selectedChampions = document.getElementById(championSelection + "Champions").querySelectorAll(".selectedChampion");
  var imageSources = [];
  selectedChampions.forEach(function (div) {
    var img = div.querySelector('img');
    imageSources.push(img.src.split("/").pop().replace(".png", ""));
  });

  // Ahora imageSources contiene los src de todas las imágenes dentro de los divs seleccionados
  roleSelected = document.getElementById("roleImg").getAttribute("role");

  //Ahora cogemos el username y el regionCode
  var urlParams = new URLSearchParams(window.location.search);
  var username = urlParams.get('username');
  var regionCode = urlParams.get('regionCode');

  // Crear un objeto con los datos a enviar
  var data = {
    username: username,
    regionCode: regionCode,
    numberMatches: numberMatches,
    soloQueue: soloQueue,
    flexQueue: flexQueue,
    championSelection: championSelection,
    selectedChampions: imageSources,
    roleSelected: roleSelected
  };

  var queryString = encodeURIComponent(JSON.stringify(data));

  window.location.href = "analysis.php?" + queryString;
}

function customAlert(message, category) {
  // Crear un nuevo div para la alerta
  var alertDiv = document.createElement("div");
  alertDiv.classList.add("alert");

  // Determinar los estilos según la categoría recibida
  switch (category) {
    case 0: // Category 1
      alertDiv.style.backgroundColor = "#ff6d629c"; // Red
      alertDiv.style.borderColor = "#f44336"; // Dark Red
      break;
    case 1: // Category 2
      alertDiv.style.backgroundColor = "#4CAF509c"; // Green
      alertDiv.style.borderColor = "#008000"; // Dark Green
      break;
    case 2: // Otros casos
      alertDiv.style.backgroundColor = "#ff98009c"; // Orange
      alertDiv.style.borderColor = "#e68a00"; // Dark Orange
      break;
  }

  // Crear el span para cerrar la alerta
  var closeSpan = document.createElement("span");
  closeSpan.classList.add("closebtn");
  closeSpan.innerHTML = "&times;";

  // Agregar el evento de cerrar al hacer clic en el span
  closeSpan.onclick = function () {
    this.parentElement.style.display = 'none';
  };

  // Agregar el mensaje al div de la alerta
  alertDiv.innerHTML = message;

  // Agregar el span de cerrar al div de la alerta
  alertDiv.appendChild(closeSpan);

  // Obtener el contenedor de alertas por su id
  var alertsContainer = document.getElementById("alerts");

  // Insertar la alerta como primer hijo en el contenedor
  alertsContainer.insertBefore(alertDiv, alertsContainer.firstChild);
}

function markAllAsRed() {
  var checkboxes = document.querySelectorAll(".markAsRead");
  checkboxes.forEach(function (checkbox) {
    if (!checkbox.checked) {
      checkbox.checked = true;
      checkbox.dispatchEvent(new Event('change'))
    }
  });
  customAlert("All messages have been marked as read", 1)
}

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
}

function burgerMenu() {
  var div = document.querySelector('.hamburgerOptions');
  var inputs = div.querySelectorAll('input');
  inputs.forEach(function (input) {
    if (input.style.display === 'none') {
      input.style.display = 'block'; // Muestra el input
    } else {
      input.style.display = 'none'; // Oculta el input
    }
  });
}