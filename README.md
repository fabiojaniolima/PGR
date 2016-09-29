# PGR (Portal de Gerenciamento Remoto) *Beta
Solução web para gerenciamento remoto de ativos de TI. Essa solução dispensa a instalação de software ou plug-in nos alvos a serem gerenciados remotamente.

> :pushpin: = Penso em utilizar o framework Laravel, com isso seria possível concluir algumas etapas e módulos facilmente.

## 1 - Objetivo
- Módulo Windows
    - [x] CPU
    - [x] RAM
    - [x] Disco Rígido
    - [x] Listar Serviços
    - [x] Stop / Start de serviço
    - [x] Listar processos
    - [x] Matar / Finalizar processos
    - [ ] Lançar processos
    - [ ] Listar e matar sessões
- Módulo Linux
    - [ ] CPU
    - [ ] RAM
    - [ ] Disco Rígido
    - [ ] Stop / Start de serviço
    - [ ] Listar e matar processos
    - [ ] Listar e matar sessões
- Módulo de banco de dados
    - Oracle
    - MySQL
    - PostgreSQl
    - SQL Server
- Módulo de consulta
    - [x] Healt Check
    - [x] Ping
    - [x] Socket
    - [x] Traceroute
- Módulo WebSercide
    - [x] Soap
    - [x] Cliente Genérico

## 2 - Preparando o servidor
> :exclamation: Os requisitos sugeridos logo abaixo representam as versões utilizadas em meu ambiente de produção, logo não poderei confirmar que a solução aqui apresentada irá rodar integralmente caso as versões utilizadas em seu ambiente sejam outras.

### 2.1 - Requisitos (recomendados)
Servidor
- Windows (desktop ou server)
- Apache 2.4.10
- PHP 5.6.24

Cliente
- Windows (desktop ou server)
- Não requer instalação alguma

## 3 - Configurando o servidor

No servidor serão necessárias aplicar duas configurações. São elas:

### 3.1 - No arquivo de configuração do Apache localize a definição
```
<Directory />
```
E altere seu bloco para:
```
<Directory />
    Options FollowSymLinks
    AllowOverride None
    Order deny,allow
    Allow from all
</Directory>
```

### 3.2 - No arquivo de php.ini adicione a linha:
```
extension=php_com_dotnet.dll
```

## 4 - Preparando a máquina cliente
Essas configurações deverão ser executadas em todas as máquinas alvos de gerenciamento remoto, ou seja, em todas as máquinas cliente.

### 4.1 - Liberando regra de firewall nos clientes
Caminho para as regras de firewall:
```
Painel de Controle > Ferramentas Administrativas > Firewall do Windows com Segurança Avançada
```

Para permitir as conexões WMI teremos que habilitar as **Regras de Entrada**:
```
Instrumentação de Gerenciamento do Windows (ASync-In)
Instrumentação de Gerenciamento do Windows (DCOM-In)
Instrumentação de Gerenciamento do Windows (WMI-In)
```

E as **Regras de Saída**:
```
Instrumentação de Gerenciamento do Windows (WMI-Saída)
```

## 5 - Considerações finais
Em ambientes Windows, para não ter problemas, sugiro que o usuário de conexão remota tenha privilégio de administrador. Caso já tenha familiaridade com WMI e o esquema de permissão de contexto do Windows, poderá configurar o nível de acesso em cada cliente para o contexto remoto a ser "manipulado".

Para maiores informações quanto a privilégio de acesso, veja: http://www-01.ibm.com/support/docview.wss?uid=swg21681046