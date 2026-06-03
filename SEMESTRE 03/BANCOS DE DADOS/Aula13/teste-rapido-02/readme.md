Read [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste06)

 

Read [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste06/listar_usuarios.php)

Read [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste06/cadastrar_usuario.php)

Read [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste06/usuarios.sql)

Read [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste06/index.html)

 

Ran terminal command: mkdir -p "/Users/filipemarra/Projetos/Faculdade/SEMESTRE 03/BANCOS DE DADOS/Aula13/teste-rapido-02"

 Analisei o `teste06` — ele já usa Prepared Statements no cadastro. Agora vou criar o **Teste Rápido 02** com um sistema de **login vulnerável** a SQL Injection e a versão **corrigida com Prepared Statements** — perfeito para demonstrar ao professor!

Created [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste-rapido-02/setup.sql)


````

````
 

Created [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste-rapido-02/index.html)


````

````


Created [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste-rapido-02/login_vulneravel.php)


````

````


Created [](file:///Users/filipemarra/Projetos/Faculdade/SEMESTRE%2003/BANCOS%20DE%20DADOS/Aula13/teste-rapido-02/login_seguro.php)


````

````
 Agora vamos configurar o banco de dados:

Ran terminal command: mysql -u root -e "source '/Users/filipemarra/Projetos/Faculdade/SEMESTRE 03/BANCOS DE DADOS/Aula13/teste-rapido-02/setup.sql'" 2>&1 || mysql -u root --password="" -e "source '/Users/filipemarra/Projetos/Faculdade/SEMESTRE 03/BANCOS DE DADOS/Aula13/teste-rapido-02/setup.sql'" 2>&1

 

Ran terminal command: which php && php --version 2>&1 | head -2

 

Ran terminal command: ls -la "/Users/filipemarra/Projetos/Faculdade/SEMESTRE 03/BANCOS DE DADOS/Aula13/teste-rapido-02/"

 Tudo criado! ✅ Aqui está o que foi feito e como rodar:

---

## 📁 Estrutura do `teste-rapido-02`

| Arquivo | Função |
|---|---|
| `setup.sql` | Cria o banco `demo_seguranca` com usuários de teste |
| `index.html` | Página principal com os dois sistemas lado a lado |
| `login_vulneravel.php` | ❌ Login **SEM** Prepared Statements (vulnerável) |
| `login_seguro.php` | ✅ Login **COM** Prepared Statements (seguro) |

---

## 🚀 Como rodar (XAMPP/MAMP)

**1. Importe o banco:**
```
phpMyAdmin → Importar → setup.sql
```

**2. Copie a pasta para o servidor:**
```
XAMPP → htdocs/teste-rapido-02/
MAMP  → htdocs/teste-rapido-02/
```

**3. Acesse no navegador:**
```
http://localhost/teste-rapido-02/
```

---

## 🎯 Demo para o Professor

**Ataque SQL Injection (sistema vulnerável):**
- Usuário: `' OR '1'='1' --`
- Senha: `qualquer`
- → Entra mesmo sem ter conta! ⚠️

**Com Prepared Statement (sistema seguro):**
- Mesmo ataque → **Bloqueado!** 🔒

**Login legítimo que funciona nos dois:**
- Usuário: `admin` / Senha: `senha123`

Made changes.