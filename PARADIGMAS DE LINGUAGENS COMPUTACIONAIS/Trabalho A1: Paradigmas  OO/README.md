
# **ContactManager - CRUD em Objective-C**

## **Descrição**

Este é um aplicativo de gerenciamento de contatos desenvolvido em Objective-C para iOS. O aplicativo permite adicionar, visualizar, editar e excluir contatos utilizando uma interface de tabela (`UITableView`), demonstrando a aplicação de conceitos de Programação Orientada a Objetos (POO).

## **Funcionalidades**

- **Adicionar Contato:** Utilize o botão `+` na barra de navegação para adicionar um novo contato. Insira o nome e o número de telefone e salve.
- **Visualizar Contatos:** A lista de contatos é exibida em uma `UITableView`.
- **Editar Contato:** Toque em um contato na lista para editar seu nome e número de telefone.
- **Excluir Contato:** No mesmo alerta de edição, você pode optar por excluir o contato.

## **Requisitos**

- **macOS:** Requer um Mac com Xcode instalado.
- **Xcode:** Versão 11.0 ou superior (recomendado Xcode 12 ou superior).
- **iOS:** Compatível com iOS 11.0 ou superior.

## **Como Compilar e Executar**

### **Passos para Compilação**

1. **Clone o Repositório:**
   Abra o terminal e clone o repositório para o seu computador:
   ```bash
   git clone https://github.com/filipemarraa/Faculdade/tree/main/PARADIGMAS%20DE%20LINGUAGENS%20COMPUTACIONAIS/Trabalho%20A1%3A%20Paradigmas%20%20OO
   ```

2. **Abra o Projeto no Xcode:**
   - Navegue até a pasta do projeto e abra o arquivo `.xcodeproj` com o Xcode.

3. **Selecione o Dispositivo de Execução:**
   - No Xcode, selecione o dispositivo no qual deseja testar o aplicativo. Pode ser um simulador de iPhone ou um dispositivo físico conectado.

4. **Compilar e Executar:**
   - Clique no botão "Run" (ícone de "Play" no canto superior esquerdo do Xcode) ou pressione `Cmd + R` para compilar e executar o aplicativo.

### **Exemplo de Uso**

1. **Adicionar um Contato:**
   - Toque no botão `+` na barra de navegação.
   - Insira um nome e um número de telefone.
   - Toque em "Salvar" para adicionar o contato à lista.

2. **Editar ou Excluir um Contato:**
   - Toque em um contato na lista.
   - Edite as informações do contato ou toque em "Deletar" para removê-lo.

## **Estrutura do Código**

O código principal do aplicativo está dividido nos seguintes arquivos:

- **`ViewController.h` e `ViewController.m`:** 
  - **`ViewController.h`** define as propriedades e protocolos necessários para gerenciar o `UITableView` e a lista de contatos.
  - **`ViewController.m`** implementa a lógica da interface do usuário e a funcionalidade CRUD.

### **Principais Métodos e Funções:**

- **`viewDidLoad`:** Método chamado quando a view é carregada. Configura a `UITableView` e inicializa o array `contacts` que armazenará os contatos.
- **`addContact`:** Método que exibe um `UIAlertController` para adicionar um novo contato.
- **`editContactAtIndex`:** Método que permite editar ou excluir um contato selecionado da lista.
- **`numberOfRowsInSection` e `cellForRowAtIndexPath`:** Métodos do protocolo `UITableViewDataSource` responsáveis por exibir a lista de contatos na `UITableView`.

### **Como o Paradigma de Programação Orientada a Objetos é Utilizado:**

- A classe `ViewController` gerencia a funcionalidade e a lógica do aplicativo.
- Utiliza encapsulamento para controlar os dados dos contatos por meio da propriedade `contacts`.
- O aplicativo faz uso de instâncias (`self.contacts`, `self.tableView`) para representar objetos do modelo de POO.

## **Estrutura de Arquivos**

- `ViewController.h` - Declara as propriedades e métodos da `ViewController`.
- `ViewController.m` - Implementa a lógica para o CRUD de contatos.
- `Main.storyboard` - Define a interface visual do aplicativo.

## **Licença**

Este projeto é de uso livre para fins educacionais e de aprendizado.
