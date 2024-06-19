
# Bate-Papo Prolixo

Este projeto implementa um bate-papo prolixo entre dois usuários em Java, utilizando orientação a objetos. As mensagens são exibidas de forma mais verbosa no bate-papo prolixo. Por exemplo, um diálogo entre Eru e Melkor seria assim:

### Exemplo de diálogo

**Prompt do Eru (Cliente):**
```
Eru::: olá Melkor, como está a sua eternidade?
```
```
A sua mensagem foi enviada para Melkor e ele respondeu:
>> Estou tocando minha eternidade.
(a mensagem original foi "olá Melkor, como está a sua eternidade?")
```

**Prompt do Melkor (Servidor):**
```
Mensagem recebida do Eru:
  >> olá Melkor, como está a sua eternidade?
Resposta para Melkor::: Estou tocando minha eternidade.
```

### Mensagem Inicial
Eru e Melkor são personagens criados por J.R.R. Tolkien.

### Executando o projeto

1. Clone o repositório.
2. Compile o projeto utilizando o Maven.
3. Inicie o servidor:
   ```bash
   java -cp target/socket-string-server-1.0-SNAPSHOT.jar br.edu.idp.tech.poo.Servidor <porta>
   ```
4. Inicie o cliente:
   ```bash
   java -cp target/socket-string-client-1.0-SNAPSHOT.jar br.edu.idp.tech.poo.Cliente <endereco-IP> <porta>
   ```

### Testes Unitários

Três testes unitários foram incluídos para verificar o funcionamento correto do bate-papo prolixo.

### Prints de Tela

Abaixo estão os prints de tela do diálogo entre duas instâncias do programa:

**Cliente (Eru):**
```
Conectado ao servidor localhost, na porta: 12345
Digite: FIM para encerrar a conexão
Servidor>> Conexão estabelecida com sucesso...

Eru::: olá Melkor, como está a sua eternidade?
Servidor>> A sua mensagem foi enviada para Melkor e ele respondeu:
>> Estou tocando minha eternidade.
(a mensagem original foi "olá Melkor, como está a sua eternidade?")
```

**Servidor (Melkor):**
```
Ouvindo na porta: 12345
Conexão estabelecida com: 127.0.0.1
Cliente>> olá Melkor, como está a sua eternidade?
Resposta para Melkor::: Estou tocando minha eternidade.
```
```
