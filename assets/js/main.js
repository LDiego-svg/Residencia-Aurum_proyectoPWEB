function updateLoginArea() {
  const loginArea = document.getElementById('loginArea');
  const usuario = localStorage.getItem('usuarioAurum');

  if (usuario) {
    loginArea.innerHTML = `
      <span>Hola, <strong>${usuario}</strong></span>
      <button id="logoutBtn" class="btn btn-link btn-sm">Cerrar sesión</button>
    `;
    document.getElementById('logoutBtn').addEventListener('click', () => {
      localStorage.removeItem('usuarioAurum');
      updateLoginArea();
    });
  } else {
    loginArea.innerHTML = `<a href="${getBasePath()}pages/registro.html" class="btn btn-dorado btn-sm">Registrarse</a>`;
  }
}

function getBasePath() {
  const currentPath = window.location.pathname;
  // Dependiendo de dónde esté la página, las rutas cambian
  if (currentPath.endsWith('index.html') || currentPath.endsWith('/')) {
    return './';
  }
  if (currentPath.includes('/pages/')) {
    return '../';
  }
  return './';
}

document.addEventListener('DOMContentLoaded', updateLoginArea);
