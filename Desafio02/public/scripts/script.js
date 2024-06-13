const fetchProdutos = () => {
    let url = 'http://localhost:8080/Desafio02/src/index.php/produtos/listar';
    fetch(url)
        .then(response => response.json())
        .then(product => {
            console.log(product)
        })
}

window.onload = function() {
    fetchProdutos();
};