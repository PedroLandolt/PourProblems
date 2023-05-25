# PourProblems - Plataforma de Reclamações de Vinho

Bem-vindo ao repositório do PourProblems, um website dedicado a reclamações de vinhos. Este projeto foi desenvolvido como parte do curso de Linguagens e Tecnologias Web (LTW) e tem como objetivo fornecer uma plataforma para os usuários compartilharem suas experiências e problemas relacionados a vinhos.

## Funcionalidades Principais

O PourProblems oferece as seguintes funcionalidades principais:

### Para todos os usuários:

- Registrar uma nova conta.
- Fazer login e logout.
- Editar seu perfil, incluindo nome, nome de usuário, senha e e-mail.

### Para clientes:

- Submeter um novo ticket, escolhendo opcionalmente um departamento (por exemplo, "Contabilidade").
- Listar e acompanhar os tickets que eles submeteram.
- Responder a perguntas sobre seus tickets e adicionar mais informações aos tickets já submetidos.

### Para agentes (que também são clientes):

- Listar tickets de seus departamentos e filtrá-los de diferentes maneiras, como por data, por agente atribuído, por status, por prioridade, por hashtag.
- Alterar o departamento de um ticket, caso o cliente tenha escolhido o departamento errado.
- Atribuir um ticket a si mesmos ou a outro agente.
- Alterar o status de um ticket. Os tickets podem ter vários status, como aberto, atribuído, fechado; alguns podem mudar automaticamente, como o ticket mudar para "atribuído" após ser atribuído a um agente.
- Editar facilmente as hashtags de um ticket, permitindo adicionar (com autocompletar) e remover hashtags.
- Listar todas as alterações feitas em um ticket, como mudanças de status, atribuições, edições.
- Gerenciar as perguntas frequentes (FAQ) e utilizar uma resposta da FAQ para responder a um ticket.

### Para administradores (que também são agentes):

- Promover um cliente para agente ou administrador.
- Adicionar novos departamentos, status e outras entidades relevantes.
- Atribuir agentes aos departamentos.
- Controlar todo o sistema.

## Tecnologias Utilizadas

O PourProblems foi desenvolvido utilizando as seguintes tecnologias:

- HTML: Para a estruturação e marcação do conteúdo do site.
- CSS: Para a estilização e design do site, garantindo uma aparência limpa e consistente.
- PHP: Para o desenvolvimento do backend e a lógica de negócio do PourProblems.
- JavaScript: Para aprimorar a interatividade do site e fornecer funcionalidades dinâmicas aos usuários.
- Ajax/JSON: Para facilitar a comunicação assíncrona entre o cliente e o servidor.
- PDO/SQL: Utilizando SQLite como banco de dados para armazenar informações sobre usuários, tickets e interações.

## Configuração do Ambiente de Desenvolvimento

Siga as instruções abaixo para configurar o ambiente de desenvolvimento do PourProblems:

1. Certifique-se de ter o PHP e o SQLite instalados em sua máquina local.

2. Clone este repositório em seu ambiente de desenvolvimento:

- git clone https://github.com/PedroLandolt/pourproblems.git
- abrir a pasta 'project-ltw05g01' no vscode
- correr, num terminal wsl, 'php -S localhost:9000'

4. Abra o PourProblems em seu navegador:

- localhost:9000

## Segurança e Boas Práticas

Para garantir a segurança do PourProblems, foram adotadas as seguintes medidas:

- Proteção contra ataques de SQL injection, XSS e CSRF.
- Armazenamento seguro de senhas, seguindo princípios recomendados.
- Implementação de práticas de codificação organizada e consistente.

## Contribuição

Se você deseja contribuir para o desenvolvimento do PourProblems, fique à vontade para criar um fork deste repositório e enviar pull requests com suas melhorias.

Certifique-se de seguir as diretrizes de contribuição e fornecer uma descrição clara das alterações que você fez.

## Equipe

- João Coelho (up202004846)
- João Mota (up202108677)
- Pedro Landolt (up202103337)

   
