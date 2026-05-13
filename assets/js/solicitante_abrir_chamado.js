document.addEventListener('DOMContentLoaded', () => {
    iniciar();

    // Listener para carregar ambientes ao trocar o bloco
    document.getElementById('selectBloco').addEventListener('change', function() {
        carregarAmbientes(this.value);
    });

    // Listener do formulário
    document.getElementById('formChamado').addEventListener('submit', enviarChamado);
});

async function iniciar() {
    try {
        const resB = await fetch('api/localizacoes.php?acao=listar_blocos');
        const blocos = await resB.json();
        const selB = document.getElementById('selectBloco');
        selB.innerHTML = '<option value="">Selecione o bloco</option>';
        blocos.forEach(b => {
            selB.innerHTML += `<option value="${b.id_bloco}">${b.nome}</option>`;
        });

        const resT = await fetch('api/localizacoes.php?acao=listar_tipos');
        const tipos = await resT.json();
        const selT = document.getElementById('selectTipo');
        selT.innerHTML = '<option value="">Selecione o tipo de problema...</option>';
        tipos.forEach(t => {
            selT.innerHTML += `<option value="${t.id_tipo}">${t.nome}</option>`;
        });
    } catch (e) { console.error("Erro inicial:", e); }
}

async function carregarAmbientes(id_bloco) {
    const selA = document.getElementById('selectAmbiente');
    selA.innerHTML = '<option value="">Carregando...</option>';
    
    if (!id_bloco) {
        selA.innerHTML = '<option value="">Selecione o bloco primeiro</option>';
        return;
    }

    try {
        const res = await fetch(`api/localizacoes.php?acao=listar_ambientes&id_bloco=${id_bloco}`);
        const ambientes = await res.json();
        
        selA.innerHTML = '<option value="">Selecione o local</option>';
        ambientes.forEach(a => {
            selA.innerHTML += `<option value="${a.id_ambiente}">${a.nome}</option>`;
        });
    } catch (e) { selA.innerHTML = '<option value="">Erro ao carregar</option>'; }
}

async function enviarChamado(e) {
    e.preventDefault();
    
    // Pegando os valores EXATOS dos IDs
    const idAmbiente = document.getElementById('selectAmbiente').value;
    const idTipo = document.getElementById('selectTipo').value;
    const desc = document.getElementById('descricao').value;
    const foto = document.getElementById('foto').files[0];

    if (!idAmbiente || !idTipo || !desc) {
        alert("Por favor, preencha todos os campos obrigatórios.");
        return;
    }

    const formData = new FormData();
    formData.append('id_ambiente', idAmbiente);
    formData.append('id_tipo', idTipo);
    formData.append('descricao', desc);
    if (foto) formData.append('foto', foto);

    try {
        const response = await fetch('api/salvar_chamado.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            alert(result.message);
            window.location.href = 'solicitante_dashboard.php';
        } else {
            alert("Erro: " + result.message);
        }
    } catch (error) {
        alert("Erro de conexão com o servidor.");
    }
}