document.addEventListener('DOMContentLoaded', function () {
    
    // ==========================================
    // MÁSCARA DO CPF (000.000.000-00)
    // ==========================================
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function (e) {
            let valor = e.target.value.replace(/\D/g, '');
            if (valor.length > 11) valor = valor.slice(0, 11);

            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            
            e.target.value = valor;
        });
    }

    // ==========================================
    // MÁSCARA DO TELEFONE ((00) 00000-0000)
    // ==========================================
    const telInput = document.getElementById('telefone');
    if (telInput) {
        telInput.addEventListener('input', function (e) {
            // Remove tudo o que não for número
            let valor = e.target.value.replace(/\D/g, '');
            
            // Limita a 11 números (DDD + 9 dígitos)
            if (valor.length > 11) valor = valor.slice(0, 11);

            // Formata o DDD: (00) ...
            valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2');
            
            // Coloca o traço antes dos últimos 4 números
            valor = valor.replace(/(\d)(\d{4})$/, '$1-$2');

            e.target.value = valor;
        });

    }

        // ==========================================
        // MÁSCARA DO CEP (00000-000)
        // ==========================================
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('input', function (e) {
                let valor = e.target.value.replace(/\D/g, '');
                if (valor.length > 8) valor = valor.slice(0, 8);
                
                valor = valor.replace(/^(\d{5})(\d)/, '$1-$2');
                e.target.value = valor;
        });

    }

    
});