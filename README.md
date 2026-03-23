# 🏥 Sistema de Controle de Estoque - Hospital Municipal de Igarassu-PE

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)

## 📋 Sobre o Projeto

O **Sistema de Controle de Estoque** foi desenvolvido especialmente para o **Hospital Municipal de Igarassu-PE**, com o objetivo de modernizar e otimizar a gestão de materiais e insumos hospitalares. O sistema oferece uma solução completa para controle de entradas, saídas, notas fiscais e gerenciamento de usuários, garantindo maior eficiência e transparência na administração do estoque.

### 🎯 Objetivos do Projeto

- ✅ Digitalizar e automatizar o controle de estoque hospitalar
- ✅ Reduzir perdas e desperdícios de materiais
- ✅ Garantir rastreabilidade de todas as movimentações
- ✅ Facilitar a gestão de notas fiscais e documentos
- ✅ Controlar prazos de validade e estoque mínimo
- ✅ Melhorar a tomada de decisão com relatórios gerenciais
- ✅ Garantir segurança e controle de acesso por usuários

## 🚀 Tecnologias Utilizadas

### Backend
| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white) | 8.2 | Linguagem de programação principal |
| ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white) | 12.x | Framework PHP para desenvolvimento web |
| ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) | 8.0 | Banco de dados relacional |
| ![Composer](https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white) | 2.x | Gerenciador de dependências PHP |

### Frontend
| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| ![TailwindCSS](https://img.shields.io/badge/TailwindCSS-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white) | 3.x | Framework CSS utilitário |
| ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) | ES6 | Linguagem de programação frontend |
| ![Font Awesome](https://img.shields.io/badge/Font_Awesome-339AF0?style=flat-square&logo=fontawesome&logoColor=white) | 6.x | Biblioteca de ícones |
| ![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=flat-square&logo=alpinedotjs&logoColor=white) | 3.x | Framework JavaScript leve |

### Ferramentas de Desenvolvimento
| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| ![VS Code](https://img.shields.io/badge/VS_Code-007ACC?style=flat-square&logo=visual-studio-code&logoColor=white) | Latest | Editor de código |
| ![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite&logoColor=white) | 5.x | Build tool e bundler |
| ![Git](https://img.shields.io/badge/Git-F05032?style=flat-square&logo=git&logoColor=white) | 2.x | Controle de versão |
| ![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white) | - | Repositório remoto |
| ![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=flat-square&logo=xampp&logoColor=white) | 8.x | Ambiente de desenvolvimento local |

### Pacotes Laravel Utilizados
- **Laravel Breeze** - Autenticação simples e elegante
- **Laravel Tinker** - Interação com o banco de dados via linha de comando
- **Laravel Sail** - Ambiente Docker para desenvolvimento
- **Laravel Pint** - Formatação de código PHP
- **Laravel Pail** - Visualização de logs no terminal

## 📦 Funcionalidades Implementadas

### 🔐 Autenticação e Usuários
- ✅ Login seguro com autenticação de usuários
- ✅ Cadastro, edição e exclusão de usuários
- ✅ Proteção de rotas por autenticação
- ✅ Sistema de "lembrar-me" para acesso rápido
- ✅ Perfil de usuário com edição de dados

### 📊 Dashboard
- ✅ Visão geral do estoque com cards informativos
- ✅ Total de produtos cadastrados
- ✅ Alertas de produtos com estoque baixo
- ✅ Valor total do estoque
- ✅ Movimentações do dia (entradas e saídas)
- ✅ Últimas movimentações realizadas
- ✅ Ações rápidas para entrada/saída/ajuste de estoque

### 🏷️ Categorias
- ✅ CRUD completo de categorias
- ✅ Controle de ativação/desativação
- ✅ Filtro por status
- ✅ Validação de dados

### 🚚 Fornecedores
- ✅ CRUD completo de fornecedores
- ✅ Campos completos (CNPJ, telefone, endereço, etc.)
- ✅ Máscaras para campos (CNPJ, telefone, CEP)
- ✅ Validação de CNPJ único
- ✅ Visualização de produtos por fornecedor
- ✅ Histórico de notas fiscais por fornecedor

### 📦 Produtos
- ✅ CRUD completo de produtos
- ✅ Controle de preços (compra, venda, promocional)
- ✅ Gerenciamento de estoque mínimo e máximo
- ✅ Código de barras e SKU
- ✅ Unidade de medida
- ✅ Localização no estoque
- ✅ Filtros avançados (busca, categoria, estoque baixo)
- ✅ Alertas visuais de estoque crítico

### 📊 Movimentações de Estoque
- ✅ Entrada de produtos no estoque
- ✅ Saída de produtos com validação de estoque
- ✅ Ajuste de estoque para correções
- ✅ Histórico completo de movimentações
- ✅ Filtros por período, produto e tipo de movimento
- ✅ Registro de motivo e documento

### 📄 Notas Fiscais
- ✅ Cadastro de notas fiscais de entrada e saída
- ✅ Campos fiscais completos (ICMS, IPI, PIS, COFINS)
- ✅ Itens da nota fiscal com produtos
- ✅ Processamento automático de entrada no estoque
- ✅ Validação de chave de acesso
- ✅ Armazenamento de XML (opcional)
- ✅ Relação com fornecedores

### 👥 Gerenciamento de Usuários
- ✅ Criação de novos usuários
- ✅ Edição de dados
- ✅ Alteração de senha
- ✅ Exclusão segura (não permite auto-exclusão)
- ✅ Listagem paginada

## 🎨 Design e Interface

### Layout Moderno e Responsivo
- 🎨 **Gradientes animados** na tela de login
- 🖼️ **Logo personalizada** no cabeçalho e sidebar
- 🎯 **Ícones coloridos** com fundo suave para cada menu
- 📱 **Design responsivo** para desktop e tablets
- ✨ **Animações suaves** em hover e transições
- 🎪 **Cards animados** com efeitos de elevação
- 🔄 **Scrollbar personalizada** com gradiente

### Paleta de Cores
- 🟣 **Roxo/Lilás** - Gradiente principal (#667eea → #764ba2)
- 🔵 **Azul** - Dashboard e ações principais
- 🟢 **Verde** - Entradas e confirmações
- 🔴 **Vermelho** - Saídas e exclusões
- 🟡 **Amarelo** - Alertas e ajustes

## 🏗️ Arquitetura do Sistema

### Estrutura MVC
