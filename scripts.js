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
      page.style.display = 'flex';
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
    return '900px';
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
            alert("Error al cambiar el nombre de usuario");
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
  if (newPassword == confirmPassword) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "change_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        alert("Contraseña cambiada exitosamente");
        showPasswordInputs()
      }
    };
    xhr.send("password=" + confirmPassword);
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
        logOut();
      }
    };
    xhr.send("hard=" + hard);
  }
}

function postComment(event, postId) {
  if (event.key === 'Enter') {
    event.preventDefault();
    var comment = event.target.value.trim();
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
    }
  }
}

function applyBlur() {
  document.getElementById("page2").classList.add('blur');
}

function removeBlur() {
  document.getElementById("page2").classList.remove('blur');
}

document.getElementById('openPopup').addEventListener('click', function () {
  document.getElementById('popupContainer').style.display = 'block';
  applyBlur();
});

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
    alert('Please fill all the fields to create a post');
    return;
  } else {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'create_post.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          document.getElementById('popupContainer').style.display = 'none';
          alert("Post successfully published");
          window.location.href = "index.php?page=1";
        }
      }
    };

    var formData = 'title=' + encodeURIComponent(title) + '&body=' + encodeURIComponent(body) + '&tags=' + encodeURIComponent(tagsString);
    xhr.send(formData);
  }
}

function toggleDateLimit() {
  var order = document.getElementById("order").value;
  var dateLimit = document.getElementById("dateLimit");

  if (order === "likes") {
    dateLimit.style.display = "block";
  } else {
    dateLimit.style.display = "none";
  }
  getPosts();
}

function getPosts() {
  var order = document.getElementById("order").value;
  var maxDate = document.getElementById("maxDate").value;
  // Realizar una solicitud AJAX para obtener los nuevos datos según el orden seleccionado
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_posts.php?order=' + order + '&dateLimit=' + maxDate, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Actualizar el contenido de tu página con los nuevos datos obtenidos
        var response = xhr.responseText;
        document.getElementById("posts").innerHTML = response;
      }
    }
  };
  xhr.send();
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

function getSavedPosts() {
  // Realizar una solicitud AJAX para obtener los nuevos datos según el orden seleccionado
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_posts.php?order=saved', true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById("postName").style.display = "none";
        document.getElementById("orderSelect").style.display = "none";
        document.getElementById("dateLimit").style.display = "none";
        document.getElementById("seeSaved").style.display = "none";
        document.getElementById("seeMyPosts").style.display = "none";
        document.getElementById("arrow").style.display = "block";
        var response = xhr.responseText;
        document.getElementById("posts").innerHTML = response;
      }
    }
  };
  xhr.send();
}

function getMyPosts() {
  // Realizar una solicitud AJAX para obtener los nuevos datos según el orden seleccionado
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_posts.php?order=myPosts', true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById("postName").style.display = "none";
        document.getElementById("orderSelect").style.display = "none";
        document.getElementById("dateLimit").style.display = "none";
        document.getElementById("seeSaved").style.display = "none";
        document.getElementById("seeMyPosts").style.display = "none";
        document.getElementById("arrow").style.display = "block";
        var response = xhr.responseText;
        document.getElementById("posts").innerHTML = response;
      }
    }
  };
  xhr.send();
}

function goBackPost() {
  document.getElementById("postName").style.display = "block";
  document.getElementById("orderSelect").style.display = "block";
  document.getElementById("seeSaved").style.display = "block";
  document.getElementById("seeMyPosts").style.display = "block";
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

  // Verificar si ya hay tres tags seleccionados
  if (selectedTags.length >= 3) {
    alert('¡Ya has seleccionado tres tags!');
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
      searchTitlePost(post);
      hideAutocompleteListPosts();
    });
    listaAutocompletado.appendChild(item);
  });
  listaAutocompletado.style.display = "block";
}

function searchTitlePost(post) {
  var xhr = new XMLHttpRequest();
  tag = document.getElementById("tagsSearch").value;
  xhr.open('GET', 'get_posts.php?order=autoComplete&title=' + post + '&tags=' + tag, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = xhr.responseText;
        document.getElementById("posts").innerHTML = response;
        document.getElementById("postName").value = "";
      }
    }
  };
  xhr.send();
}

function searchPersonalTitlePost(event) {
  if (event.key === 'Enter') {
    var postTitle = event.target.value;
    hideAutocompleteListPosts();
    searchTitlePost(postTitle);
  }
}

function markRead(element) {
  messageId = element.getAttribute("message-id");
  messageStatus = element.getAttribute("message-status");
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'change_read_status.php?message=' + messageId +'&status=' + messageStatus, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      if (messageStatus==0){
        element.setAttribute("message-status", 1)
      }else{
        element.setAttribute("message-status", 0)
      }
    }
  };
  xhr.send();
}