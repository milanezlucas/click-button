# Click Button

Projeto contém dois plugins, sendo um para adicionar um shortcode com um botão na página e outro para gerar um relatório de cliques no botão via WP-CLI.

## Clube do Valor - Botão

Adiciona o shortcode com o botão e contador de hits utilizando a base da instalação do WordPress. Para utilizar o botão em qualquer página ou post do site/blog basta inserir o seguinte shortcode no conteúdo:

```
[click_button]
```

## Clube do Valor - Relatório de cliques

Ativando o plugin é possível ver os cliques mais recentes no botão do shortcode `[click_button]` utilizando o WP-CLI.

Para visualizar o relatório com os cliques mais recentes basta utilizar o comando:

```
$ wp click-button-report
```

Também é possível visualizar mais cliques do que o limite padrão de 10 registros, basta usar o argumento `limit`. Onde é possível definir um limite de registros recentes para serem visualizados.

```
$ wp click-button-report --limit=100
```
---
Para uma documentação mais detalhada do projeto basta acessar o link: https://milanezlucas.notion.site/Desafio-T-cnico-47b6d3f72902424282cb17585893009e