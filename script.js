const products = [
    { id: 1, nome: "Calça Cargo Jogger Azul", categoria: "cargos", preco: 189.90, imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeVIauo4CxNwDPAS-q1aDZeCbUN1wu848V2kXwFeJHQQ&s" },
    { id: 2, nome: "Calça Cargo Oversized Preta", categoria: "cargos", preco: 219.90, imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTdUVVhRG1-o70rBUPx_xZpeJ6oAZV17RKhvCkVRWeQTw&s=10" },
    { id: 3, nome: "Camisa Oversized Street", categoria: "camisas", preco: 119.90, imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTz3hzOuce720r-laFfMyWxqdxaV8sp1Mbe0mK1LHAQeA&s=10" },
    { id: 4, nome: "Camisa Algodão Premium", categoria: "camisas", preco: 139.90, imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQy5BBP1-Bj81BqnsiI8RT5XnXtMURFY7rfcxY1DOq5xg&s=10" },
    { id: 5, nome: "Cachecol Urbano Lã Azul", categoria: "cachecois", preco: 89.90, imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6qEDC3oSmmiKmeg2t1Uf1vwJmo71RxFMJUC0HsLiTFQ&s" },
    { id: 6, nome: "Cachecol Xadrez Moderno", categoria: "cachecois", preco: 99.90, imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRh_phsezeVX15bjLJCvXslAo2E3UztdMW7TIZUoXmEg&s" }
];

function money(value) {
    return value.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
}

function renderProducts(filter = "todos") {
    const area = document.getElementById("products");
    if (!area) return;

    const list = filter === "todos" ? products : products.filter(p => p.categoria === filter);
    area.innerHTML = "";

    list.forEach(p => {
        const card = document.createElement("article");
        card.classList.add("product");
        card.innerHTML = `
            <div class="product-img">
                <img src="${p.imagem}" alt="${p.nome}">
            </div>
            <div class="product-info">
                <h3>${p.nome}</h3>
                <p>Modo Urbano</p>
                <div class="price">${money(p.preco)}</div>
                <a href="contato.html" class="btn add" style="text-align:center;">Tenho Interesse</a>
            </div>
        `;
        area.appendChild(card);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    renderProducts();

    // Menu Mobile
    const menuBtn = document.getElementById("menuBtn");
    const nav = document.getElementById("nav");
    if (menuBtn && nav) {
        menuBtn.addEventListener("click", () => nav.classList.toggle("open"));
    }

    // Filtros
    const buttons = document.querySelectorAll(".filter");
    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            buttons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            renderProducts(btn.dataset.filter);
        });
    });

    // Filtro por URL da Home
    const category = new URLSearchParams(window.location.search).get("categoria");
    if (category) {
        const btn = document.querySelector(`[data-filter="${category}"]`);
        if (btn) btn.click();
    }
});