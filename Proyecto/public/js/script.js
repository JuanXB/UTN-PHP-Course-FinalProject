function loginFormSubmit() {
  var formData = $("#login").serializeArray();
  formData.push({ name: "action", value: "login" });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "index.php",
    data: serializedData,
    dataType: "json",
    success: function (response) {
      // Se limpian los msj que pueden haber
      // quedado guardados en los span del form
      limpiarSpans();

      if (response.success) {
        window.location = response.redirect;
      }
      if ("redirect" in response) {
        window.location = response.redirect;
      }
      // Si existe algun msj en la respuesta
      // es porque hubo un error de validacion
      // por lo tanto se encarga el msj en el span
      // del input al que corresponde
      if ("message" in response) {
        document.getElementById("e_" + response.param).innerHTML =
          response.message;
      }
    },
    error: function (response) {
      // Se limpian los msj que pueden haber
      // quedado guardados en los span del form
      limpiarSpans();

      if ("redirect" in response) {
        window.location = response.redirect;
      }
    },
  });
}

function registerFormSubmit() {
  var formData = $("#register").serializeArray();
  formData.push({ name: "action", value: "register" });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "index.php",
    data: serializedData,
    dataType: "json",

    success: function (response) {
      // Se limpian los msj que pueden haber
      // quedado guardados en los span del form
      limpiarSpans();

      if (response.success) {
        window.location = response.redirect;
      }
      if ("redirect" in response) {
        window.location = response.redirect;
      }
      // Si existe algun msj en la respuesta
      // es porque hubo un error de validacion
      // por lo tanto se encarga el msj en el span
      // del input al que corresponde
      if ("message" in response) {
        document.getElementById("e_" + response.param).innerHTML =
          response.message;
      }
    },
    error: function (response) {
      // Se limpian los msj que pueden haber
      // quedado guardados en los span del form
      limpiarSpans();

      if ("redirect" in response) {
        window.location = response.redirect;
      }
    },
  });
}

function deleteProfileFormSubmit() {
  var formData = $("#delete").serialize();

  $.ajax({
    type: "POST",
    url: "index.php",
    data: formData,
    dataType: "json",
    success: function (response) {
      if (response.success) {
        if ("message" in response) {
          alert(response.message);
        }
        window.location = response.redirect;
      }

      if ("redirect" in response) {
        window.location = response.redirect;
      }
    },
    error: function (response) {
      if ("redirect" in response) {
        window.location = response.redirect;
      }
    },
  });
}

function logoutFormSubmit() {
  var formData = $("#logout").serialize();
  $.ajax({
    type: "POST",
    url: "index.php",
    data: formData,
    dataType: "json",
    success: function (response) {
      window.location = response.redirect;
    },
    error: function (response) {
      if ("redirect" in response) {
        window.location = response.redirect;
      }
    },
  });
}

// Quita los textos que contengan los span del formulario
function limpiarSpans() {
  var spans = document.querySelectorAll('span[id^="e_"]');

  spans.forEach(function (span) {
    span.innerHTML = "";
  });
}
