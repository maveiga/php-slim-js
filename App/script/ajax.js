
function cadastrarCliente() {
    var nome = document.getElementById("nome").value;
    var idade = document.getElementById("idade").value;
    var formData = new FormData();
    formData.append("nome", nome);
    formData.append("idade", idade);

        fetch("http://localhost/react/sitecompletobootstrap/cadastros", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("nome").value = "";
                document.getElementById("idade").value = "";
                atualizarTabela()
                document.getElementById("close").click();
            })
            .catch(error => {
                console.error("Erro ao cadastrar cliente:", error);
            });
}

function editarCliente(id) {
    var nome = document.getElementById("nome").value;
    var idade = document.getElementById("idade").value;
    var formData = new FormData();
    formData.append("nome", nome);
    formData.append("idade", idade);

        fetch(`http://localhost/react/sitecompletobootstrap/editar/${id}`, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("nome").value = "";
                document.getElementById("idade").value = "";
                atualizarTabela()
                document.getElementById("close").click();
            })
            .catch(error => {
                console.error("Erro ao cadastrar cliente:", error);
            });
    }






function deletarCliente(clienteId) {
    if (confirm('Deseja realmente excluir o cliente?')) {
        fetch("http://localhost/react/sitecompletobootstrap/deletar/" + clienteId, {
            method: "DELETE"
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            atualizarTabela()

        })
        
    }


}

function atualizarTabela() {
    fetch("http://localhost/react/sitecompletobootstrap/clientes-json")
        .then(response => response.json())
        .then(data => {
            const tabela = document.querySelector('.tabela');
            tabela.innerHTML = '';
            
            if (Array.isArray(data.clientes)) {
                data.clientes.forEach(cliente => {
                    const newRow = tabela.insertRow();
                    newRow.innerHTML = `
                        <td>${cliente.nome}</td>
                        <td>${cliente.idade}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap" onclick="abrirModalEdicao(${cliente.id})">Editar</button>
                            <button type="button" class="btn btn-danger" onclick="deletarCliente('${cliente.id}')">Excluir</button>

                        </td>
                    `;
                });
            } else {
                console.error('A resposta da API não possui a propriedade "clientes" ou "clientes" não é um array válido.');
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
        });
}


function abrirModalEdicao(id) {
    fetch(`http://localhost/react/sitecompletobootstrap/editarporid/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.cliente) {
                const cliente = data.cliente;
                let id = cliente.id;
                // Preencher os campos do formulário modal com os dados do cliente
                document.getElementById('nome').value = cliente.nome;
                document.getElementById('idade').value = cliente.idade;

                // Selecionar o elemento do botão "Editar"
                let botaoEditar = document.getElementById('editar');

                // Mudar o texto do botão "Editar"
                botaoEditar.textContent = 'Editar';

                // Mudar o evento onclick do botão "Editar" para chamar a função editarCliente
                botaoEditar.onclick = function () {
                    editarCliente(id);
                };
            } else {
                console.error('Cliente não encontrado.');
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro ao buscar os dados do cliente:', error);
        });
}
