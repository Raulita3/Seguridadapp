// Escucha el evento "submit" del formulario con id="registroForm"
document.getElementById("registroForm").addEventListener("submit", (event) => {
  event.preventDefault(); // Evita que el formulario se envíe automáticamente

  // Obtiene y limpia los valores del formulario
  const nombre = cleanInput(document.querySelector("#nombre").value.trim());
  const email = cleanInput(document.querySelector("#email").value.trim());
  const edad = document.querySelector("#edad").value.trim();
  const fechaNacimiento = document
    .querySelector("#fecha_nacimiento")
    .value.trim();
  const telefono = document.querySelector("#telefono").value.trim();
  const tarjeta = document.querySelector("#tarjeta").value.trim();
  const password = document.querySelector("#contrasena").value.trim();
  const repeatPassword = document
    .querySelector("#repetir_contrasena")
    .value.trim();

  // ✅ Validación: Todos los campos son obligatorios
  if (
    !nombre ||
    !email ||
    !edad ||
    !fechaNacimiento ||
    !telefono ||
    !tarjeta ||
    !password ||
    !repeatPassword
  ) {
    alert("Todos los campos son obligatorios");
    return;
  }

  // Validar formato de email
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(email)) {
    alert("Correo electrónico inválido");
    return;
  }
  //const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  // if (!emailRegex.test(email)) {
  // alert("Correo electrónico inválido");
  // return;
  //}   Genera un error al no permitir caracteres especiales ya que el @ es un caracter especial
  //y la validacion del correo requiere que tenga @ lo cual es contrario a la limpieza de
  // caracteres especiales

  // Edad: solo enteros positivos
  if (!/^[0-9]+$/.test(edad) || parseInt(edad) <= 0) {
    alert("Edad inválida");
    return;
  }

  // Fecha de nacimiento no debe ser futura
  const fechaActual = new Date();
  const fechaNac = new Date(fechaNacimiento);
  if (fechaNac > fechaActual) {
    alert("La fecha de nacimiento no puede ser futura");
    return;
  }

  // Teléfono: solo 10 dígitos
  if (!/^\d{10}$/.test(telefono)) {
    alert("El teléfono debe contener 10 dígitos numéricos");
    return;
  }

  // Tarjeta: solo 16 dígitos
  if (!/^\d{16}$/.test(tarjeta)) {
    alert("La tarjeta de crédito debe contener 16 dígitos");
    return;
  }

  // Contraseña segura
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=/]).{8,}$/;
  if (!passwordRegex.test(password)) {
    alert(
      "La contraseña debe tener al menos 8 caracteres, una letra, un número y un carácter especial"
    );
    return;
  }

  // ✅ Validación: Confirmación de contraseña
  if (password !== repeatPassword) {
    alert("Las contraseñas no coinciden");
    return;
  }

  // 🚀 Si todas las validaciones pasan, se envía el formulario
  console.log("Formulario validado. Enviando datos...");
  document.querySelector("#registroForm").submit(); // Envío manual
});

// ✂️ Función para limpiar caracteres no deseados de las entradas (como espacios, comillas y arrobas)
function cleanInput(input) {
  return input.replace(/[\'@\s]/g, "");
}
