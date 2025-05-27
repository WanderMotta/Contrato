
# Guia de Desenvolvimento do Projeto

## Fases do Projeto

### Fase 1: Configuração Inicial
- Configurar acesso ao banco de dados MySQL com as credenciais fornecidas.
- Validar conectividade com as tabelas:
  - Mestre: `view_contratos`.
  - Detalhes: `view_efetivo_previsto`, `view_rel_insumos_contratos`.
- Criar uma estrutura básica para o formulário inicial (HTML responsivo com CSS).

---

### Fase 2: Desenvolvimento do Formulário
- Criar formulário para seleção de "Número do Contrato".
- Implementar `GROUP BY` no campo `idcontrato` e ordenar alfabeticamente por cliente.
- Adicionar botão de envio.

---

### Fase 3: Criação da Página Principal
- Criar o template único em HTML para o relatório.
- Dividir a página em quatro seções:
  1. **Identificação do Cliente**.
  2. **Efetivo Contratado**.
  3. **Insumos Utilizados**.
  4. **Observações**.
- Incluir título "COMUNICADO INTERNO (CI)".

---

### Fase 4: Funcionalidades de Exportação
- Adicionar botões para exportação em Excel e impressão em HTML.
- Garantir a responsividade e design conforme o CSS fornecido.

---

### Fase 5: Validação e Testes
- Validar o layout e responsividade em diferentes dispositivos.
- Testar as funcionalidades de exportação e impressão.
- Corrigir bugs e realizar ajustes finais.

---

### Fase 6: Documentação
- Gerar documentação final em Markdown para referência futura.

---

## Guia de Sequência
1. Configurar e validar o acesso ao banco de dados.
2. Criar o formulário inicial para seleção de contratos.
3. Desenvolver as sessões do relatório em HTML com base no layout especificado.
4. Implementar botões de exportação e impressão.
5. Testar e corrigir erros.
6. Finalizar e documentar o projeto.

---

## Estilo CSS Recomendado
Utilizar as cores e gradientes descritos no documento original.

## Exportação e Links
Os botões de exportação para Excel e HTML devem estar visíveis e funcionais na página.

