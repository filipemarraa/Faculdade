
# ContactManager - CRUD em Objective-C

## Descrição

Este é um aplicativo simples de gerenciamento de contatos desenvolvido em Objective-C para iOS. O aplicativo permite adicionar, visualizar, editar e excluir contatos usando uma interface baseada em tabela (`UITableView`).

## Funcionalidades

- **Adicionar Contato:** Use o botão `+` na barra de navegação para adicionar um novo contato. Insira o nome e o número de telefone e salve.
- **Visualizar Contatos:** A lista de contatos é exibida em uma `UITableView`.
- **Editar Contato:** Toque em um contato para editar seu nome e número de telefone.
- **Excluir Contato:** No mesmo alerta de edição, você pode optar por excluir o contato.

## Requisitos

- **macOS:** Requer um Mac com Xcode instalado.
- **Xcode:** Versão 11.0 ou superior.
- **iOS:** O aplicativo é compatível com iOS 11.0 ou superior.

## Como Compilar e Executar

### Passos para Compilação

1. **Clone o Repositório:**
   Abra o terminal e clone o repositório para o seu computador:
   ```bash
   git clone <URL_DO_REPOSITORIO>
   ```

2. **Abra o Projeto no Xcode:**
   Navegue até a pasta do projeto e abra o arquivo `.xcodeproj` com o Xcode.

3. **Compilar e Executar:**
   Clique no botão "Play" no Xcode para compilar e executar o aplicativo no simulador ou em um dispositivo físico conectado.

### Exemplo de Uso

1. **Adicionar um Contato:**
   - Toque no botão `+` na barra de navegação.
   - Insira um nome e um número de telefone.
   - Toque em "Salvar" para adicionar o contato à lista.

2. **Editar ou Excluir um Contato:**
   - Toque em um contato na lista.
   - Edite as informações do contato ou toque em "Deletar" para removê-lo.

## Estrutura do Código

- **`ViewController.m`**: Contém a lógica para gerenciar a interface do usuário e a funcionalidade CRUD.
  - **`viewDidLoad:`**: Configura a interface e inicializa os dados.
  - **`addContact:`**: Lida com a adição de novos contatos.
  - **`editContactAtIndex:`**: Lida com a edição e exclusão de contatos.

## Licença

Este projeto é de uso livre para fins educacionais e de aprendizado.
