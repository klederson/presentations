# Assunto
Javascript, Web, WebUI, Single Page Applications, AngularJS, Rest, ORM, Patterns

# Título
ModelCore - Agora você tem tempo pra cerveja

# Resumo
O ModelCore é um ORM/Data Mapper/Active Record para AngularJS ( Javascript ) REST.
Agora você pode, de forma muito fácil e simples, mapear sua API e manipular os dados nela eficientemente, sem toneladas de códigos e seguindo padrões web por padrão.

# Descrição
Criado a partir da necessidade de ter alguma ferramenta que facilitasse e tornasse transparente o processo de CRUD mas principalmente persistencia de metodos de uma forma simples, padronizada e centralizada.

Single Page Application é a bola da vez eu com uma maniuplação de dados decente é possível construir aplicações poderosas, modernas e muito divertidas.

```javascript
//Cadastro
var palestrante = new Palestrantes();

palestrante.nome = "Klederson Bueno";
palestrante.email = "klederson@klederson.com"
palestrante.palestra = "ModelCore - Agora você tem tempo pra cerveja"

palestrante.$save();

//Saudações
plateia.$find().success(function() {
  while(plateia.$fetch()) {
    console.log("Bem vindo(a): " + plateia.nome);
	}
}).error(function() {
	throw "Parei! Vou vender coco na praia.";
})
```

> **AngularJS** é poderoso framework MVC para javascript mantido por uma empresinha aí ( Google ) que utiliza da forma correta os conceitos de HTML/HTML5 e manipulação de DOM.

> **ECMAScript 5.1** é só a base do Javascript, com alguns recursos bem interessantes e graças às pressões de mercado presente nos browsers mais modernos.

# Quem?

## Palestrante

> Klederson Bueno
> klederson@klederson.com
> Rio Branco/AC <-> Goiania/GO

## Empresa

iFind Platform ( http://ifind.io )

## Minicurrículo
Arquiteto de Sistemas, Evangelista PHP, Pai, Marido, levantador de copo profissional.

* Ernst & Young / Axia Value Chain
* Ci&T / Accenture / Inter.net
* Privalia / Super Exclusivo / Coquelux
* DHL / Wal*Mart / Perdigão
* e mais algumas outras

Criador, idealizador e mantenedor do Framework PhpBURN. Especializado em desenvolvimento de sistemas customizados de alta complexidade, idealizador da rede de notícias ALEAC.net, um complexo de 47 sites integrados entre si trazendo noticias em tempo real de todos os municípios do Estado do Acre em um projeto pioneiro no Brasil e um grande case OpenSource.

Trabalhou no Brasil e fora, tendo sido o responsável pela migração de todo o CRM da multinacional Privalia da Espanha para o Brasil. Entusiasta SCRUM e acredita que sem um bom trabalho em equipe não existe um bom projeto.

Trabalhou em mais de 200 projetos dos mais diversos tipos incluindo Sistemas de Rastreamento de carga para DHL e WalMart utilizando SOA e APIs Google e MapLink, Sistemas de CallCenter, Integração SAP PI/XI, e diversos outros segmentos.

Evangelizador PHP, grande entusiasta de tecnologia e NERD.
Especializações:Destaca-se por solucionar problemas de forma rápida e eficiente. Sabe conciliar um excelente desenvolvimento à necessidade comercial ( produto ideal vs produto lucrativo vs satisfação final ).
