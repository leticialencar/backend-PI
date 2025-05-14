<?php

class ViaCep {
    private $cep;
    private $dados = [];

    public function __construct($cep) {
        $this->cep = preg_replace('/[^0-9]/', '', $cep); 
    }

    public function getDados() {
        return $this->dados;
    }

    public function getRua() {
        return $this->dados['logradouro'] ?? '';
    }

    public function getBairro() {
        return $this->dados['bairro'] ?? '';
    }

    public function getCidade() {
        return $this->dados['localidade'] ?? '';
    }

    public function getEstado() {
        return $this->dados['uf'] ?? '';
    }

    public function buscarCep() {
        $url = "https://viacep.com.br/ws/{$this->cep}/json/";
        
        $response = file_get_contents($url);

        if ($response === FALSE) {
            throw new Exception("Não foi possível salvar o endereço. Verifique o CEP informado.");
        }
    
        $this->dados = json_decode($response, true);
    
        if (isset($this->dados['erro'])) {
            throw new Exception("Não foi possível salvar o endereço. CEP não encontrado.");
        }
    }    
}