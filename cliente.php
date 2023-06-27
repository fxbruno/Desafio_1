<?php
class Cliente {
    private $id;
    private $nome;
    private $idade;
    private $email;
    private $endereco_cobranca;
    private $endereco_entrega;

    public function __construct($id, $nome, $idade, $email, $endereco_cobranca, $endereco_entrega = array()) {
        $this->id = $id;
        $this->nome = $nome;
        $this->idade = $idade;
        $this->email = $email;
        $this->endereco_cobranca = $endereco_cobranca;
        $this->endereco_entrega = $endereco_entrega;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getIdade() {
        return $this->idade;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getEndereco_cobranca() {
        return $this->endereco_cobranca;
    }
    public function getEndereco_entrega() {
        return $this->endereco_entrega;
    }


    public function adicionarEndereco_cobranca($endereco) {
        $this->endereco_cobranca[] = $endereco;
    }
    public function adicionarEndereco_entrega($endereco) {
        $this->endereco_entrega[] = $endereco;
    }

    public function removerEndereco($endereco) {
        $indice = array_search($endereco, $this->endereco_entrega);
        if ($indice !== false) {
            unset($this->endereco_entrega[$indice]);
        }
    }
}
?>
