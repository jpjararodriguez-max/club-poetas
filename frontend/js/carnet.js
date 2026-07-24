// ================================
// carnet.js (VERSIÓN CORRECTA)
// ================================

// JS SOLO controla comportamiento visual
// Los datos ya vienen desde PHP

// ================================
// MOSTRAR ICONO VERIFICADO
// ================================

document.addEventListener("DOMContentLoaded", () => {
    const perfil = document.getElementById("perfilTipo")?.textContent.trim();
    const iconoVerificado = document.querySelector(".verificado");

    if (!iconoVerificado) return;

    if (perfil === "PERIODISTA DEPORTIVO") {
        iconoVerificado.style.display = "block";
    } else {
        iconoVerificado.style.display = "none";
    }
 });